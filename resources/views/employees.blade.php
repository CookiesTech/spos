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
    </span> Employees Master
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
            <button class="btn btn-primary" data-target="#exampleModal1" data-toggle="modal" type="button" style="float:right">Add New Employee
            </button>
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
                <th>                                    Employee Name                                
                </th>                                
                <th>                                    Branch                                
                </th>                                
                <th>                                    Emp Id                                
                </th>                                
                <th>                                    Status                                
                </th>                                
                <th>                                    Actions                                
                </th>                            
              </tr>                        
            </thead>                        
            <tbody>                            
              <?php $i = 1; ?>                            @foreach($datas as $data)                            
              <tr class="{{$data->id}}">                               
                <td>                                    {{ $i }}                                
                </td>                                
                <td>                                    {{ $data->fname }}                                
                </td>                                
                <td>                                    {{ $data->branch_id }}                                
                </td>                                
                <td>                                    {{ $data->emp_id }}                                
                </td>                                
                <td>                                    {{ $data->status }}                                
                </td>                                
                <td class="row-actions">                                    
                  <button class="btn btn-primary" data-target="#edit{{ $data->id  }}" data-toggle="modal" type="button">
                    <i class="os-icon os-icon-ui-49">Edit
                    </i>
                  </button>                                    
                  <button class="btn btn-primary delete" type="button" data-id="{{$data->emp_id}}">
                    <i class="os-icon os-icon-ui-15">Delete
                    </i>
                  </button>                                
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
</div>            
<!-- END PAGE CONTENT -->
</div>
</div>
</div>@include('layouts.footer') @foreach($datas as $data)    
<div aria-hidden="true" aria-labelledby="" class="modal fade" id="edit{{ $data->id }}" role="dialog" tabindex="-1">        
  <div class="modal-dialog" role="document">            
    <div class="modal-content">                
      <div class="modal-header">                    
        <h5 class="modal-title" id="exampleModalLabel">                        Edit Employee                    
        </h5>                    
        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
          <span aria-hidden="true"> &times;
          </span>
        </button>                
      </div>                
      <div class="modal-body">                    
        <form method="post" action="{{ url('admin/update_employee') }}">                        
          <input type="hidden" name="id" value="{{ $data->id }}">                        {{ csrf_field() }}                        
          <div class="row">                            
            <div class="col-sm-12">                                
              <div class="form-group">                                    
                <label for=""> Branch:
                </label>                                    
                <select class="form-control" name="branch_id" required>                                        
                  <option value="">                                            Select Branch                                        
                  </option>                                        @foreach($branches as $de)                                        
                  <option value="{{ $de->branch_id }}" {{ $de->branch_id == $data->branch_id? 'selected' : '' }}>{{$de->name}}
                  </option>                                        @endforeach                                     
                </select>                                
              </div>                            
            </div>                        
          </div>                        
          <div class="row">                            
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for=""> First Name:
                </label>
                <input class="form-control" value="{{ $data->fname }}" name="fname"  type="text">                                
              </div>                            
            </div>                            
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for="">Last Name:
                </label>
                <input class="form-control" value="{{ $data->lname }}" name="lname" type="text">                                
              </div>                            
            </div>                        
          </div>                        
          <div class="row">                            
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for="">Salary:(Rs)
                </label>
                <input class="form-control" value="{{ $data->salary }}" name="salary" type="text">                                
              </div>                            
            </div>                              
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for="">Phone Number:
                </label>
                <input class="form-control" value="{{ $data->phone_no }}" name="phone_no" type="number">                                
              </div>                            
            </div>                        
          </div>                        
          <div class="row">                            
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for=""> Email:
                </label>
                <input class="form-control" value="{{ $data->email }}" name="email" type="email">                                
              </div>                            
            </div>                            
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for=""> Password:
                </label>
                <input class="form-control" placeholder="Enter Password" name="password"  type="text" required value="{{ $data->password }}" >                                
              </div>                            
            </div>                        
          </div>                        
          <div class="row">                                                        
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for="">Date Of Joining:
                </label>
                <input class="form-control" id="date" name="doj" placeholder="MM/DD/YYYY" type="text" value="{{ $data->doj }}"/>                                
              </div>                            
            </div>                            
            <div class="col-sm-6">                                
              <div class="form-group">                                  
                <label for=""> Role:
                </label>                                  
                <select class="form-control" name="role">                                        
                  <option value="">Select Role
                  </option>                                        
                  <option value="manager" {{ $data->role == 'manager'? 'selected' : '' }}> Manager 
                  </option>                                        
                  <option value="staff" {{ $data->role == 'staff'? 'selected' : '' }}>Staff
                  </option>                                                                           
                </select>                                                                     
              </div>                            
            </div>                        
          </div>                        
          <div class="row">                            
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for="">Local Address:
                </label>
                <textarea class="form-control" name="address" rows="3">{{ $data->address }}
                </textarea>                                
              </div>                            
            </div>                            
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for="">Permanent  Address:
                </label>
                <textarea class="form-control" name="permanent_address" rows="3">{{ $data->permanent_address }}
                </textarea>                                
              </div>                            
            </div>                        
          </div>                        
          <div class="row">                            
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for=""> Gender:
                </label>
                <select class="form-control" name="gender">                                        
                  <option value="">Select Gender
                  </option>                                        
                  <option value="Male" {{ $data->gender == 'Male'? 'selected' : '' }}> Male 
                  </option>                                        
                  <option value="Female" {{ $data->gender == 'Female'? 'selected' : '' }}>Female
                  </option>                                                                           
                </select>                                
              </div>                            
            </div>                            
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for="">Image:
                </label>
                <input class="form-control" value="{{ $data->image }}" name="image" type="file" >                                    
                <img src= "{{ $data->image }}" style="width:104px;height:128px" />                                                                 
              </div>                            
            </div>                        
          </div>						       
          <div class="row">                            
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for=""> Bank Name:
                </label>
                <input class="form-control" value="{{ $data->bank_name }}" placeholder="Enter bank Id" name="bank" type="text" >                                
              </div>                            
            </div>                             
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for=""> Branch:
                </label>
                <input class="form-control" value="{{ $data->bank_branch }}" placeholder="Enter Branch" name="bank_branch"  type="text" >                                
              </div>                            
            </div>                        
          </div>						 
          <div class="row">                            
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for=""> A/C No:
                </label>
                <input class="form-control" value="{{ $data->ac }}" placeholder="Enter A/c No" name="ac" type="text" >                                
              </div>                            
            </div>                             
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for=""> IFSC Code:
                </label>
                <input class="form-control" value="{{ $data->ifsc }}" placeholder="Enter IFSC Code" name="ifsc"  type="text" >                                
              </div>                            
            </div>                        
          </div>                        
          <div class="modal-footer">                            
            <button class="btn btn-secondary" data-dismiss="modal" type="button"> Close
            </button>
            <button class="btn btn-primary" type="submit"> Save changes
            </button>                        
          </div>                    
        </form>                
      </div>            
    </div>        
  </div>    
