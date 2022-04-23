@include('layouts.links')
@include('layouts.header')
<ul class="breadcrumb">
    <li><a href="#">Home</a></li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE TITLE -->
<div class="page-title">                    
    <h2><span class="fa fa-arrow-circle-o-left"></span> Target Manager</h2>
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
                    <button class="btn btn-primary" data-target="#exampleModal1" data-toggle="modal" type="button" style="float:right">Add New Branch</button><br><br>
                    <table id="customers2" class="table datatable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
                                <th>Branch</th>
                                <th>Target Amount</th>
                                <th>Saled Amount</th>
                                <th>Blance</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach($datas as $data)
                            <tr class="{{$data->id}}">
                                <td>
                                    {{ $i }}
                                </td>
                                <td>
                                    {{ $data->name }}
                                </td>
                                <td class="row-actions">
                                    <button class="btn btn-danger btn-rounded btn-sm delete" data-id="{{$data->id}}" title="Delete Branch"><span class="fa fa-times"></span></button>
                                </td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
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
                    Add New Branch
                </h5>
            </div>
            <div class="modal-body">
                <form method="post" action="insert_branch" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""> Branch Area:</label><input class="form-control" placeholder="Enter Branch Area" name="name"  type="text" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Address:</label><textarea class="form-control" name="address" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal" type="button"> Close</button><button class="btn btn-primary" type="submit"> Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var token = "{{ Session::token() }}";
        var parent = $(this).parent();
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            showLoaderOnConfirm: true,
        },
                function () {
                    $.ajax({
                        type: 'delete',
                        url: "{{URL::to('admin/delete_branch')}}",
                        data: "_token=" + token + "&id=" + id,
                        beforeSend: function () {
                            $("." + id).css("background-color", "#fb6c6c");
                        },
                        success: function (data1) {
                            parent.slideUp(300, function () {
                                if (data1 == 0)
                                {
                                    swal('Deleted!', 'Branch Deleted', 'success');
                                    $("." + id).remove();
                                    $("#customers2 tbody").html("<tr><td colspan='8' align='center'>Nodata </td></tr>");
                                    $("#customers2_info").html("Showing 0 entries");
                                } else
                                {
                                    $("." + id).remove();
                                    $("#customers2_info").html("Showing 1 to " + data1 + " of " + data1 + " entries");
                                }

                            });
                        }
                    });
                });
    });
</script>