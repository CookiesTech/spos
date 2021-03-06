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
@include('layouts.header')<ul class="breadcrumb">
    <li><a href="/home">Home</a></li>
    <li><a href="/products">products</a></li>
</ul><!-- END BREADCRUMB -->
<!-- PAGE TITLE -->
<div class="page-title">
    <h2><span class="fa fa-arrow-circle-o-left"></span> Products Manager</h2>
</div><!-- END PAGE TITLE -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <!-- START DATATABLE EXPORT -->
            <div class="panel panel-default"> <input type="checkbox" class="check_all" style="margin-left:20px;"><span class=""> Select All</span>
                <div class="panel-body"> <button class="btn btn-primary" data-target="#exampleModal1" data-toggle="modal" type="button" style="float:right">Add New Product</button><br><br>
                    <form method="post" action="{{ url('admin/print_barcodes') }}" id="barcode"> 
                        <button class="btn btn-primary btn-rounded  print" style="margin-left:500px;" title="">Print</button>
                         {{ csrf_field() }}
                        <table id="datatable" class="table table-border">
                            <thead>
                                <tr>
                                    <th>S.NO</th>
                                    <th>Select</th>
                                    <th> Product Name </th>
                                    <th> Quantity </th>
                                    <th> Selling Price </th>
                                    <th> Sku </th>
                                    <th> Category </th>
                                    <th> Branch </th>
                                    <th> Status </th>
                                    <th> Approved Status </th>
                                    <th> Actions </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div> <!-- END PAGE CONTENT -->
</div>
</div>
</div>
  @include('layouts.footer')
  <div aria-hidden="true" aria-labelledby="" class="modal fade" id="product_edit" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Edit Product </h5> <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
            </div>
            <div class="modal-body">
                <form method="post" autocomplete="off"  id="product_edit_form"enctype="multipart/form-data"> 
                    <input type="hidden" name="id" value="" id="hidden_id"> 
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group"> <label for=""> Branch:</label> 
                            <select class="form-control" name="branch_id" required id="branch_id">
                                    <option value="">[..Select Brach..]</option> 
                                    @foreach($branches as $br) 
                                    <option value="{{ $br->branch_id }}"> {{ $br->name }} </option>
                                    @endforeach
                                </select> </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group"> <label for=""> Category:</label> 
                            <select class="form-control" name="cid" required id="cid">
                                    <option value="">[..Select Category..]</option> 
                                    @foreach($categories as $de) 
                                        <option value="{{ $de->name }}" > {{ $de->name }} </option>
                                     @endforeach
                                </select> </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group"> <label for=""> Product Name:</label>
                            <input class="form-control"  name="product_name" type="text" required  id="product_name"> </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group"> <label for="">Price:</label><input class="form-control"  id="discount_price" name="discount_price" type="number" required> </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group"> <label for="">Quantity:</label><input class="form-control"  id="quantity" name="quantity" type="number" required> </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group"> <label for="">Sku:</label><input class="form-control" id="sku" name="sku" type="text" required readonly> </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group"> <label for="">SGST:</label><input class="form-control" id="sgst" placeholder="Enter SGST" name="sgst" type="text" > </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group"> <label for="">IGST:</label><input class="form-control" id="igst" placeholder="Enter IGST" name="igst" type="text" > </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group"> <label for="">CGST:</label><input class="form-control"  id="cgst" placeholder="Enter CGST" name="cgst" type="text" > </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group"> 
                            <label for=""> Status Approve:</label>
                            <select name="status" required class="form-control" id="status">
                               <option value="">[Select]</option>
                               <option value="2" > Approved</option>
                               <option value="0"> Not Approved</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group"> <label for=""> Comments:</label>
                            <textarea class="form-control" readonly style="color: black;" rows="3" id="comments"></textarea> </div>
                        </div>
                    </div>
                     <br> <br>
                    <div class="modal-footer"> <button class="btn btn-primary" data-dismiss="modal" type="button"> Close</button><button class="btn btn-primary" type="submit"> Save</button> </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ADD  -->
