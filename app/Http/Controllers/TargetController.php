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
use App\User;
use App\Branches;
use App\Employees;
use  App\Target;
use DateTime;
use Yajra\DataTables\DataTables;
class TargetController extends Controller {

    public function __construct() {
        $this->middleware('Admin');
        setlocale(LC_MONETARY, 'en_IN');
    }
    public function target(Request $request)
    {
        $data['employees'] =Employees::where('role','staff')->where('status','Active')->select('emp_id','fname as name')->get();
        $data['branches']=Branches::all();
        if($request->ajax()){ 
            $target_data=DB::table('employee_target as t')->select('t.date','t.emp_id','t.target_amt','t.carry_forward_amt',DB::raw('IFNULL(d.branch_id,"-") as branch_id'),DB::raw('IFNULL(d.day_sales_value, 0) as day_sales_value'),DB::raw('IFNULL(d.day_sales_count, 0) as day_sales_count'))
            ->leftJoin('employee_day_sale as d', function($join) {
                $join->on('t.emp_id', '=', 'd.emp_id') 
                 ->on('t.date', '=', 'd.invoice_date');
              });
            //Filter
            if(empty(Input::get('from_date')) && empty(Input::get('to_date')))
            {
                $start = new DateTime("first day of last month");
                $end =date('Y-m-t');
            }
            else
            {
                $start = Input::get('from_date');
                $end =Input::get('to_date');
            }
            if(Input::get('branch_id')!='all')
                $target_data = $target_data->where('d.branch_id',Input::get('branch_id'));
            if(Input::get('emp_id')!='all')
                $target_data = $target_data->where('t.emp_id',Input::get('emp_id'));

            $target_data =  $target_data->whereBetween('t.date', [$start, $end])->get();
            return Datatables::of($target_data)
            ->addColumn('blance', function($row){
                $balance=0;
                $total_target=$row->target_amt;
                if($row->day_sales_value > $total_target)
                    $btn='<span class="label label-success">'.($row->day_sales_value-$total_target).'</span>';
                else
                    $btn='<span class="label label-danger">'.($total_target-$row->day_sales_value).'</span>';
                return $btn;
            })
            ->editColumn('branch_id', function($data){
                $branch = $this->get_branch_name($data->branch_id);
                return $branch->name.'('.$data->branch_id.')';
            })
            ->editColumn('emp_id', function($data){
                $emp_name = $this->get_emp_name($data->emp_id);
                return $emp_name->fname.'('.$data->emp_id.')';
            })
            ->rawColumns(['blance'])
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
                $carry_forward_amt=$get_last_target_data->target_amt+$get_last_target_data->carry_forward_amt;
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
    public static function get_branch_name($branch_id) {
        $data = Branches::where('branch_id', $branch_id)->first();
        return $data;
    }
    public static function get_emp_name($emp_id) {
        $data = Employees::where('emp_id', $emp_id)->first();
        return $data;
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