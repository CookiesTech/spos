@include('layouts.links')@include('layouts.header')
<ul class="breadcrumb">    
  <li>
    <a href="home">Home
    </a>
  </li>    
  <li class="active">Employees
  </li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE TITLE -->
<div class="page-title">                        
  <h2>
    <span class="fa fa-arrow-circle-o-left">
    </span> Target Master -  {{date('F') }}
  </h2>
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
           <a href="{{ ('add_new_target') }}"> <button class="btn btn-primary"  type="button" style="float:right">Add New Target
            </button></a>
            <br>
            <br>                    
          </div>                                                    
        </div>      
        <div class="panel-body">                    
          <table id="customers2" class="table datatable">                        
            <thead>                            
              <tr>                                
                <th>                                    S.No                            
                </th>                                   
                <th>                                    Branch                                
                </th>                                
                <th>                                    Emp Id                                
                </th>                                
                <th>                                    From Date                            
                </th>                                
                <th>                                    To Date                            
                </th>                                
                <th>                                    Target Amount                            
                </th>                                                                    
                <th>                                    Sales Amount                                
                </th>                                                                     
                <th>                                    Balance                               
                </th>                                
                <!-- <th>                                    Actions                                
                </th>                             -->
              </tr>                        
            </thead>                        
            <tbody>                            
              <?php $i = 1; ?>                            @foreach($datas as $data)                            
              <tr class="{{$data->id}}">                               
                <td>                                    {{ $i }}                                
                </td>                                
                <td>                                    {{ $data->branch_id }}                                
                </td>                                
                <td>                                    {{ $data->emp_id }}                                
                </td>                                
                <td>                                    {{ $data->from_date }}                                
                </td>                                
                <td>                                    {{ $data->to_date }}                                
                </td>                                 
                <td>                                    {{ $data->target_amount }}                                
                </td>                                
                <td>                                    {{ $data->sales_amount }}                                
                </td>                                 
               @if($data->target_amount >=$data->sales_amount) 
               <td>
                 <span class="label label-danger">{{ ($data->target_amount-$data->sales_amount) }}</span>  
                </td>
                @else
                    <td>
                    <span class="label label-success"> {{ $data->target_amount-$data->sales_amount }}</span>  
                </td>
                @endif
                <!-- <td class="row-actions">                                    
                  <button class="btn btn-primary" data-target="#edit{{ $data->id  }}" data-toggle="modal" type="button">
                    <i class="os-icon os-icon-ui-49">Edit
                    </i>
                  </button>                                    
                  <button class="btn btn-primary delete" type="button" data-id="{{$data->emp_id}}">
                    <i class="os-icon os-icon-ui-15">Delete
                    </i>
                  </button>                                
                </td>                             -->
              </tr>                            
              <?php $i++; ?>                            @endforeach                        
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
</div>@include('layouts.footer')  

<script>   
 $(document).on('click', '.delete', function (e) {
    var id = $(this).data('id');
    e.preventDefault();
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
       }
         , 
         function () {
      $.ajax({
        type: 'delete',                       
        url: "{{URL::to('admin/delete_employee')}}",                           
        data: "_token=" + token + "&id=" + id,                       
        beforeSend: function () {
          $("." + id).css("background-color", "#fb6c6c");
        }
        ,                        success: function (data1) {
          if (data1 !=0)                                {
            swal('Deleted!', 'Employee Deleted', 'success');
            $("#customers2").load(window.location + " #customers2");
          }
          else                                {
            $("#customers2").load(window.location + " #customers2");
          }
        }
      }
            );
    }
        );
  }
                          );
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js">
</script>    