<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="exampleModal1" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Add New Product </h5> <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
            </div>
            <div class="modal-body">
                <form method="post" autocomplete="off" enctype="multipart/form-data" id="insert_product"> 
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group"> <label for=""> Branch:</label> <select class="form-control" name="branch_id" required>
                                    <option value="">[..Select Branch..]</option> @foreach($branches as $br) <option value="{{ $br->branch_id }}">{{ $br->name }}</option> @endforeach
                                </select> </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group"> <label for=""> Category:</label> <select class="form-control" name="cid" required>
                                    <option value="">[..Select Category..]</option> @foreach($categories as $de) <option value="{{ $de->name }}"> {{ $de->name }} </option> @endforeach
                                </select> </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group"> <label for="">Product Name:</label><input class="form-control" placeholder="Enter Product Name" name="product_name" type="text" required> </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group"> <label for="">Price:</label><input class="form-control" placeholder="Enter Price" name="discount_price" type="number" required> </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group"> <label for="">Quantity:</label><input class="form-control" placeholder="Enter Quantity" name="quantity" type="number" required> </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group"> <label for="">SGST:</label><input class="form-control" placeholder="Enter SGST" name="sgst" type="text" > </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group"> <label for="">IGST:</label><input class="form-control" placeholder="Enter IGST" name="igst" type="text" > </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group"> <label for="">CGST:</label><input class="form-control" placeholder="Enter CGST" name="cgst" type="text" > </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group"> <label for=""> Status Approve:</label>
                            <select name="status" required class="form-control" >
                               <option value="">[Select]</option>
                               <option value="2">Approved</option>
                               <option value="0">Not Approved</option>
                            </select>
                            </div>
                        </div>
                    </div> <br>
                    <div class="modal-footer"> <button class="btn btn-secondary" data-dismiss="modal" type="button"> Close</button><button class="btn btn-primary" type="submit"> Save</button> </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script>
    var type= "{{$type}}";
        $('#datatable').DataTable({
        "processing": true,
        "order": [[ 0, "desc" ]],
        "serverSide": true,
        "ajax": {
            "url": "{{url('admin/products')}}"+'/'+type,
            "type": "GET"
        },
        "columns": [
            { data: 'id', name: 'id'},
            { data: 'checkbox', name: 'checkbox',orderable: false},
            { data: 'product_name', name: 'product_name' },
            { data: 'quantity', name: 'quantity' },
            { data: 'discount_price', name: 'discount_price' },
            { data: 'sku', name: 'sku' },
            { data: 'cid', name: 'cid' },
            { data: 'branch_id', name: 'branch_id' },
            { data: 'stock_status', name: 'stock_status' },
            { data: 'approved_status', name: 'approved_status' },
            { data: 'action', name: 'action',orderable: false},

        ]
    });
    $(document).on('click', '.delete', function(e) {
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
       }, function() {
           $.ajax({
               type: 'delete',
               url: "{{URL::to('admin/delete_product')}}",
               data: "_token=" + token + "&id=" + id,
               success: function(data1) {
                   parent.slideUp(300, function() {
                       if (data1 == 0) {
                           swal('Deleted!', 'Product Deleted', 'success');
                           $('#datatable').DataTable().ajax.reload(null,false);
                       } else {
                           $("." + id).remove();
                           $('#datatable').DataTable().ajax.reload(null,false);
                       }
                   });
               }
           });
       });
   });
   $(document).on('click', '#approve_status', function(e) {
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
       }, function() {
           $.ajax({
               type: 'post',
               url: "{{URL::to('admin/approve_product')}}",
               data: "_token=" + token + "&id=" + id,
               success: function(data) {
                   parent.slideUp(300, function() {
                       if (data.status === true) {
                           swal('Approved!', 'Product Approved', 'success');
                           $('#datatable').DataTable().ajax.reload(null,false);
                       } else {
                        toastr.success('Some think is went  to  wrong');
                       }
                   });
               }
           });
       });
   });
   //EDIt PRODUCT
   $(document).on('click', '.edit_product', function(e) {
       e.preventDefault();
       var id = $(this).attr('id');
       var token = "{{ Session::token() }}";
       var parent = $(this).parent();
        $.ajax({
            type: 'post',
            url: "{{URL::to('admin/edit_product')}}",
            data: "_token=" + token + "&id=" + id,
            dataType:"json",
            success: function(data) {
                $('#product_edit_form').trigger("reset");
                $("#hidden_id").val(data.data.id);
                $("#cid").val(data.data.cid);
                $("#product_name").val(data.data.product_name);
                $("#discount_price").val(data.data.discount_price);
                $("#quantity").val(data.data.quantity);
                $("#sku").val(data.data.sku);
                $("#branch_id").val(data.data.branch_id);
                $("#comments").val(data.data.comments);
                $("#status").val(data.data.approved_status);
                $("#product_edit").modal('show');
            }
       });
   });
      //Update Product 
      $(document).on('submit', '#insert_product', function(e) {
       e.preventDefault();
        $.ajax({
            type: 'post',
            url: "{{URL::to('admin/insert_product')}}",
            data: $('#insert_product').serialize(),
            dataType:"json",
            success: function(data) {
                if(data.status===true)
                {
                    $("#exampleModalLabel").modal('hide');
                    $('#insert_product').trigger("reset");
                    $('#datatable').DataTable().ajax.reload(null,false);
                    toastr.success('Product Added Successfully');
                }
                else
                    toastr.error('Sku Already Exsists');
            }
       });
   });
   //Update Product 
   $(document).on('submit', '#product_edit_form', function(e) {
       e.preventDefault();
        $.ajax({
            type: 'post',
            url: "{{URL::to('admin/update_product')}}",
            data: $('#product_edit_form').serialize(),
            dataType:"json",
            success: function(data) {
                $("#product_edit").modal('hide');
                $('#datatable').DataTable().ajax.reload(null,false);
                toastr.success('Product Update Successfully');
            }
       });
   });
   $('.check_all').click(function() {
       if ($(this).is(':checked', true)) {
           $(".checkbox").prop('checked', true);
       } else {
           $(".checkbox").prop('checked', false);
       }
   });
   $('.checkbox').on('click', function() {
       if ($('.checkbox:checked').length == $('.checkbox').length) {
           $('#check_all').prop('checked', true);
       } else {
           $('#check_all').prop('checked', false);
       }
   });
   $('.print').on('click', function(e) {
       e.preventDefault();
       var idsArr = [];
       $(".checkbox:checked").each(function() {
           idsArr.push($(this).attr('data-id'));
       });
       if (idsArr.length <= 0) {
           alert("Please select atleast one record to delete.");
           return false;
       } else {
          
           $("#barcode").submit();
       }
   });
</script>