@include('layouts.links')
@include('layouts.header')
<ul class="breadcrumb">
   <li><a href="/home">Home</a></li>
</ul>
<!-- END BREADCRUMB --><!-- PAGE TITLE -->
<div class="page-title">
   <h2><span class="fa fa-arrow-circle-o-left"></span>Report Manager</h2>
</div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
           <div class = "panel-heading">
            Sales Reports
           </div>
             <form method="post" action="{{url('admin/sales_reports')}}">
               {{ csrf_field() }}    
               <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for=""> Select Date Range:</label>
                               <div class="input-group input-large"  data-date-format="yyyy-mm-dd" >
                                <input type="date" class="form-control" name="from_date" required>
                                <span class="input-group-addon">
                                    to </span>
                                <input type="date" class="form-control" name="to_date" required>
                            </div>
                        </div>
                    </div>
                  <div class="col-sm-3">
                     <div class="form-group">               
                     <label for="">Staff:</label>
                     <select name="emp_id"  class="form-control">
                         <option value="all">All</option>
                         @foreach($datas as $data)
                         <option value="{{$data->emp_id}}">{{$data->name}} ({{$data->emp_id}})</option>
                         @endforeach
                     </select>         
                     </div>
                  </div>
                        <div class="col-sm-3">
                     <div class="form-group">               
                     <label for="">Branch:</label>
                     <select name="branch_id"  class="form-control">
                         <option value="all">All</option>
                         @foreach($branches as $branch)
                         <option value="{{$branch->branch_id}}">{{$branch->name}}</option>
                         @endforeach
                     </select>         
                     </div>
                  </div>
                  <button class="btn btn-primary" type="submit" style='margin-top: 10px;float: right;margin-right: 10px;'>Sales Report</button>    
               </div>
            </form>
            </div>
            </div>
          <div class="col-md-12">
            <div class="panel panel-default">
           <div class = "panel-heading">
            Employee Order Reports
           </div>
                <form method="post" action="{{url('admin/employee_sales_report')}}">
                    {{ csrf_field() }}
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for=""> Select Date Range:</label>
                                       <div class="input-group input-large"  data-date-format="yyyy-mm-dd" >
                                        <input type="date" class="form-control" name="from_date" required>
                                        <span class="input-group-addon">
                                            to </span>
                                        <input type="date" class="form-control" name="to_date" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit" style="float:right;"> Submit</button>
                    </div> 
                </form>
            </div>
            </div>
           <div class="col-md-12">
            <div class="panel panel-default">
           <div class = "panel-heading">
            Branch Wise Category Reports
           </div>
             <form method="post" action="{{url('admin/category_report')}}">
               {{ csrf_field() }}    
               <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for=""> Select Date Range:</label>
                               <div class="input-group input-large"  data-date-format="yyyy-mm-dd" >
                                <input type="date" class="form-control" name="from_date" required>
                                <span class="input-group-addon">
                                    to </span>
                                <input type="date" class="form-control" name="to_date" required>
                            </div>
                        </div>
                    </div>
                  <button class="btn btn-primary" type="submit" style='margin-top: 10px;float: right;margin-right: 10px;'>Submit</button>    
               </div>
            </form>
            </div>
            </div>
            </div>
<!-- END PAGE TITLE -->     
@include('layouts.footer')