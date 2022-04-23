@include('staff/layouts.links')
@include('staff/layouts.header')

<title>Staff- Products</title>
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
                                    Category
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
                                    {{ $data->cid }}
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
                                    @if($data->quantity< 2)
                                    <span class="label label-danger">{{ $data->stock_status }}</span>
                                    @else
                                    <span class="label label-success">{{ $data->stock_status }}</span>
                                    @endif
                                </td>
                                <td class="row-actions">
                                    @if($data->approved_status!=2)
                                    <button class="btn btn-primary" data-target="#edit{{ $data->id  }}" data-toggle="modal" type="button"><i class="os-icon os-icon-ui-49">Edit</i></button>
                                    @else
                                     <span class="label label-success">Status Approved</span>
                                    @endif
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

@include('staff/layouts.footer')

@foreach($datas as $data)
<div aria-hidden="true" aria-labelledby="" class="modal fade" id="edit{{ $data->id }}" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Did all products received correctly?
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{url('staff/update_product_status')}}" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    {{ csrf_field() }}
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for=""> Yes:</label><input  type="radio"  value="2" name="status" id="status" data-id="{{ $data->id }}" >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">No:</label><input  value="0" name="status" id="status" type="radio"  data-id="{{ $data->id }}">
                            </div>
                        </div>

                    </div>
                    <div class="row" id="comments{{ $data->id }}" style="display:none;">

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">Enter Comments:</label><textarea class="form-control comments{{ $data->id }}" name="comments" rows="3" ></textarea>
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
<script>
   $(document).on('click', '#status', function (e) {
       var status=$(this).val();
       var id=$(this).data('id');
       if(status==0){
           $('#comments'+id+'').show();
           $('.comments'+id+'').attr('required', 'required');
       }else{
           $('#comments'+id+'').hide();
           $('.comments'+id+'').removeAttr('required', 'required');
       }

   });
</script>