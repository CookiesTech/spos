<? phpnamespaceApp\Http\Controllers;
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
use PDF;
use App\User;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Carbon\Carbon;
class ManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('Manager');
    }
    public function index()
    {
        $pcount = Products::count();
        $today_bill_count = Sales::whereDate('created_at', Carbon::today())->count();
        $today_bill_value = Sales::whereDate('created_at', Carbon::today())->sum('payable_amount');
        $sales = DB::table('sales')->orderBy('id', 'DESC')->limit(10)->get();
        return view('manager/home', ['pcount' => $pcount, 'today_bill_value' => $today_bill_value, 'today_bill_count' => $today_bill_count, 'datas' => $sales]);
    }
    public function manager_sales()
    {
        $datas = DB::table('sales')->where('emp_id', Auth::user()
            ->emp_id)
            ->where('status', 1)
            ->orderby('id', 'desc')
            ->get();
        return view('manager/sales', ['datas' => $datas]);
    }
    public function manager_pos()
    {
        $datas = Products::where('status', 1)->get();
        $category = Category::all();
        return view('manager/pos', ['products' => $datas, 'categories' => $category]);
    }
    public function products()
    {
        $branch_name = Auth::user()->branch_id;
        $datas = Products::where('status', 1)->where('branch_id', $branch_name)->orderBy('id', 'desc')
            ->get();
        $category = Category::where('status', 1)->get();
        $branches = Branches::all();
        return view('manager/products', ['datas' => $datas, 'categories' => $category, 'branches' => $branches]);
    }
    public function update_product_status(Request $request)
    {
        DB::table('products')->where('id', $request->post('id'))
            ->update(['approved_status' => $request->post('status') , 'comments' => $request->post('comments') ]);
        Session::flash('success', 'Status Updated Successfully');
        return Redirect::back();
    }
    public function get_products()
    {
        $id = Input::get('id');
        if ($id != 'all')
        {
            $data1 = Products::where('cid', $id)->get();
        }
        else
        {
            $data1 = Products::all();
        }
        return Response::json($data1, 200);
    }
    public function getProductsBySku()
    {
        $query = Input::get('sku');
        $data = DB::table('products')->where('sku', $query)->where('branch_id', Auth::user()
            ->branch_id)
            ->where('approved_status', 2)
            ->get();
        return Response::json($data, 200);
    }
}

                