</div>    @endforeach    
<!-- ADD  -->    
<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="exampleModal1" role="dialog" tabindex="-1">        
  <div class="modal-dialog" role="document">            
    <div class="modal-content">                
      <div class="modal-header">                    
        <h5 class="modal-title" id="exampleModalLabel">                        Add New Employee                    
        </h5>                    
        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
          <span aria-hidden="true"> &times;
          </span>
        </button>                
      </div>                
      <div class="modal-body">                    
        <form method="post" action="{{ url('admin/insert_employee') }}" enctype="multipart/form-data">                        {{ csrf_field() }}                        
          <div class="row">                            
            <div class="col-sm-12">                                
              <div class="form-group">                                    
                <label for=""> Branch:
                </label>                                    
                <select class="form-control" name="branch_id" required>                                        
                  <option value="">                                            Select Branch                                        
                  </option>                                        @foreach($branches as $de)                                        
                  <option value="{{ $de->branch_id }}">                                            {{ $de->name }}                                        
                  </option>                                        @endforeach                                     
                </select>                                
              </div>                            
            </div>                        
          </div>                        
          <div class="row">                            
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for=""> First Name:
                </label>
                <input class="form-control" placeholder="Enter First Name" name="fname"  type="text" required>                                
              </div>                            
            </div>                            
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for="">Last Name:
                </label>
                <input class="form-control" placeholder="Enter Last Name" name="lname" type="text" required>                                
              </div>                            
            </div>                                                    
          </div>                        
          <div class="row">                            
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for="">Phone Number:
                </label>
                <input class="form-control" placeholder="Enter Phone Number" name="phone_no" type="number" required>                                
              </div>                            
            </div>                            
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for="">Salary:(Rs)
                </label>
                <input class="form-control" placeholder="Enter Salary" name="salary" type="text" required>                                
              </div>                            
            </div>                                                    
          </div>                        
          <div class="row">                            
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for=""> Email:
                </label>
                <input class="form-control" placeholder="Enter Email Id" name="email" type="email" required>                                
              </div>                            
            </div>                             
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for=""> Password:
                </label>
                <input class="form-control" placeholder="Enter Password" name="password"  type="text" required>                                
              </div>                            
            </div>                        
          </div>                        
          <div class="row">                                                        
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for="">Date Of Joining:
                </label>
                <input class="form-control" id="date" name="doj" placeholder="MM/DD/YYYY" type="date" required/>                                
              </div>                            
            </div>                            
            <div class="col-sm-6">                                
              <div class="form-group">                                  
                <label for=""> Role:
                </label>                                  
                <select class="form-control" name="role" required >                                        
                  <option value="">Select Role
                  </option>                                        
                  <option value="manager" > Manager 
                  </option>                                        
                  <option value="staff" >Staff
                  </option>                                                                           
                </select>                                                                     
              </div>                            
            </div>                        
          </div>                        
          <div class="row">                            
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for="">Local Address:
                </label>
                <textarea class="form-control" name="address" rows="3" required>
                </textarea>                                
              </div>                            
            </div>                            
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for="">Permanent Address:
                </label>
                <textarea class="form-control" name="permanent_address" rows="3" required>
                </textarea>                                
              </div>                            
            </div>                        
          </div>                        
          <br>                        
          <div class="row">                            
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for=""> Gender:
                </label>                                    
                <select   class="form-control" name="gender" required>                                        
                  <option value="">Select Gender
                  </option>                                        
                  <option value="Male">Male
                  </option>                                        
                  <option value="Female">Female
                  </option>                                    
                </select>                                
              </div>                            
            </div>                            
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for="">Photo:
                </label>
                <input class="form-control" placeholder="Select Image" name="image" type="file" >                                
              </div>                            
            </div>                        
          </div>                       
          <div class="row">                            
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for=""> Bank Name:
                </label>
                <input class="form-control" placeholder="Enter bank Id" name="bank" type="text" >                                
              </div>                            
            </div>                             
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for=""> Branch:
                </label>
                <input class="form-control" placeholder="Enter Branch" name="bank_branch"  type="text" >                                
              </div>                            
            </div>                        
          </div>						 
          <div class="row">                            
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for=""> A/C No:
                </label>
                <input class="form-control" placeholder="Enter A/c No" name="ac" type="text" >                                
              </div>                            
            </div>                             
            <div class="col-sm-6">                                
              <div class="form-group">                                    
                <label for=""> IFSC Code:
                </label>
                <input class="form-control" placeholder="Enter IFSC Code" name="ifsc"  type="text" >                                
              </div>                            
            </div>                        
          </div>                        
          <br>                        
          <div class="modal-footer">                            
            <button class="btn btn-secondary" data-dismiss="modal" type="button"> Close
            </button>
            <button class="btn btn-primary" type="submit"> Save
            </button>                        
          </div>                    
        </form>                
      </div>            
    </div>        
  </div>    
</div>    
<script>    $(document).on('click', '.delete', function (e) {
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
