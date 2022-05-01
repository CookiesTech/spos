<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Session;
use Auth;
use DB;
use File;
use Barryvdh\DomPDF\Facade as PDF;
use App\User;
use  App\Target;
use Carbon\Carbon;
use DateTime;
use Yajra\DataTables\DataTables;
class TargetController extends Controller {

    public function __construct() {
        $this->middleware('Admin');
        setlocale(LC_MONETARY, 'en_IN');
    }

    public function target(Request $request)
    {
        $data['employees']=DB::table('employees')->where('status','Active')->get();
        if($request->ajax()){  
            $target_data=DB::table('employee_target as t')->select('t.date','t.emp_id','t.target_amt','t.carry_forward_amt',DB::raw('IFNULL(d.branch_id,"-") as branch_id'),DB::raw('IFNULL(d.day_sales_value, 0) as day_sales_value'),DB::raw('IFNULL(d.day_sales_count, 0) as day_sales_count'))->leftjoin('employee_day_sale as d','d.invoice_date','=','t.date')->whereMonth('t.date', date('m'))->groupBy('t.date','t.emp_id')->get();
            return Datatables::of($target_data)
            ->addColumn('total_target', function($row){
                return $row->target_amt+$row->carry_forward_amt;
            })
            ->addColumn('blance_target_amt', function($row){
                $balance=0;
                $total_target=$row->target_amt+$row->carry_forward_amt;
                if($row->day_sales_value > $total_target)
                    $btn='<span class="label label-success">'.($row->day_sales_value-$total_target).'</span>';
                else
                    $btn='<span class="label label-danger">'.($total_target-$row->day_sales_value).'</span>';
                return $btn;
            })
            ->rawColumns(['blance_target_amt','total_target'])
            ->make(true);
        }
        return view('target_sheet',$data);
    }
    public function add_target(Request $request)
    {
        $carry_forward_amt=0;
        $last_carry_forward_amt=0;
        //  check_already_set_target_this_user based on emp_id & Date
        $check =Target::where('emp_id',Input::get('emp_id'))->where('date',Input::get('date'))->count();
        if($check>0)
        {
            echo json_encode(array('status'=>false,'message'=>'Already Target Set to This Employee.'));
            exit;
        }
        //Get Carry Forward Target Amount Calculation 
        $get_last_target_data=DB::table('employee_target as t')->where('t.emp_id',Input::get('emp_id'))->select('d.day_sales_value','t.target_amt','t.carry_forward_amt')->leftjoin('employee_day_sale as d','d.invoice_date','=','t.date')->latest()->first();
        if($get_last_target_data)
        {
            if($get_last_target_data->day_sales_value>0)
            {
                $carry_forward_amt=($get_last_target_data->day_sales_value < $get_last_target_data->target_amt) ? ($get_last_target_data->target_amt - $get_last_target_data->day_sales_value) : 0;
                if($carry_forward_amt>0)
                    $last_carry_forward_amt=$get_last_target_data->carry_forward_amt;
            }
            else
            {
                $carry_forward_amt=$get_last_target_data->target_amt;
            }
                
        }
        $data = new Target();
		$data->emp_id =  Input::get('emp_id');
        $data->date = Input::get('date');
        $data->target_amt = Input::get('amount');
        $data->carry_forward_amt=$carry_forward_amt+$last_carry_forward_amt;
        if($data->save())
            echo json_encode(array('status'=>true));
        else
            echo json_encode(array('status'=>false));
    }
    public function update_target(Request $request)
    {
        $data = Target::find(3);
		$data->emp_id =  Input::get('emp_id');
        $data->date = Input::get('date');
        $data->target_amount = Input::get('amount');
        if($data->save())
            echo json_encode(array('status'=>true));
        else
            echo json_encode(array('status'=>false));
    }
}