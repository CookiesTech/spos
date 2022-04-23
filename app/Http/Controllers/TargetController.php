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
use Carbon\Carbon;
use DateTime;
class TargetController extends Controller {

    public function __construct() {
        $this->middleware('Admin');
        setlocale(LC_MONETARY, 'en_IN');
    }

    public function target(){
        $current_month_name=date('F');
       // $data['employees']=DB::table('employees')->where('status','Active')->get();
        $data['datas']=DB::table('target_sheet')->where('month_name',$current_month_name)->get();
         return view('target_sheet',$data);
   
    }



}