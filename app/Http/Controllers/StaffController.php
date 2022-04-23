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
use App\Purchase;
use App\User;
use PDF;
use Carbon\Carbon;
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
       return view('staff/home',['datas' => $datas,'today_bill_count'=>$today_bill_count,'today_bill_value'=>$today_bill_value,
	   'today_bill_source'=>$today_bill_source]);
    }
    public function staff_sales()
    {
        $datas=Sales::where('branch_id',Auth::user()->branch_id)->orderby('id','desc')->where('status',1)->get();
        return view('staff/sales',['datas' => $datas]);
    }
    public function products(){
        $branch_id=Auth::user()->branch_id;
        $datas = Products::where('status', 1)->where('branch_id',$branch_id)->orderBy('id', 'desc')->get();
        return view('staff/products', ['datas' => $datas]);
    }
    public function update_product_status(Request $request){
        DB::table('products')->where('id',$request->post('id'))->update(['approved_status'=>$request->post('status'),'comments'=>$request->post('comments')]);
        Session::flash('success', 'Status Updated Successfully');
        return Redirect::back();
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
       //echo "<pre>"; print_r($branch_employees);exit;
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
		  $data['in_tamilnadu']=Branches::where('branch_id',$data['payment_details']->branch_id)->select('in_tamilnadu')->first();
          $data['products']=Invoice::where('invoice_id',$invoice_id)->get();
		  $query =DB::table('products as p')->join('invoice as i','i.sku','=','p.sku')->where('i.invoice_id',$invoice_id)
		  ->selectRaw('sum(i.price * i.quantity) as total_amt,sum(p.igst) as total_igst,sum(p.cgst) as total_cgst,sum(p.sgst) as total_sgst,igst,cgst,sgst');
		  $query = ($data['in_tamilnadu']->in_tamilnadu=="yes") ?  $query->groupBy('p.cgst') :   $query->groupBy('p.igst');
          $data['tax_data']= $query->get();
		  //echo "<pre>";dd($data);exit;
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
        $data = DB::table('products')->where('sku',$query)->where('branch_id',Auth::user()->branch_id)->where('approved_status',2)->get();
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
        $invoice = Invoice::where('invoice_id', $invoice_id)->get();
        if($invoice)
        {
            $branch_employees=User::where('branch_id',Auth::user()->branch_id)->select('emp_id','name')->get(); 
            $customer_data = Sales::where('invoice_id', $invoice_id)->get();
            return view('staff/invoice', ['datas' => $invoice, 'data' => $customer_data,'branch_employees' => $branch_employees]);
        }
        else
        {
            return Redirect::back()->with('error','No Data Found');
        }
    }
    public function product_exchange(Request $request)
    {
        $exchange=Invoice::where('id', $request->post('id'))->where('exchange_type',null)->update(['exchange_date'=>date('Y-m-d h:i:s'),'exchange_type'=>$request->post('exchange_type'),
        'exchange_process_by'=>$request->post('exchange_process_by'),'commends'=>$request->post('commends')]);
        if($exchange)
        {
           $product_qty=Invoice::where('id', $request->post('id'))->select('quantity','sku')->first();
           Products::where('sku',$product_qty->sku)->increment('quantity',$product_qty->quantity);
           return Redirect::back()->with('success','Exchange Processed Successfully'); 
        }
        else
        {
            return Redirect::back()->with('error','Something is went to wrong');
        }
    }

}

