@include('layouts.links')
@include('layouts.header')
<ul class="breadcrumb">
    <li><a href="/home">Home</a></li>
    <li><a href="/products">products</a></li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE TITLE -->
<div class="page-title">                    
    <h2><span class="fa fa-arrow-circle-o-left"></span> Products Manager</h2>
</div>
<!-- END PAGE TITLE -->                
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">

            <!-- START DATATABLE EXPORT -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <button class="btn btn-primary" data-target="#exampleModal1" data-toggle="modal" type="button" style="float:right">Add New Product</button><br><br>
                    <table id="customers2" class="table datatable">
                        <thead>
                            <tr>
                                <th>
                                    S.No
                                </th>
                                <th>
                                    Product Name
                                </th>
                                <th>
                                    Quantity
                                </th>
                                <th>
                                    Selling Price
                                </th>
                                <th>
                                    Sku
                                </th>
                                <th>
                                    Status
                                </th>                                
                                <th>
                                    Approved Status
                                </th>
                                <th>
                                    Actions
                                </th>
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
                                    {{ $data->product_name }}
                                </td>
                                <td>
                                    {{ $data->quantity }}
                                </td>
                                <td>
                                    {{ $data->discount_price }}
                                </td>
                                <td>
                                    {{ $data->sku }}
                                </td>
                                <td>
                                    @if($data->quantity >0)
                                    <span class="label label-success">Low stock</span>
                                    @else
                                    <span class="label label-danger" >Out Of Stock</span>
                                    @endif
                                </td>                               
                                 <td>
                                    @if($data->approved_status!=2)
                                    <a href=""> <span class="label label-danger" id="approve_status" data-id="{{ $data->id }}">Pending</span></a>
                                    @else
                                    <span class="label label-success">Approved</span>
                                    @endif
                                </td>
                                <td class="row-actions">
                                    <button class="btn btn-primary" data-target="#edit{{ $data->id  }}" data-toggle="modal" type="button"><i class="os-icon os-icon-ui-49">Edit</i></button>
                                    <button class="btn btn-primary delete" type="button" data-id="{{$data->id}}"><i class="os-icon os-icon-ui-15">Delete</i></button>
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
@foreach($datas as $data)
<div aria-hidden="true" aria-labelledby="" class="modal fade" id="edit{{ $data->id }}" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Edit Product
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{url('admin/update_product')}}" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""> Branch:</label>
                                <select class="form-control" name="branch_id" required>   
<!--                                    <option>[..Select Brach..]</option>-->
                                    @foreach($branches as $br)
                                    <option value="{{ $br->name }}" {{ $br->name === $data->branch_name? 'selected' : '' }}>
                                        {{ $br->name }}
                                    </option>
                                    @endforeach 
                                </select>
                            </div>
                        </div>
                         <!---<div class="col-sm-6">
                            <div class="form-group">
                                <label for=""> Category:</label>
                                <select class="form-control" name="cid" required>                                    
                                    @foreach($categories as $de)
                                    <option value="{{ $de->id }}" {{ $de->id === $data->cid? 'selected' : '' }}>
                                        {{ $de->name }}
                                    </option>
                                    @endforeach 
                                </select>
                            </div>
                        </div>---->
                    </div>
                   
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""> Product Name:</label><input class="form-control" value="{{ $data->product_name }}" name="product_name"  type="text" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Price:</label><input class="form-control" value="{{ $data->discount_price }}" name="discount_price"  type="number" required>
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Quantity:</label><input class="form-control" value="{{ $data->quantity }}" name="quantity" type="number" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Sku:</label><input class="form-control" value="{{ $data->sku }}" name="sku" type="text" required readonly>
                            </div>
                        </div>

                    </div>


                    <br>
                    <br>
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-dismiss="modal" type="button"> Close</button><button class="btn btn-primary" type="submit"> Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endforeach
<!-- ADD  -->
<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="exampleModal1" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Add New Product
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{url('admin/insert_product')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                     <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""> Branch:</label>
                                <select class="form-control" name="branch_id" required>   
                                    <option>[..Select Brach..]</option>
                                    @foreach($branches as $br)
                                    <option value="{{ $br->name }}">{{ $br->name }}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </div>
                         <!----<div class="col-sm-6">
                            <div class="form-group">
                                <label for=""> Category:</label>
                                <select class="form-control" name="cid" required>                                    
                                    @foreach($categories as $de)
                                    <option value="{{ $de->id }}">
                                        {{ $de->name }}
                                    </option>
                                    @endforeach 
                                </select>
                            </div>
                        </div>--->
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""> Product Name:</label><input class="form-control" placeholder="Enter Product Name" name="product_name"  type="text" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Price:</label><input class="form-control" placeholder="Enter Price" name="discount_price"  type="number" required>
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Quantity:</label><input class="form-control" placeholder="Enter Quantity" name="quantity" type="number" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Sku:</label><input class="form-control" placeholder="21564156" name="sku" type="text" required>
                            </div>
                        </div>
                    </div>

                    <br>
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
                        url: "{{URL::to('admin/delete_product')}}",
                        data: "_token=" + token + "&id=" + id,
                        beforeSend: function () {
                            $("." + id).css("background-color", "#fb6c6c");
                        },
                        success: function (data1) {
                            parent.slideUp(300, function () {
                                if (data1 == 0)
                                {
                                    swal('Deleted!', 'Product Deleted', 'success');
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
$(document).on('click', '#approve_status', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var token = "{{ Session::token() }}";
        var parent = $(this).parent();
        swal({
            title: 'Are you sure want to Approve?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve it!',
            showLoaderOnConfirm: true,
        },
                function () {
                    $.ajax({
                        type: 'post',
                        url: "{{URL::to('admin/approve_product')}}",
                        data: "_token=" + token + "&id=" + id,
                        beforeSend: function () {
                            $("." + id).css("background-color", "#fb6c6c");
                        },
                        success: function (data1) {
                            parent.slideUp(300, function () {
                                if (data1 == 0)
                                {
                                     swal('Approved!', 'Product Approved', 'success');
                                    $("#customers2").load(window.location + " #customers2");
                                } else
                                {
                                    $("#customers2").load(window.location + " #customers2");
                                }

                            });
                        }
                    });
                });
    });
</script>