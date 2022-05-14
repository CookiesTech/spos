<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;
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
use App\Branches;
use App\Employees;
use App\Attendance;
use App\Category;
use App\Products;
use App\Sales;
use App\Invoice;
use App\Purchase;
use App\Sales_Exchange;
use Barryvdh\DomPDF\Facade as PDF;
use App\User;
use Carbon\Carbon;
use DateTime;
use Yajra\DataTables\DataTables;

class HomeController extends Controller {

    public function __construct() {
        $this->middleware('Admin');
        setlocale(LC_MONETARY, 'en_IN');
    }

    public function index() {
        $pcount = Products::count();
        $today_bill_count=Sales::whereDate('created_at', Carbon::today())->count();
        $today_bill_value=Sales::whereDate('created_at', Carbon::today())->sum('payable_amount');
        $today_bill_source=Sales::whereDate('created_at', Carbon::today())->selectRaw('payment_mode,sum(total_amount) as total_amt')->groupBy('payment_mode')->get();
        $sales =Sales::whereDate('created_at', Carbon::today())->orderBy('id', 'DESC')->limit(10)->get();
        $today_target_data=DB::table('employee_target as t')->select('e.fname','t.date','t.emp_id','t.target_amt','t.carry_forward_amt',DB::raw('IFNULL(d.branch_id,"-") as branch_id'),DB::raw('IFNULL(d.day_sales_value, 0) as day_sales_value'),DB::raw('IFNULL(d.day_sales_count, 0) as day_sales_count'))
        ->leftJoin('employee_day_sale as d', function($join) {
            $join->on('t.emp_id', '=', 'd.emp_id') 
             ->on('t.date', '=', 'd.invoice_date');
          })
        ->leftjoin('employees as e','e.emp_id','=','t.emp_id')
        ->whereDay('t.date', date('d'))->groupBy('t.date','t.emp_id')->get();
        return view('home', ['pcount' => $pcount, 'today_bill_value' => $today_bill_value, 
        'today_bill_count' => $today_bill_count, 'datas' => $sales,'today_bill_source'=>$today_bill_source,'today_target_data'=>$today_target_data]);
    }
    public function logout(Request $request) {
        Auth::logout();
        return redirect('login');
    }
    public function branches() {
        $data = Branches::all();
        return view('branches', ['datas' => $data]);
    }
    public function insert_branch(Request $request) {
		$Branches=Branches::count();
		$branch_id="BB".str_pad($Branches+1, 4, '0', STR_PAD_LEFT);
        $data = new Branches();
		$data->branch_id =$branch_id;
        $data->name = Input::get('name');
        $data->address = Input::get('address');
		$data->in_tamilnadu = Input::get('in_tamilnadu');
        $data->save();
        Session::flash('success', 'Branch Added Successfully');
        return redirect('admin/branches');
    }
	   public function update_branch(Request $request) {
		$update=Branches::where('id',$request->post('row_id'))->update(['name' =>$request->post('name'),'address'=>$request->post('address'),
		'in_tamilnadu'=>$request->post('in_tamilnadu')]);
        if($update)
		{			
           Session::flash('success', 'Branch Added Successfully');
		}
		else
		{
			Session::flash('error', 'SomeThink is went to wrong');
		}
        return redirect('admin/branches');
    }
    public function employees() {
        $data = Branches::all();
        $datas = Employees::where('status','Active')->orderBy('fname')->get();
        return view('employees', ['datas' => $datas, 'branches' => $data]);
    }
    public function insert_employee(Request $request) {
        
        $check=Employees::where('email', '=', Input::get('email'))->first();
        if(!$check)
        {
			$max_id = DB::table('employees')->count();
			$emp_id="SJ-".str_pad($max_id+1, 4, '0', STR_PAD_LEFT);
        $file = Input::file('image');
         if ($file != NULL) {
            $url=url('/').'/public/uploads/employees/';
            $destinationPath = public_path() . '/uploads/employee/'; // upload path
            $fileName = Input::file('image')->getClientOriginalName();
            $upload_path = Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
            $image=$url.$fileName;
           }
           else
           {
             $image=null;  
           }
            $data = new Employees();
            $data->fname = Input::get('fname');
            $data->lname = Input::get('lname');
            $data->email = Input::get('email');
            $data->password =Input::get('password');
            $data->phone_no = Input::get('phone_no');
            $data->address = Input::get('address');
            $data->branch_id = Input::get('branch_id');
            $data->doj = Input::get('doj');
            $data->gender = Input::get('gender');
            $data->image = $image;
            $data->permanent_address = Input::get('permanent_address');
            $data->salary = Input::get('salary');
			$data->role = Input::get('role');
			$data->bank_name = Input::get('bank');
			$data->bank_branch = Input::get('bank_branch');
			$data->ac = Input::get('ac');
            $data->ifsc = Input::get('ifsc');			
            $data->role = Input::get('role');
            $data->emp_id = $emp_id;
            $data->status = 'Active';
            $data->save();

            $emp = new User();
            $emp->name = Input::get('fname');
            $emp->email = Input::get('email');
            $emp->role = Input::get('role');
            $emp->emp_id=$emp_id;
            $emp->password =Hash::make(Input::get('password'));
            $emp->branch_id = Input::get('branch_id');
            $emp->save();
            Session::flash('success', 'New Employee Added Successfully');
            return redirect('admin/employees');
        }
        else
        {
            Session::flash('success', 'Employee email id already exists');
            return redirect('admin/employees');
        }
    }
    public function delete_employee() {
        $data = Employees::where('emp_id', Input::get('id'))->update(['status' => 'Inactive']);
        $data = User::where('emp_id', Input::get('id'))->update(['status' => 0]);
        $data1 = Employees::where('status' ,'Active')->count();
        return Response::json($data1, 200);
    }
    public function update_employee() {
        $file = Input::file('image');
        if ($file != NULL) {
            $destinationPath = 'uploads/employee/'; // upload path
            $fileName = Input::file('image')->getClientOriginalName();
            $upload_path = Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
            $image = url('/') . '/' . $upload_path;
        }
        else
        {
           $image=null;
        }
        $check=Employees::where('email', '=', Input::get('email'))->where('id','!=', Input::get('id'))->first();
        if(!$check)
        {
           $data = Employees::where('id', Input::get('id'))->update(['fname' => Input::get('fname'), 'lname' => Input::get('lname'), 
		   'email' => Input::get('email'), 'phone_no' => Input::get('phone_no'), 'address' => Input::get('address'),'password' => Input::get('password'),
		   'dob' => Input::get('dob'), 'role' => Input::get('role'), 'salary' => Input::get('salary'), 'address' => Input::get('address'), 
		   'permanent_address' => Input::get('permanent_address'), 'image' => $image, 'gender' => Input::get('gender'),'bank_name'=> Input::get('bank'),'bank_branch'=> Input::get('bank_branch'),'ac'=> Input::get('ac'),'ifsc'=> Input::get('ifsc'),'branch_id'=> Input::get('branch_id')]);
           $update_user=User::where('emp_id',Input::get('emp_id'))->update(['role' => Input::get('role'),'password' => Hash::make(Input::get('password')),
			'email' => Input::get('email'),'branch_id'=> Input::get('branch_id')]);
            Session::flash('success', 'Employee Details Updated Successfully');
            return redirect('admin/employees');
        }
        else
        {
           Session::flash('error', 'Email Id already exists.');
            return redirect('admin/employees'); 
        }
    }
    public function attendance() {
        $today=date('Y-m-d');
        $att=DB::table('attendance as a')->leftJoin('employees as e','e.id','=','a.emp_id')->whereDate('clock_in_date','=',$today)->select('a.*','e.fname','e.lname')->get();
        $datas=DB::table("employees")->select('*')
            ->whereNOTIn('id',function($query){
               $query->select('emp_id')->from('attendance')->whereDate('attendance.clock_in_date','=',date('Y-m-d'));
            })->get();
        return view('attendance', ['datas' => $datas,'att'=>$att]);
    }
    public function staff_clockin(Request $request){
        $emp_id=$request->post('emp_id'); 
        $clin_date=date('Y-m-d h:i:s');
        $id=DB::table('attendance')->insertGetId(['emp_id'=>$emp_id,'status'=>'Present','clock_in_date'=>$clin_date]);
        Session::flash('success', 'Attendence Marked Successfully');        
        return 1;        
    }
    public function staff_clockout(Request $request){
        $emp_id=$request->post('emp_id'); 
        $data=DB::table('attendance')->where('emp_id',$emp_id)->where('clock_out_date','=',NULL)->select('clock_out_date','clock_in_date','id')->orderBy('id','desc')->first();
        
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
    public function category() {
        $data = Category::where('status', 1)->get();
        return view('category', ['datas' => $data]);
    }

    public function insert_category(Request $request) {
        //print_r(Input::get('name'));exit;
        $data = new Category();
        $data->name = Input::get('name');
        $data->save();
        Session::flash('success', 'Category Added Successfully');
        return redirect('admin/category');
    }

    public function delete_category() {
        $data = Category::where('id', Input::get('id'))->delete();
        $data1 = Category::count();
        return Response::json($data1, 200);
    }
    public function products(Request $request,$type) {
        if($request->ajax()){ 

            $products = Products::select(array(
                'product_name', 'quantity', 'discount_price', 'sku', 'cid','branch_id','stock_status','approved_status','comments','id',
            ))->where('status', 1);
            if($type!='all_products')
                $products->where('quantity','<=',5);
            return Datatables::of($products)
            ->addColumn('action', function($data){
                $btn = '<button class="btn btn-primary edit_product" id="'. $data->id.'"  type="button"><i class="os-icon os-icon-ui-49">Edit</i></button> 
                <button class="btn btn-primary delete" type="button" data-id="'. $data->id.'"><i class="os-icon os-icon-ui-15">Delete</i></button>';  
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
            ->editColumn('branch_id', function($data){
                $branch = $this->get_branch_name($data->branch_id);
                return $branch->name.'('.$data->branch_id.')';
            })
            ->editColumn('approved_status', function($data){ 
                $btn="";
                if($data->approved_status==0 and $data->comments != null) { $btn='<a href=""> <span class="label label-danger" id="approve_status" data-id="'.$data->id.'">Not Approved</span></a>'; } 
                else if($data->approved_status==2){  $btn='<span class="label label-success">Approved</span>';}
                else {  $btn=' <span class="label label-danger">Pending</span>';}
                return $btn; 
            })
            ->rawColumns(['action','stock_status','approved_status','checkbox','branch_id'])
            ->make(true);
        }
        $category = Category::where('status', 1)->get();
        $branches = Branches::all();
        return view('products', ['categories' => $category, 'branches' => $branches,'type'=>$type]);
    }
    public function edit_product(Request $request)
    {
        $product=Products::where('id',$request->post('id'))->first();
        echo json_encode(array("data"=>$product));exit;
    }
    public function insert_product(Request $request) {
       $sku=mt_rand(100000, 999999);
       $check=Products::where('sku', '=',$sku)->first();
       if(!$check)
        {
        $max_id = DB::table('products')->count();

        if ($max_id > 0) {
            $max_id = DB::table('products')->orderBy('id', 'desc')->first();

            $data = explode('-', $max_id->product_id);

            $max_id = $data[1] + 1;
            $product_id = 'SJP-0000' . $max_id;
        } else {
            $product_id = 'SJP-00001';
        }
        
        $data = new Products();
        $data->product_id = $product_id;
        $data->cid = Input::get('cid');
        $data->product_name = Input::get('product_name');
        $data->discount_price = Input::get('discount_price');
        $data->quantity = Input::get('quantity');
        $data->sku =$sku;
        $data->date = date('Y-m-d h:i:s');
        $data->stock_status = 'Instock';
        $data->branch_id = Input::get('branch_id');
		$data->igst=Input::get('igst');
		$data->cgst=Input::get('cgst');
		$data->sgst=Input::get('sgst');
		$data->approved_status=$request->post('status');
        $data->save();
       
        return Response::json(array('status'=>true), 200);
        }else
        {
            return Response::json(array('status'=>false), 200);
        }
        return redirect('admin/products');
    }
    public function update_product(Request $request) {
        $data = Products::where('id', Input::get('id'))->update(['cid' => Input::get('cid'), 'branch_id' => Input::get('branch_id'), 'product_name' => Input::get('product_name'), 'discount_price' => Input::get('discount_price'),
        'quantity' => Input::get('quantity'),'igst'=>Input::get('igst'),'cgst'=>Input::get('cgst'),'sgst'=>Input::get('sgst'),'approved_status'=>$request->post('status')]);
        return Response::json(array('status'=>true), 200);
    }
    public function delete_product() {
        $data = Products::where('id', Input::get('id'))->delete();
        $data1 = Products::where('status', 1)->count();
        return Response::json($data1, 200);
    }
     public function approve_product(Request $request){
         DB::table('products')->where('id',$request->post('id'))->update(['approved_status'=>2]);
         return Response::json(array('status'=>true), 200);
     }
    public function get_products() {
        $id = Input::get('id');
        if ($id != 'all') {
            $data1 = Products::where('cid', $id)->get();
        } else {
            $data1 = Products::all();
        }
        return Response::json($data1, 200);
    }
    public function getProductsBySku() {
        $query = Input::get('sku');
        $data = DB::table('products')->where('sku',$query)->where('approved_status',2)->where('quantity','>',0)->get();
        return Response::json($data, 200);
    }
    public function sales(Request $request) { 
        if($request->ajax()){      
            $sales = Sales::select(array(
                'invoice_id', 'customer_name', 'payment_mode', 'payable_amount', 'balance','total_amount','created_at'
            ));
            return Datatables::of($sales)
            ->addColumn('action', function($row){
                $btn = '<a href="'.url('admin/invoice').'/'.$row->invoice_id.'" class="btn btn-primary" ><i class="os-icon os-icon-ui-49">View</i></a>';  
                return $btn;
            })
            ->editColumn('created_at', function($data){
                $formatedDate = date('d-m-Y H:i:s', strtotime($data->created_at)); 
                return $formatedDate; 
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('sales');
    }
    public function hide_sales() {        
        $sales = Sales::where('status', 0)->latest()->get();
        return view('hide_sales', ['datas' => $sales]);
    }
    public static function get_sales_details($invoice_id) {
        $data = Invoice::where('invoice_id', $invoice_id)->get();
        return $data;
    }
    public static function get_branch_name($branch_id) {
        $data = Branches::where('branch_id', $branch_id)->first();
        return $data;
    }
    public function invoice($invoice_id) {
        $invoice = Invoice::where('invoice_id', $invoice_id)->orderBy('sku')->get();
        $sales_data = Sales::where('invoice_id', $invoice_id)->get();
        $sales_exchange_data = Sales_Exchange::where('invoice_id', $invoice_id)->orderBy('sku')->get();
        return view('invoice', ['datas' => $invoice, 'data' => $sales_data,'sales_exchange_data'=>$sales_exchange_data]);
    }
    public function delete_invoice() {
        $dele_data = Sales::where('invoice_id', Input::get('id'))->delete();
        $dele_data = Invoice::where('invoice_id', Input::get('id'))->delete();
        $data1 = Sales::where('status', 1)->count();
        return Response::json($data1, 200);
    }
    public function hide_invoice(Request $request) 
    {
        $ids = $request->ids;
        if ($ids) {
            $hide = Sales::whereIn('id', explode(",", $ids))->update(['status'=>0]);
            $data1 = Sales::where('status', 1)->count();
            return Response::json($data1, 200);
        } else {
            $data1 = 0;
            return Response::json($data1, 200);
        }
    }
    public function unhide_invoice(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $hide = Sales::whereIn('id', explode(",", $ids))->update(['status'=>1]);
            $data1 = Sales::where('status', 1)->count();
            return Response::json($data1, 200);
        } else {
            $data1 = 0;
            return Response::json($data1, 200);
        }
    }
	public function time_cards()
	{
	     $data=DB::table('attendance as a')->Join('employees as e','e.id','=','a.emp_id')->whereMonth('a.clock_in_date',Carbon::now()->month)->orderBy('a.id','desc')->select('a.*','e.fname','e.lname')->get();
		 $emp_list=DB::table('employees')->select('id','fname')->orderBy('id','desc')->get();
	     return view('time_cards', ['datas' => $data,'emp_list'=>$emp_list]);
	}
	public static function search_time_cards(Request $res)
	{
	     if($res->post('emp_id')=='all')
	     {
	       $data=DB::table('attendance as a')->Join('employees as e','e.id','=','a.emp_id')->whereBetween('a.clock_in_date',[$res->post('from'),$res->post('to')])->orderBy('a.id','desc')->select('a.*','e.fname','e.lname')->get();
	     }
	     else
	     {
	        $data=DB::table('attendance as a')->Join('employees as e','e.id','=','a.emp_id')->where('a.emp_id',$res->post('emp_id'))->whereBetween('a.clock_in_date',[$res->post('from'),$res->post('to')])->orderBy('a.id','desc')->select('a.*','e.fname','e.lname')->get();
	     }
	    $emp_list=DB::table('employees')->select('id','fname')->orderBy('id','desc')->get();
	    return view('time_cards', ['datas' => $data,'emp_list'=>$emp_list]);
	}
    public function barcodes(){
        $data['datas']=DB::table('products')->where('status',1)->select('id','barcode_image','sku')->orderby('id','desc')->get();
        return view('barcodes',$data);
    }
    public function print_barcodes(Request $request){
       $data=DB::table('products')->WhereIn('id',$request->post('id'))->select('discount_price','sku','product_name','quantity')->orderby('id','desc')->get();
        foreach($data as $d)
        {
           $final_data[]=array('BARCODE'=>$d->sku,'MRP PRICE'=>$d->discount_price.'.00','PRODUCT NAME'=>$d->product_name,'QUANTITY'=>$d->quantity); 
        }
        if(!empty($final_data))
        {
           return (new FastExcel($final_data))->download('BARCODE.xlsx');   
        }
        else
        {
            return redirect('sales_report')->with('error','No Data Found');
        }  
    }
    //Report
    public function reports() {
        $data['datas'] =User::where('role','staff')->select('emp_id','name')->get();
        $data['branches']=Branches::all();
        return view('reports',$data);
    }
    public function sales_reports() 
	{
        $final_data=array();
        $fm_date =Input::get('from_date');
        $to_date = Input::get('to_date');
        $query = Sales::whereBetween('created_at', [$fm_date, $to_date])->where('status',1);
       if(Input::get('emp_id')!='all' and Input::get('branch')!='all') {
           $query = $query->where('emp_id',Input::get('emp_id'))->where('branch_id',Input::get('branch_id'));
        }
        else
        {
          if(Input::get('emp_id')=='all' and Input::get('branch_id')!='all')
          {
              $query = $query->where('branch_id',Input::get('branch_id'));
          }
          elseif(Input::get('branch_id')=='all' and Input::get('emp_id')!='all')
          {
             $query = $query->where('emp_id',Input::get('emp_id'));
          }
          else
          {
            //not found
          }
        }
        foreach($query->get() as $c)
        {
			$branch=Branches::where('branch_id',$c->branch_id)->select('in_tamilnadu','name')->first();
			$total=$c->total_amount;
			$total_gst=0;
			$skus=Invoice::where('invoice_id',$c->invoice_id)->select('sku')->get();
			if($branch['in_tamilnadu']=='yes')
			{ 
				foreach($skus as $sku)
				{
					$gst=products::where('sku',$sku->sku)->select('cgst')->first();
                    if($gst)
					    $total_gst=$total_gst+$gst->cgst*2;
				}
			}
			else 
			{  			
				foreach($skus as $sku)
				{
					$gst=products::where('sku',$sku->sku)->select('igst')->first();
                    if($gst)
					    $total_gst=$total_gst+$gst->igst;
				}
			}
			$tax=round(100+$total_gst);
			$net_amount1=$total*100/$tax;
			$net_amount= number_format($net_amount1, 2, '.', ''); 
            $final_data[]=array(
           'Invoice ID'=>$c->invoice_id,
           'Bill Date'=>date('d-m-Y H:i:s a',strtotime($c->created_at)),
           'Customer Name'=>$c->customer_name,
           'Phone'=>$c->phone,
           'Payment Mode'=>$c->payment_mode,
           'Cash Recevied'=>$c->payable_amount,
           'Balance'=>$c->balance,
           'Total Amount'=>$c->total_amount,
           'Baranch'=>$branch['name'],
           'EMP ID'=>$c->emp_id,
		   'TOTAL GST %'=>$total_gst,
		   'Net Amount'=>$net_amount,
		   'TAX PRICE'=>$total-$net_amount
		   ); 
        }
        if(!empty($final_data))
        {
            return (new FastExcel($final_data))->download('Sales-Report-'.$fm_date.'-to-'.$to_date.'.xlsx');
        }
        else
        {
            return redirect('admin/reports')->with('error','No Data Found');
        }
    }
    function category_array()
    {
        $array=array();
        $categorys=Category::all();
        $array['Branch Name']="";
        foreach($categorys as $category)
        {
          $array[$category->name]=0;
        }
        $array['Order Qty']=0;
        $array['Order Value']=0;
        return $array;
    }
    public function employee_sales_report()
    {   
        $final_data=array();
        $fm_date =Input::get('from_date');
        $to_date = Input::get('to_date');
        //echo Input::get('emp_id');exit;
        $query = Sales::whereBetween('created_at', [$fm_date, $to_date])->where('status',1)
        ->select('emp_id','branch_id',DB::raw('SUM(total_amount) AS order_value'),DB::raw('COUNT(ID) AS order_count'))
        ->groupby('emp_id')->get();
        foreach($query as $c)
        {
			$branch=Branches::where('branch_id',$c->branch_id)->select('name')->first();
			$emp_name=Employees::where('emp_id',$c->emp_id)->select('fname')->first();
            $final_data[]=array(
           'Emp ID'=>$c->emp_id,
           'Emp Name'=>$emp_name->fname,
           'Branch'=>$branch->name,
           'Branch ID'=>$c->branch_id,
           'Order Count'=>$c->order_count,
           'Order Value'=>$c->order_value,
		   ); 
        }
        if(!empty($final_data))
        {
            return (new FastExcel($final_data))->download('Employee-Report-'.$fm_date.'-to-'.$to_date.'.xlsx');
        }
        else
        {
            return redirect('admin/reports')->with('error','No Data Found');
        }
    }
    public function category_report(Request $res)
    {
        $fm_date =Input::get('from_date');
        $to_date = Input::get('to_date');
        $array=$this->category_array();
        $final_data=array();
        if(Input::get('branch')!='all') {
            $branches_wise=Branches::all()->where('branch_id',Input::get('branch_id'));
         }
         else
            $branches_wise=Branches::all();
         
        foreach($branches_wise as $branch)
        {              
            $array['Branch Name']=$branch->name;
            $category_value=DB::table('invoice as i')->join('products as p','p.sku','=','i.sku')->whereBetween('i.created_at', [$fm_date, $to_date])
            ->where('i.branch_id',$branch->branch_id)
            ->selectRaw('p.cid as category,sum(i.price) as order_value,count(i.id) as order_count,sum(i.quantity) as order_qty');
            if(Input::get('emp_id')!='all') {
               $category_value->where('emp_id',Input::get('emp_id'));
             }
            $category_value= $category_value->groupBy('p.cid')->get();
            foreach($category_value as $value)
            {
                if(array_key_exists($value->category,$array))
                {
                    $array[$value->category]="S.NO: ".$value->order_count.'| QTY: '.$value->order_qty.' | RS: '.$value->order_value;
                }
                $array['Order Qty']=$array['Order Qty']+$value->order_qty;
                $array['Order Value']= $array['Order Value']+$value->order_value;
            }
            $final_data[]=$array;
            $array=$this->category_array();
        }
        if(!empty($final_data))
        {
            return (new FastExcel($final_data))->download('Category-Report-'.$fm_date.'-to-'.$to_date.'.xlsx');
        }
        else
        {
            return redirect('admin/reports')->with('error','No Data Found');
        }
    }
	public function branch_bill_status(Request $res)
	{
	    $fm_date =Input::get('from_date');
        $to_date = Input::get('to_date');
	    $final_data=array();
	    $query = DB::table('sales as s')->join('branches as b','b.branch_id','=','s.branch_id')->selectRaw('s.branch_id,sum(s.payable_amount)as pay_amt,sum(s.total_amount) as tol_amt,sum(s.balance) as bl_amt,count(s.id) as bill_count,s.created_at,b.name,s.payment_mode');
        if($fm_date && $to_date){
            $query =$query->whereBetween('s.created_at',[$fm_date, $to_date]);
        }else{
            
           $query = $query->whereDate('s.created_at',Carbon::today());
         
        }
        
        $data= $query->groupBy('branch_id')->get();
        
       //echo "<pre>";print_r($data);exit;
        if($data)
        {
            foreach($data as $d)
            {
                $branch_status=(Array)$d;
                $query = Sales::selectRaw('payment_mode,sum(total_amount) as p_total')->where('branch_id',$d->branch_id);
                $query = ($res->get('from_date')) ?  $query->whereBetween('created_at',[$fm_date, $to_date]):  $query->whereDate('created_at',Carbon::today());
                $source['source']= $query->groupBy('payment_mode')->get();
                $final_data[]=array_merge($branch_status,$source);
            }
        }
        else
        {
            $final_data=array();
        }
         //echo "<pre>";print_r($final_data);exit;
	    return view('branch_status',['data'=>$final_data]);
	}
    public function target_report()
    {
       
        $final_data=array();
        $fm_date =Input::get('from_date');
        $to_date = Input::get('to_date');
        $today_target_data=DB::table('employee_target as t')->select('e.fname','t.date','t.emp_id','t.target_amt','t.carry_forward_amt',DB::raw('IFNULL(d.branch_id,"-") as branch_id'),DB::raw('IFNULL(d.day_sales_value, 0) as day_sales_value'),DB::raw('IFNULL(d.day_sales_count, 0) as day_sales_count'))
        ->leftjoin('employee_day_sale as d','d.invoice_date','=','t.date')
        ->leftjoin('employees as e','e.emp_id','=','t.emp_id')
        ->whereBetween('t.date', [$fm_date, $to_date]);
        if(Input::get('branch_id')!='all')
        {
            $today_target_data = $today_target_data->where('d.branch_id',Input::get('branch_id'));
        }
        if(Input::get('emp_id')!='all')
        {
            $today_target_data = $today_target_data->where('t.emp_id',Input::get('emp_id'));
        }
        $today_target_data= $today_target_data->orderBy("t.date","desc")->groupBy('t.date','t.emp_id')->get();
        foreach($today_target_data as $data)
        {
            $total_target=$data->target_amt+$data->carry_forward_amt;
            if($data->day_sales_value > $total_target)
                $balance=($data->day_sales_value-$total_target);
            else
                 $balance=($total_target-$data->day_sales_value);
			$branch=Branches::where('branch_id',$data->branch_id)->select('name')->first();
			$emp_name=Employees::where('emp_id',$data->emp_id)->select('fname')->first();
            $final_data[]=array(
                'Date'=>$data->date,
                'Emp Name'=>$emp_name->fname."( ".$data->emp_id.' )',
                'Branch'=>($data->branch_id !='-')? $branch->name."( ".$data->branch_id.' )' : $data->branch_id,
                'Sales Count'=>$data->day_sales_count,
                'Target Amount'=>$data->target_amt,
                'Carry Forward Target'=>$data->carry_forward_amt,
                'Total Target'=>$total_target,
                "Balance Target"=>$balance
		   ); 
        }
        if(!empty($final_data))
        {
            return (new FastExcel($final_data))->download('Employee-Target-'.$fm_date.'-to-'.$to_date.'.xlsx');
        }
        else
        {
            return redirect('admin/reports')->with('error','No Data Found');
        }
    }
}
