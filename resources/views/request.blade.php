@include('layouts.links')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
<style>
    .form-control {
  height: 30px;
  font-size: 15px;
  line-height: 18px;
  border: 1px solid #D5D5D5;
}
.modal-content {
  position: relative;
  background-color: #fff;
  -webkit-background-clip: padding-box;
  background-clip: padding-box;
  border: 1px solid #999;
  border: 1px solid rgba(0,0,0,.2);
    border-top-width: 1px;
    border-right-width: 1px;
    border-bottom-width: 1px;
    border-left-width: 1px;
  border-radius: 6px;
  outline: 0;
  -webkit-box-shadow: 0 3px 9px rgba(0,0,0,.5);
  box-shadow: 0 3px 9px rgba(0,0,0,.5);
  width: 875px;
  margin-left: -105px;
}
</style>
@include('layouts.header')
<ul class="breadcrumb">
    <li><a href="/home">Home</a></li>
    <li><a href="#">Employee Request</a></li>
</ul><!-- END BREADCRUMB -->
<!-- PAGE TITLE -->
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span>Employee Request</h2>
</div><!-- END PAGE TITLE -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <!-- START DATATABLE EXPORT -->
            <div class="panel panel-default"> 
            <div class="panel-body"> 
                         {{ csrf_field() }}
                        <table id="datatable" class="table table-border">
                            <thead>
                                <tr>
                                    <th>S.NO </th>  
                                    <th> Emp ID</th>
                                    <th> Branch </th>
                                    <th> Request</th>
                                    <th> Date </th>
                                    <th> Status </th>
                                    <th> Actions </th>
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
</div> <!-- END PAGE CONTENT -->
</div>
</div>
</div>

<!-- ADD  -->
<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="exampleModal1" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Add New Request </h5> <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
            </div>
            <div class="modal-body">
                <form method="post" autocomplete="off" enctype="multipart/form-data" id="insert_request"> 
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group"> <label for=""> Request By :</label> 
                            <select class="form-control" name="emp_id" required >
                                    <option value="">[..Request By..]</option> 
                                    @foreach($branch_employees as $emp)
                                        <option value="{{ $emp->emp_id }}" empname="{{ $emp->name }}" class="payment_mode">{{ $emp->name }}-{{ $emp->emp_id }}<br>
                                        </option>	
                                    @endforeach
                            </select> </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group"> 
                                <label for="">Request:</label>
                                <textarea class="form-control" placeholder="Enter Request"  rows="8" name="request" type="text" required> </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"> <button class="btn btn-secondary" data-dismiss="modal" type="button"> Close</button><button class="btn btn-primary" type="submit"> Save</button> </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--ViewADD  -->
<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="Viewrequest" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> View Request </h5> <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
            </div>
            <div class="modal-body">
                <form method="post" autocomplete="off" enctype="multipart/form-data" id="Viewrequest_form"> 
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group"> <label for=""> Request By :</label> 
                            <select class="form-control" name="emp_id" id="emp_id" required>
                                    <option value="">[..Request By..]</option> 
                                    @foreach($branch_employees as $emp)
                                        <option value="{{ $emp->emp_id }}" empname="{{ $emp->name }}" class="payment_mode">{{ $emp->name }}-{{ $emp->emp_id }}<br>
                                        </option>	
                                    @endforeach
                            </select> </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group"> 
                                <label for="">Request:</label>
                                <textarea class="form-control" placeholder="Enter Request" name="request" rows="8" id="request" type="text" required> </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"> <button class="btn btn-secondary" data-dismiss="modal" type="button"> Close</button> </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script>
        $('#datatable').DataTable({
        "processing": true,
        "order": [[ 0, "desc" ]],
        "serverSide": true,
        "ajax": {
            "url": "{{url('admin/request')}}",
            "type": "GET"
        },
        "columns": [
            { data: 'id', name: 'id' },
            { data: 'emp_id', name: 'emp_id' },
            { data: 'branch_id', name: 'branch_id' },
            { data: 'request', name: 'request' },
            { data: 'created_at', name: 'created_at' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action',orderable: false},

        ]
    });
   //Update Product 
   $(document).on('click', '.approve_request', function(e) {
       e.preventDefault();
       var id = $(this).data('id');
       var token = "{{ Session::token() }}";
        $.ajax({
            type: 'post',
            url: "{{URL::to('admin/update_request')}}",
            dataType:"json",
            data: "_token=" + token + "&id=" + id,
            success: function(data) {
                if(data.status===true)
                {
                    $('#datatable').DataTable().ajax.reload(null,false);
                    toastr.success('Request Update Successfully');
                }
                else
                    toastr.error('Something is went wrong');
            }
       });
   });
   $(document).on('click', '.view_request', function(e) {
       e.preventDefault();
       var id = $(this).attr('id');
       var token = "{{ Session::token() }}";
        $('#Viewrequest_form').trigger("reset");
        $("#emp_id").val($(this).data('emp_id'));
        $("#request").val($(this).data('request'));
        $("#Viewrequest").modal('show');
    });
</script>