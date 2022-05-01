@include('staff/layouts.links')
@include('staff/layouts.header')
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
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <!-- START DATATABLE EXPORT -->
            <div class="panel panel-default">
                <div class="panel-heading">
                </div>
                <div class="panel-body">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Emp ID</th>
                                <th>Branch</th>
                                <th>Saled Count</th>
                                <th>Target Amount</th>
                                <th>Carry Forward</th>
                                <th>Saled Amount</th>
                                <th>Total Target</th>
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
@include('staff/layouts.footer')
<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script>
         $('#datatable').DataTable({
        "processing": true,
        "order": [[ 0, "desc" ]],
        "serverSide": true,
        "ajax": '{{url("staff/sales_target")}}',
        "columns": [
            { data: 'date', name: 'date' },
            { data: 'emp_id', name: 'emp_id' },
            { data: 'branch_id', name: 'branch_id' },
            { data: 'day_sales_count', name: 'day_sales_count' },
            { data: 'target_amt', name: 'target_amt' },
            { data: 'carry_forward_amt', name: 'carry_forward_amt' },
            { data: 'day_sales_value', name: 'day_sales_value' },
            { data: 'total_target', name: 'total_target' },
            { data: 'blance_target_amt', name: 'blance_target_amt' }
        ]
    });
</script>