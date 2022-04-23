@include('layouts.links')
@include('layouts.header')

<ul class="breadcrumb">
    <li><a href="home">Home</a></li>
    <li><a href="category">category</a></li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE TITLE -->
<div class="page-title">                    
    <h2><span class="fa fa-arrow-circle-o-left"></span> Category Manager</h2>
</div>
<!-- END PAGE TITLE -->                

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">



    <div class="row">
        <div class="col-md-12">

            <!-- START DATATABLE EXPORT -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="btn-group pull-right">
                         <button class="btn btn-primary" data-target="#exampleModal1" data-toggle="modal" type="button" style="float:right">Add New Category</button><br><br>
                    </div>                                    
                </div>
                <div class="panel-body">
                    <table id="customers2" class="table datatable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
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
                    Add New Category
                </h5>

            </div>
            <div class="modal-body">
                <form method="post" action="insert_category" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""> Category Name:</label><input class="form-control" placeholder="Enter Category Name" name="name"  type="text" required>
                            </div>
                        </div>
                        
                    </div>
                    <br>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal" type="button"> Close</button><button class="btn btn-primary" type="submit"> Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script>
    $('.delete').click(function (e) {
        var id = $(this).data("id");
        e.preventDefault();
        var token = "{{ Session::token() }}";

        var parent = $(this).parent();
        $.ajax({
            type: 'delete',
            url: "{{URL::to('admin/delete_category')}}",
            data: "_token=" + token + "&id=" + id,
            beforeSend: function () {
                $("." + id).css("background-color", "#fb6c6c");
            },
            success: function (data1) {
                parent.slideUp(300, function () {
                    if (data1 == 0)
                    {
                        $("." + id).remove();
                        $("#customers2 tbody").html("<tr><td colspan='8'>Nodata </td></tr>");
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


</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>    
