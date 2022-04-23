@include('layouts.links')
@include('layouts.header')

<ul class="breadcrumb">
    <li><a href="#">Home</a></li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE TITLE -->
<div class="page-title">                    
    <h2><span class="fa fa-arrow-circle-o-left"></span> Barcodes Manager</h2>
</div>
<!-- END PAGE TITLE -->                

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
<input type="checkbox" class="check_all" style="margin-left:20px;"><span class=""> Select All</span>
    <div class="row">
        <div class="col-md-12">
            <!-- START DATATABLE EXPORT -->
            <div class="panel panel-default">               
                <div class="panel-body">
                   <form method="post" action="{{ url('admin/print_barcodes') }}" id="barcode">
                       <button class="btn btn-primary btn-rounded  print" style="margin-left:500px;" title="">Print</button>
                       {{ csrf_field() }}
                    <table id="customers2" class="table datatable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>S.No</th>
                                <th>Sku</th>
                                <th>Barcode</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach($datas as $data)
                            <tr class="{{$data->id}}">
                                <td><input type="checkbox" class="checkbox" value="{{$data->id}}" name="id[]"></td>
                                <td>
                                    {{ $i }}
                                </td>
                                <td>
                                    {{ $data->sku }}
                                </td>
                                <td><?php  echo '<img src="data:image/png;base64,'.$data->barcode_image.'" width="95px"/>'; ?></td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </form>
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
<script>
       $('.check_all').click(function(){ 
         if($(this).is(':checked',true))  
         {
            $(".checkbox").prop('checked', true);  

         } else {  
            $(".checkbox").prop('checked',false);  
         }  
        });
         $('.checkbox').on('click',function(){
            if($('.checkbox:checked').length == $('.checkbox').length){

                $('#check_all').prop('checked',true);

            }else{

                $('#check_all').prop('checked',false);
            }
         });
        $('.print').on('click', function(e) {
            var idsArr = [];  
            $(".checkbox:checked").each(function() 
            {  
                idsArr.push($(this).attr('data-id'));
            });
            
            if(idsArr.length <=0)  
            {  
                alert("Please select atleast one record to delete.");  
                return false;
            }  
            else {              
                $( "#barcode" ).submit();
            }  
        });
</script>