@include('manager/layouts.links')
@include('manager/layouts.header') 
<style>
 .table > tbody > tr > td{
	 border:1px solid;
 }
</style>
<ul class="breadcrumb">
    <li><a href="home">Home</a></li>
    <li class="active">Stock</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE TITLE -->
<div class="page-title">                    
    <h2><span class="fa fa-arrow-circle-o-left"></span> Stock Master</h2>
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
								Branch Name
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
                                    Barcode
                                </th>                                
                                <th>
                                    Approved Status
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
								{{ $data->branch_name }}
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
                                    <span class="label label-success" >{{ $data->stock_status }}</span>
                                    @endif
                                </td>                                                          
                                <td><?php  echo '<img src="data:image/png;base64,'.$data->barcode_image.'" width="95px"/>'; ?></td>
                                 <td>
                                    @if($data->approved_status!=2)
                                    <a href=""> <span class="label label-danger" id="approve_status" data-id="{{ $data->id }}">Pending</span></a>
                                    @else
                                    <span class="label label-success">Approved</span>
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

@include('manager/layouts.footer')
