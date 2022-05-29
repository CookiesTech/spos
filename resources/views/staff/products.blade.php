@include('staff/layouts.links')
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
@include('staff/layouts.header')
<ul class="breadcrumb">
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
            <div class="panel panel-default"> 
                <div class="panel-body"> <br><br>
                         {{ csrf_field() }}
                        <table id="datatable" class="table table-border">
                            <thead>
                                <tr>
                                    <th>S.NO </th>  
                                    <th> Product Name </th>
                                    <th> Quantity </th>
                                    <th> Selling Price </th>
                                    <th> Sku </th>
                                    <th> Category </th>
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
<div aria-hidden="true" aria-labelledby="" class="modal fade" id="approve_product_modal" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Did all products received correctly?
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
            </div>
            <div class="modal-body">
                <form method="post" id="approve_product_form" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="hidden_id" value="">
                    {{ csrf_field() }}
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""> Yes:</label><input  type="radio"  value="2" name="status" id="status" >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">No:</label><input  value="0" name="status" id="status" type="radio">
                            </div>
                        </div>

                    </div>
                    <div class="row" id="comments" style="display:none;">

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Enter Comments:</label><textarea class="form-control comments" name="comments" rows="3" ></textarea>
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
@include('staff/layouts.footer')
<!-- ADD  -->
<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script>
        $('#datatable').DataTable({
        "processing": true,
        "order": [[ 0, "desc" ]],
        "serverSide": true,
        "ajax": {
            "url": "{{url('staff/staff_products')}}",
            "type": "GET"
        },
        "columns": [
            { data: 'id', name: 'id' },
            { data: 'product_name', name: 'product_name' },
            { data: 'quantity', name: 'quantity' },
            { data: 'discount_price', name: 'discount_price' },
            { data: 'sku', name: 'sku' },
            { data: 'cid', name: 'cid' },
            { data: 'stock_status', name: 'stock_status' },
            { data: 'action', name: 'action',orderable: false},

        ]
    });
    $(document).on('click', '#status', function (e) {
       var status=$(this).val();
       if(status==0){
           $('#comments').show();
           $('.comments').attr('required', 'required');
       }else{
           $('#comments').hide();
           $('.comments').removeAttr('required', 'required');
       }
   });
   $(document).on('click', '.approve_product', function(e) {
       e.preventDefault();
       $('#approve_product_form').trigger("reset");
        $("#hidden_id").attr('data-id');
        $("#approve_product_modal").modal('show');
   });
   //Update Product 
   $(document).on('submit', '#approve_product_form', function(e) {
       e.preventDefault();
        $.ajax({
            type: 'post',
            url: "{{URL::to('staff/update_product_status')}}",
            data: $('#approve_product_form').serialize(),
            dataType:"json",
            success: function(data) {
                if(data.status===true)
                {
                    $("#approve_product_modal").modal('hide');
                    $('#approve_product_form').trigger("reset");
                    $('#datatable').DataTable().ajax.reload(null,false);
                    toastr.success('Product Update Successfully');
                }
                else
                    toastr.error('Sku Something  is went  wrong');
            }
       });
   });
</script>