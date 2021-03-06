@include('layouts.links')@include('layouts.header')
<ul class="breadcrumb">
   <li><a href="#">Home</a></li>
</ul>
<!-- END BREADCRUMB --><!-- PAGE TITLE -->
<div class="page-title">
   <h2><span class="fa fa-arrow-circle-o-left"></span> Branches Manager</h2>
</div>
<!-- END PAGE TITLE -->                <!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
   <div class="row">
      <div class="col-md-12">
         <!-- START DATATABLE EXPORT -->            
         <div class="panel panel-default">
            <div class="panel-body">
               <button class="btn btn-primary" data-target="#exampleModal1" data-toggle="modal" type="button" style="float:right">Add New Branch</button><br><br>                    
               <table id="customers2" class="table datatable">
                  <thead>
                     <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Branch ID</th>
                        <th>In TamilNadu</th>
                        <th>GST NO</th>
                        <th>Ph</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $i = 1; ?>                            @foreach($datas as $data)                            
                     <tr class="{{$data->id}}">
                        <td>                                    {{ $i }}                                </td>
                        <td>                                    {{ $data->name }}                                </td>
                        <td>                                    {{ $data->branch_id }}                                </td>
                        <td>                                    {{ $data->in_tamilnadu }}                                </td>
                        <td>                                    {{ $data->gst_no }}                                </td>
                        <td>                                    {{ $data->phone }}                                </td>
                        <td class="text-center">                                   
                           <button class="btn btn-primary" data-target="#exampleModal-{{$data->branch_id}}" data-toggle="modal" type="button">Edit </button>                                
                        </td>
                     </tr>
                     <?php $i++; ?>                            @endforeach                        
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
</div>            <!-- END PAGE CONTENT --></div></div></div>@include('layouts.footer')
<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="exampleModal1" role="dialog" tabindex="-1">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">                    Add New Branch                </h5>
         </div>
         <div class="modal-body">
            <form method="post" action="insert_branch" enctype="multipart/form-data">
               {{ csrf_field() }}                    
               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group">                                
                        <label for=""> Branch Area:</label>
                        <input class="form-control" placeholder="Enter Branch Area" name="name"  type="text" required>                            </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for=""> In TamilNadu:</label>								
                        <select class="form-control" name="in_tamilnadu" required >
                           <option value="">[Select]</option>
                           <option value="yes">Yes</option>
                           <option value="no">No</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group">                                
                        <label for="">Phone:</label>
                        <input type="text" class="form-control" name="phone" required>                         
                       </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">                                
                        <label for="">GST NO:</label>
                        <input type="text" class="form-control" name="gst_no"  required>                         
                       </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="form-group">                                <label for="">Address:</label><textarea class="form-control" name="address" rows="3" required></textarea>                            </div>
                  </div>
               </div>
               <br>                    
               <div class="modal-footer">                        <button class="btn btn-secondary" data-dismiss="modal" type="button"> Close</button><button class="btn btn-primary" type="submit"> Save changes</button>                    </div>
            </form>
         </div>
      </div>
   </div>
</div>
<!----- Edit--->@foreach($datas as $data)
<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="exampleModal-{{$data->branch_id}}" role="dialog" tabindex="-1">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">                   Edit Branch Details                </h5>
         </div>
         <div class="modal-body">
            <form method="post" action="update_branch" enctype="multipart/form-data">
               <input type="hidden" name="row_id" value="{{$data->id}}">                    {{ csrf_field() }}                    
               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group">                                
                        <label for=""> Branch Area:</label>								
                        <input class="form-control" placeholder="Enter Branch Area" name="name"  type="text" required value="{{$data->name}}">                            </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for=""> In TamilNadu:</label>								
                        <select class="form-control" name="in_tamilnadu" required >
                           <option value="">[Select]</option>
                           <option value="yes" @if($data->in_tamilnadu=="yes") selected @endif>Yes</option>								<option value="no" @if($data->in_tamilnadu=="no") selected @endif>No</option>								
                        </select>
                     </div>
                  </div>
               </div>
               <div class="row">
               <div class="col-sm-6">
                     <div class="form-group">                                
                        <label for="">Phone:</label>
                        <input type="text" class="form-control" name="phone" required  value="{{$data->phone}}">                         
                       </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">                                
                        <label for="">GST NO:</label>
                        <input type="text" class="form-control" name="gst_no" required value="{{$data->gst_no}}">                         
                       </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-612">
                     <div class="form-group">                                <label for="">Address:</label><textarea class="form-control" name="address" rows="3" required>{{$data->address}}</textarea>                            </div>
                  </div>
               </div>
               <br>                    
               <div class="modal-footer">                        <button class="btn btn-secondary" data-dismiss="modal" type="button"> Close</button><button class="btn btn-primary" type="submit"> Save changes</button>                    </div>
            </form>
         </div>
      </div>
   </div>
</div>
@endforeach
