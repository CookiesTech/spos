<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::get('/', function () {
     Auth::logout();
    return view('auth.login');
});
Route::group(['prefix' => 'admin'], function () {
    
Route::get('/branch_bill_status', 'HomeController@branch_bill_status');
Route::get('/home', 'HomeController@index');
Route::get('/branches', 'HomeController@branches');
Route::get('/employees', 'HomeController@employees');
Route::get('/branches', 'HomeController@branches');
Route::post('/insert_branch','HomeController@insert_branch');
Route::post('/update_branch','HomeController@update_branch');

Route::get('/employees', 'HomeController@employees');
Route::post('/insert_employee','HomeController@insert_employee');
Route::delete('/delete_employee','HomeController@delete_employee');
Route::post('/update_employee','HomeController@update_employee');

Route::get('/attendance','HomeController@attendance');
Route::post('staff_clockin','HomeController@staff_clockin');
Route::post('staff_clockout','HomeController@staff_clockout');

Route::get('/category', 'HomeController@category');
Route::post('/insert_category','HomeController@insert_category');
Route::delete('/delete_category','HomeController@delete_category');

Route::get('/products', 'HomeController@products');
Route::get('/low_stock', 'HomeController@low_stock');
Route::post('/insert_product','HomeController@insert_product');
Route::post('/update_product','HomeController@update_product');
Route::delete('/delete_product','HomeController@delete_product');
Route::post('approve_product','HomeController@approve_product');


Route::post('get_products','HomeController@get_products');

Route::get('/sales','HomeController@sales');
Route::get('/hide_sales','HomeController@hide_sales');
Route::get('/invoice/{id}','HomeController@invoice');
Route::delete('/delete_invoice','HomeController@delete_invoice');
Route::post('/hide_invoice','HomeController@hide_invoice');
Route::post('/unhide_invoice','HomeController@unhide_invoice');
Route::post('/getProductsBySku','HomeController@getProductsBySku');

Route::get('/time_cards','HomeController@time_cards');
Route::post('/search_time_cards','HomeController@search_time_cards');
Route::get('/barcodes','HomeController@barcodes');
Route::post('print_barcodes','HomeController@print_barcodes');
//TARGET MODULE
Route::get('/target','TargetController@target');
Route::post('/add_target','TargetController@add_target');
Route::post('/update_target','TargetController@update_target');


//Report Setion
Route::get('/reports','HomeController@reports');
Route::post('/sales_reports','HomeController@sales_reports');
Route::post('/employee_sales_report','HomeController@employee_sales_report');
Route::post('/category_report','HomeController@category_report');
Route::post('/target_report','HomeController@target_report');
});

// Staff Part
Route::group(['prefix' => 'staff'], function () {
    Route::get('/print-bill/{invoice_id}', 'StaffController@print_bill');
    Route::get('/', 'StaffController@index');    
    Route::get('/staff_products', 'StaffController@products');
    Route::post('update_product_status','StaffController@update_product_status');
    Route::get('/staff_dashboard', 'StaffController@index');
    Route::get('/staff_pos', 'StaffController@staff_pos');
    Route::post('/getProductsBySku_staff','StaffController@getProductsBySku_staff');
    Route::post('/getProductsBySku','StaffController@getProductsBySku');
    Route::post('create_invoice_staff','StaffController@create_invoice_staff');
    Route::post('staff_clockin','StaffController@staff_clockin');
    Route::post('staff_clockout','StaffController@staff_clockout');
    Route::get('get_attendence_info/{id}','StaffController@get_attendence_info');
    Route::get('staff_timecards','StaffController@staff_timecards');
	Route::post('search_staff_timecards','StaffController@search_staff_timecards');
	Route::get('/invoice/{id}','StaffController@invoice');
	Route::post('/product_exchange','StaffController@product_exchange');
	Route::get('staff_sales','StaffController@staff_sales');
    Route::get('sales_target','StaffController@sales_target');
    
});
//Manager Part
Route::group(['prefix' => 'manager'], function () {
Route::get('/', 'ManagerController@index');
Route::get('/manager_dashboard', 'ManagerController@index');
Route::post('/getProductsBySku','ManagerController@getProductsBySku');
Route::post('get_products','ManagerController@get_products');
Route::get('stock_status', 'ManagerController@stock_status');
Route::post('search_attendence', 'ManagerController@search_attendence');
Route::get('attendence_list', 'ManagerController@attendence_list');
Route::post('search_my_timecard', 'ManagerController@search_my_timecard');
Route::get('my_timecard', 'ManagerController@my_timecard');
Route::post('manager_clockin','ManagerController@manager_clockin');
Route::post('manager_clockout','ManagerController@manager_clockout');
Route::get('/products', 'ManagerController@products');
Route::get('/invoice/{id}','ManagerController@invoice');
Route::post('update_product_status','ManagerController@update_product_status');
Route::get('/manager_sales', 'ManagerController@manager_sales');
});
Route::get('logout', 'HomeController@logout');

