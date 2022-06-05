@include('staff/layouts.links')
@include('staff/layouts.header')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
<ul class="breadcrumb">
    <li><a href="#">Home</a></li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE TITLE -->
<div class="page-title">                    
    <h2><span class="fa fa-arrow-circle-o-left"></span> Target Managers {{date('F',strtotime('last month'))}} - {{date('F')}}</h2>
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
                                <th>Saled Count</th>
                                <th>Target Amount</th>
                                <th>Saled Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                  
                        </tbody>
                       <tfoot align="right">
		                  <tr>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                            </tr>
	              </tfoot>
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
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            var Balance=0;
            // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // computing column Total of the complete result 
            var TargetValue = api
                .column(3)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
				
	        var SaleValue = api
                .column(4)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
        // Update footer by showing the total with the reference of the column index 
	    $( api.column( 2 ).footer() ).html('Total');
        $( api.column( 3 ).footer() ).html(TargetValue.toLocaleString('en-IN'));
        $( api.column( 4 ).footer() ).html(SaleValue.toLocaleString('en-IN'));

        if(SaleValue>TargetValue)
            Balance='<span class="label label-success">'+(SaleValue-TargetValue).toLocaleString('en-IN')+'<span>';
        else
            Balance='<span class="label label-danger">'+(TargetValue -SaleValue).toLocaleString('en-IN')+'<span>';
        $( api.column( 5 ).footer() ).html(Balance);
        },
        "columns": [
            { data: 'date', name: 'date' },
            { data: 'emp_id', name: 'emp_id' },
            { data: 'day_sales_count', name: 'day_sales_count' },
            { data: 'target_amt', name: 'target_amt' },
            { data: 'day_sales_value', name: 'day_sales_value' },
            { data: 'blance_target_amt', name: 'blance_target_amt' }
        ]
    });
</script>