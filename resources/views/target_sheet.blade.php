@include('layouts.links')
@include('layouts.header')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
<ul class="breadcrumb">
    <li><a href="#">Home</a></li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE TITLE -->
<div class="page-title">                    
    <h2><span class="fa fa-arrow-circle-o-left"></span> Target Managers  {{date('F')}}</h2>
</div>
<!-- END PAGE TITLE -->                
<!-- PAGE CONTENT WRAPPER -->
<div class="col-md-12">
            <div class="panel panel-default">
           <div class = "panel-heading">
                Employee Target Report
           </div>  
               <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for=""> Select Date Range:</label>
                               <div class="input-group input-large"  data-date-format="yyyy-mm-dd" >
                                <input type="date" class="form-control" name="from_date"  id="s_from_date" required>
                                <span class="input-group-addon">
                                    to </span>
                                <input type="date" class="form-control" name="to_date" id="s_to_date"  required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">               
                        <label for="">Staff:</label>
                        <select name="emp_id"  class="form-control"  id="s_emp_id" >
                            <option value="all">All</option>
                            @foreach($employees as $data)
                            <option value="{{$data->emp_id}}">{{$data->name}} ({{$data->emp_id}})</option>
                            @endforeach
                        </select>         
                        </div>
                   </div>
                    <div class="col-sm-3">
                            <div class="form-group">               
                            <label for="">Branch:</label>
                            <select name="branch_id"  class="form-control"  id="s_branch_id">
                                <option value="all">All</option>
                                @foreach($branches as $branch)
                                <option value="{{$branch->branch_id}}">{{$branch->name}} ({{$branch->branch_id}})</option>
                                @endforeach
                            </select>         
                     </div>
                  <button class="btn btn-primary search_filter" type="button" style='margin-top: 10px;float: right;margin-right: 10px;'>Submit</button>    
               </div>
            </div>
            </div>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <!-- START DATATABLE EXPORT -->
            <div class="panel panel-default">
                <div class="panel-heading">
                </div>
                <div class="panel-body">
                    <button class="btn btn-primary" data-target="#exampleModal1" data-toggle="modal" type="button" style="float:right">Add New Target</button><br><br>
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Emp ID</th>
                                <th>Branch</th>
                                <th>Saled Count</th>
                                <th>Target Amount</th>
                                <th>Saled Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                  
                        </tbody>
                    </table>                                    
                </div>
            </div>
        </div>
    </div>
</div>                              
</div>            
<!-- END PAGE CONTENT -->
</div>
</div>
</div>
@include('layouts.footer')
<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="exampleModal1" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Add New Target
                </h5>
            </div>
            <div class="modal-body">
                <form method="post" id="target_form" autocomplete="off">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for=""> Employee ID:</label>
                                <select name="emp_id" id="emp_id" class="form-control" required>
                                    <option  value="">[Select Employee]</option>
                                    @foreach($employees as $data)
                                    <option value="{{$data->emp_id}}">{{$data->fname}} ({{$data->emp_id}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Target Date:</label>
                                <input class="form-control" placeholder="Enter Date" name="date"  type="date" id="date" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Amount:</label>
                                <input class="form-control" placeholder="Enter Amount" name="amount"  type="number"  minlength="1" id="amount" required>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal" type="button"> Close</button>
                        <button class="btn btn-primary add_target" type="submit"> Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script>
     $('#datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [[ 0, "desc" ]],
         ajax: {
            url: "{{url('admin/target')}}",
            data: function(d){
                d.from_date = $('#s_from_date').val(),
                d.to_date = $('#s_to_date').val(),
                d.emp_id = $('#s_emp_id').val(),
                d.branch_id = $('#s_branch_id').val();
            }
        },
        "columns": [
            { data: 'date', name: 'date' },
            { data: 'emp_id', name: 'emp_id' },
            { data: 'branch_id', name: 'branch_id' },
            { data: 'day_sales_count', name: 'day_sales_count' },
            { data: 'target_amt', name: 'target_amt' },
            { data: 'day_sales_value', name: 'day_sales_value' },
            { data: 'blance', name: 'blance' }
        ]
    });
    $(document).on('click', '.search_filter', function (e) {
        e.preventDefault();
        $('#datatable').DataTable().draw();
    });
    $(document).on('click', '.add_target', function (e) {
        e.preventDefault();
        var token = "{{ Session::token() }}";
        var emp_id= $('#emp_id').val();
        var date= $('#date').val();
        var amount= $('#amount').val();
        $.ajax({
            type: 'post',
            url: "{{URL::to('admin/add_target')}}",
            data: "_token=" + token + "&emp_id=" + emp_id+ "&date=" + date+ "&amount=" + amount,
            dataType:"json",
            beforeSend: function () {
                $(".add_target").prop('disabled', true);
            },
            complete: function () {
              $(".add_target").removeAttr('disabled');
            },
            success: function (data) {
                if(data.status)
                {
                    $(".add_target").removeAttr('disabled');
                    $("#target_form")[0].reset();
                    $('.btn-secondary').trigger ('click');
                    $('#datatable').DataTable().ajax.reload();
                }  
                else
                  alert(data.message);
            }
        });
    });
</script>