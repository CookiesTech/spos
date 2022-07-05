<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Session;
use Auth;
use DB;
use File;
use App\Branches;
use App\Employees;
use App\Attendance;
use App\Category;
use App\Products;
use App\Sales;
use App\Invoice;
use App\Sales_Exchange;
use App\Purchase;
use App\User;
use PDF;
use Carbon\Carbon;
use DateTime;
use Yajra\DataTables\DataTables;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('Staff');
    }
    public function index()
    {
        $today_bill_count=Sales::where('branch_id',Auth::user()->branch_id)->whereDate('created_at', Carbon::today())->count();
        $today_bill_value=Sales::where('branch_id',Auth::user()->branch_id)->whereDate('created_at', Carbon::today())->sum('total_amount');
        $today_bill_source=Sales::where('branch_id',Auth::user()->branch_id)->whereDate('created_at', Carbon::today())
		->selectRaw('payment_mode,sum(total_amount) as total_amt')->groupBy('payment_mode')->get();
        $datas=Sales::where('branch_id',Auth::user()->branch_id)->whereDate('created_at', Carbon::today())->orderby('id','desc')
		->where('status',1)->limit(10)->get();
        $today_target_data=DB::table('employee_target as t')->select('e.fname','t.date','t.emp_id','t.target_amt','t.carry_forward_amt',DB::raw('IFNULL(d.branch_id,"-") as branch_id'),DB::raw('IFNULL(d.day_sales_value, 0) as day_sales_value'),DB::raw('IFNULL(d.day_sales_count, 0) as day_sales_count'))
        ->leftJoin('employee_day_sale as d', function($join) {
            $join->on('t.emp_id', '=', 'd.emp_id') 
             ->on('t.date', '=', 'd.invoice_date');
          })
        ->leftjoin('employees as e','e.emp_id','=','t.emp_id')
        ->where('e.branch_id',Auth::user()->branch_id)
        ->whereDate('t.date', Carbon::today())->groupBy('t.date','t.emp_id')->get();
       return view('staff/home',['datas' => $datas,'today_bill_count'=>$today_bill_count,'today_bill_value'=>$today_bill_value,
	   'today_bill_source'=>$today_bill_source,'today_target_data'=>$today_target_data]);
    }
    public function staff_sales(Request $request)
    {
        if($request->ajax()){      
            $sales = Sales::select(array(
                'invoice_id', 'customer_name', 'payment_mode', 'payable_amount', 'balance','total_amount','created_at','id'
            ))->where('branch_id',Auth::user()->branch_id)->orderby('id','desc')->where('status',1)->get();
            return Datatables::of($sales)
            ->addColumn('action', function($row){
                $btn = '<a href="'.url('staff/invoice').'/'.$row->invoice_id.'" class="btn btn-primary" ><i class="os-icon os-icon-ui-49">View</i></a>';  
                return $btn;
            })
            ->editColumn('created_at', function($data){
                $formatedDate = date('d-m-Y H:i:s', strtotime($data->created_at)); 
                return $formatedDate; 
            })
            ->rawColumns(['action','branch_id'])
            ->make(true);
        }
        return view('staff/sales');
    }
    public function products(Request $request){
        if($request->ajax()){ 
            $branch_id=Auth::user()->branch_id;
            $products = Products::select(array(
                'product_name', 'quantity', 'discount_price', 'sku', 'cid','branch_id','stock_status','approved_status','comments','id',
            ))->where('status', 1)->where('branch_id',$branch_id);
            return Datatables::of($products)
            ->addColumn('action', function($data){
                if($data->approved_status!=2)
                    $btn='<button class="btn btn-primary approve_product" data-id="'.$data->id.'" type="button"><i class="os-icon os-icon-ui-49">Edit</i></button>';
                else
                    $btn='<span class="label label-success">Status Approved</span>';
                return $btn;
            })
            ->addColumn('checkbox', function($data){
                $btn = '<input type="checkbox" class="checkbox" value="'.$data->id.'" name="id[]">';  
                return $btn;
            })
            ->editColumn('stock_status', function($data){
                $btn = ($data->quantity< 2) ?'<span class="label label-danger">'.$data->stock_status.'</span>' : '<span class="label label-success">'.$data->stock_status.'</span>';  
                return $btn;
            })
            ->rawColumns(['action','stock_status'])
            ->make(true);
        }
        return view('staff/products');
    }
    public function update_product_status(Request $request){
        DB::table('products')->where('id',$request->post('id'))->update(['approved_status'=>$request->post('status'),'comments'=>$request->post('comments')]);
        return Response::json(array('status'=>true), 200);
    }
    public static function get_attendence_info($emp_id){        
         $data=DB::table('attendance')->where('emp_id',$emp_id)->select('clock_out_date','clock_in_date')->orderBy('id','desc')->first();
         return $data;
    }
    public function staff_clockin(){
        $emp_id=Auth::user()->emp_id; 
        $clin_date=date('Y-m-d h:i:s');
        $id=DB::table('attendance')->insertGetId(['emp_id'=>$emp_id,'status'=>'Present','clock_in_date'=>$clin_date]);
        return 1;        
    }
    public function staff_clockout(Request $request){
        $data=DB::table('attendance')->where('emp_id',Auth::user()->emp_id)->where('clock_out_date','=',NULL)->select('clock_out_date','clock_in_date','id')->orderBy('id','desc')->first();
        $last_id=$data->id;        
        $clout_date=date('Y-m-d h:i:s');
        $data=DB::table('attendance')->where('id',$last_id)->first();
       $time = new Carbon($data->clock_in_date);
       $shift_end_time =new Carbon($clout_date);        
       $minutes= $time->diffInMinutes($shift_end_time);
       $hours = floor($minutes / 60).':'.($minutes -   floor($minutes / 60) * 60);
       $total_time=$hours;
        DB::table('attendance')->where('id',$last_id)->update(['clock_out_date'=>$clout_date,'total_time'=>$total_time,'date'=>date('Y-m-d')]);
         return 1;
    }
    public function staff_pos()
    {
        $branch_employees=User::where('branch_id',Auth::user()->branch_id)->where('status',1)->select('emp_id','name')->get(); 
        return view('staff/pos', ['branch_employees' => $branch_employees]);
    }
    public function create_invoice_staff(Request $request)  
    {
        try 
        {
            DB::beginTransaction();
            $price = $request->input('productprice');
            $amount = $request->input('costprice');
            $qty = $request->input('quantity');
            $sku = $request->input('sku');
            if(!$sku)
            {
                DB::rollback();
                return redirect('staff/staff_pos')->with('error','Select Product First'); 
            }
            $id = $request->input('id');
            $invoice_id = DB::table('invoice')->count();
            if ($invoice_id > 0) {
                $invoice_id = DB::table('invoice')->orderBy('id', 'desc')->first();
                $data = explode('-', $invoice_id->invoice_id);
                $ids = $data[1];
                $invoice_id = $ids + 1;
                $invoice_id = 'S-' . $invoice_id;
            } else {
                $invoice_id = 'S-1';
            }
            $i = 0; $total=0;
            $product_data = array();
            foreach ($request->input('productnames') as $key => $name) {
                $total=$total+($price[$key] * $qty[$key]);
                $data1 = new Invoice();
                $data1->invoice_id = $invoice_id;
                $data1->quantity = $qty[$key];
                $data1->price = $price[$key];
                $data1->amount = $amount[$key];
                $data1->product_name = $name;
                $data1->sku = $sku[$key];
                $data1->branch_id = Auth::user()->branch_id;
                $data1->emp_id =$request->input('emp_id');
                if(!$data1->save())
                {
                  DB::rollback();
                }
                $i++;
                //update quantity update
                $get_exist_qty=DB::table('products')->select('quantity')->where('id',$id[$key])->where('quantity','>',0)->first();
                if($get_exist_qty)
                {
                 if($qty[$key]<=$get_exist_qty->quantity)
                 {
                     $update_qty=$get_exist_qty->quantity-$qty[$key];
                     $update=DB::table('products')->where('id',$id[$key])->update(['quantity'=>$update_qty]);
                 }
                }
            }
            
            $data = new Sales();
            $data->invoice_id = $invoice_id;
            $data->branch_id = Auth::user()->branch_id;
            $data->emp_id =$request->input('emp_id');
            $data->phone = $request->input('phone');
            $data->payment_mode = $request->input('mode');
            $data->payable_amount = $request->input('amountreceived');
            $data->balance = $request->input('balance');
            $data->total_amount =$total;
            $data->customer_name =$request->input('customer_name');
            $data->date = date('Y-m-d');
            if($data->save())
            {
                DB::commit();
              return redirect('staff/print-bill/'.$invoice_id);
            }
            else
            {
                DB::rollback();
                return redirect('staff/staff_pos')->with('error','SomeThink is went to wrong try again');
            }
       }
       catch(\Exception $e) 
       {
         DB::rollback();
         return redirect('staff/staff_pos')->with('error','SomeThink is went to wrong try again');
       }
    }
     public function print_bill($invoice_id)
    {
		  $data['payment_details']=Sales::where('invoice_id',$invoice_id)->first();
		  $data['branch_details']=Branches::where('branch_id',$data['payment_details']->branch_id)->first();
          $data['products']=Invoice::where('invoice_id',$invoice_id)->get();
		  $query =DB::table('products as p')->join('invoice as i','i.sku','=','p.sku')->where('i.invoice_id',$invoice_id)
		  ->selectRaw('sum(i.price * i.quantity) as total_amt,sum(p.igst) as total_igst,sum(p.cgst) as total_cgst,sum(p.sgst) as total_sgst,igst,cgst,sgst');
		  $query = ($data['branch_details']->in_tamilnadu=="yes") ?  $query->groupBy('p.cgst') :   $query->groupBy('p.igst');
          $data['tax_data']= $query->get();
          if($data['payment_details'])
          {
              return view('staff/print-bill',$data);
          }
          else
          {
            return Redirect::back()->with('error','No Data Found');
          }
    }
    public function getProductsBySku() {
        $query = Input::get('sku');
        $data = DB::table('products')->where('sku',$query)->where('branch_id',Auth::user()->branch_id)->where('quantity','>',0)->where('approved_status',2)->get();
        return Response::json($data, 200);
    }
    public function staff_timecards()
    {
        $data=DB::table('attendance')->whereMonth('clock_in_date',Carbon::now()->month)->where('emp_id',Auth::user()->emp_id)->orderBy('id','desc')->get();
	     return view('staff/staff_timecards', ['datas' => $data]);
    }
	public static function search_staff_timecards(Request $res){
     //echo $res->post('from');exit;		 
	 $data=DB::table('attendance')->whereBetween('clock_in_date',[$res->post('from'),$res->post('to')])->where('emp_id',Auth::user()->emp_id)->select('*')->orderBy('id','desc')->get();
	  return view('staff/staff_timecards', ['datas' => $data]);
	}
	public function invoice($invoice_id) 
	{
        $invoice = Invoice::where('invoice_id', $invoice_id)->orderBy('sku')->get();
        if($invoice)
        {
            $branch_employees=User::where('branch_id',Auth::user()->branch_id)->select('emp_id','name')->get(); 
            $sale_data = Sales::where('invoice_id', $invoice_id)->get();
            $sales_exchange_data = Sales_Exchange::where('invoice_id', $invoice_id)->orderBy('sku')->get();
            return view('staff/invoice', ['datas' => $invoice, 'data' => $sale_data,'sales_exchange_data'=>$sales_exchange_data,'branch_employees' => $branch_employees]);
        }
        else
        {
            return Redirect::back()->with('error','No Data Found');
        }
    }
    public function product_exchange(Request $request)
    {
        $data = new Sales_Exchange();
        $data->invoice_id = $request->post('invoice_id');
        $data->sku = $request->post('sku');
        $data->branch_id = Auth::user()->branch_id;
        $data->exchange_process_by =$request->post('exchange_process_by');
        $data->exchange_date = date('Y-m-d h:i:s');
        $data->exchange_type = $request->post('exchange_type');
        $data->commends = $request->post('commends');
        $data->exchange_qty = $request->post('exchange_qunatity');
        if($data->save())
        {
            $exchange=Invoice::where('id', $request->post('id'))->increment('exchange_qty',$request->post('exchange_qunatity'));
            $product_qty=Invoice::where('id', $request->post('id'))->select('quantity','sku')->first();
            Products::where('sku',$product_qty->sku)->increment('quantity',$request->post('exchange_qunatity'));
            return Redirect::back()->with('success','Exchange Processed Successfully'); 
        }
        else
        {
            return Redirect::back()->with('error','Something is went to wrong');
        }
    }
    public function sales_target(Request $request)
    {
        if($request->ajax()){  
            $start = new DateTime("first day of last month");
            $end =date('Y-m-t');
            $target_data=DB::table('employee_target as t')->select('e.fname','t.date','t.emp_id','t.target_amt','t.carry_forward_amt',DB::raw('IFNULL(d.branch_id,"-") as branch_id'),DB::raw('IFNULL(d.day_sales_value, 0) as day_sales_value'),DB::raw('IFNULL(d.day_sales_count, 0) as day_sales_count'))
            ->leftJoin('employee_day_sale as d', function($join) {
                $join->on('t.emp_id', '=', 'd.emp_id') 
                 ->on('t.date', '=', 'd.invoice_date');
              })
            ->leftjoin('employees as e','e.emp_id','=','t.emp_id')
            ->where('e.branch_id',Auth::user()->branch_id) ->whereBetween('t.date', [$start, $end])->groupBy('t.date','t.emp_id');
            return Datatables::of($target_data)
            ->editColumn('emp_id', function($data){
                return $data->fname.'('.$data->emp_id.')';
            })
            ->addColumn('blance_target_amt', function($row){
                $balance=0;
                $total_target=$row->target_amt;
                if($row->day_sales_value > $total_target)
                    $btn='<span class="label label-success">'.($row->day_sales_value-$total_target).'</span>';
                else
                    $btn='<span class="label label-danger">'.($total_target-$row->day_sales_value).'</span>';
                return $btn;
            })
            ->rawColumns(['blance_target_amt'])
            ->make(true);
        }
        return view('staff/sales_target');
    }
    public function request(Request $request) {
        $data['branch_employees']=User::where('branch_id',Auth::user()->branch_id)->where('status',1)->select('emp_id','name')->get(); 
        if($request->ajax()){ 
            $branch_id=Auth::user()->branch_id;
            $emp_request = DB::table('emp_request')->select(array('emp_id', 'request', 'created_at','branch_id','status','id'))->where('branch_id',$branch_id);
            return Datatables::of($emp_request)
            ->addColumn('action', function($data){
                $btn='<button class="btn btn-primary view_request" data-emp_id="'.$data->emp_id.'"   data-request="'.$data->request.'" type="button"><i class="os-icon os-icon-ui-49">View</i></button>';
                return $btn;
            })
            ->editColumn('status', function($data){
                $btn = ($data->status =="Pending") ?'<span class="label label-danger">'.$data->status.'</span>' : '<span class="label label-success">'.$data->status.'</span>';  
                return $btn;
            })
            ->editColumn('created_at', function($data){
                $formatedDate = date('d-m-Y H:i:s', strtotime($data->created_at)); 
                return $formatedDate; 
            })
            ->editColumn('request', function($data){
                $request =$out = strlen($data->request) > 50 ? substr($data->request,0,50)."..." : $data->request; 
                return $request; 
            })
            ->editColumn('branch_id', function($data){
                $branch = $this->get_branch_name($data->branch_id);
                return $branch->name.'('.$data->branch_id.')';
            })
            ->editColumn('emp_id', function($data){
                $emp_name = $this->get_emp_name($data->emp_id);
                return $emp_name->fname.'('.$data->emp_id.')';
            })
            ->rawColumns(['action','status','created_at','branch_id'])
            ->make(true);
        }
        return view('staff/request',$data);
    }
    public function add_request(Request $request){
        DB::table('emp_request')->insert(['branch_id'=>Auth::user()->branch_id,'emp_id'=>$request->post('emp_id'),'request'=>$request->post('request')]);
        return Response::json(array('status'=>true), 200);
    }
    public static function get_branch_name($branch_id) {
        $data = Branches::where('branch_id', $branch_id)->first();
        return $data;
    }
    public static function get_emp_name($emp_id) {
        $data = Employees::where('emp_id', $emp_id)->first();
        return $data;
    }
}

