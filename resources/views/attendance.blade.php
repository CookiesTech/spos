@include('layouts.links')
@include('layouts.header')
<?php

use \App\Http\Controllers\HomeController; ?>
<ul class="breadcrumb">
    <li><a href="home">Home</a></li>
    <li><a href="attendance">Attendance</a></li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE TITLE -->
<div class="page-title">                    
    <h2> Employee Attendance</h2>
</div>
<!-- END PAGE TITLE -->                

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">



    <div class="row" id="attendence">
        <div class="col-md-12">

            <!-- START DATATABLE EXPORT -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-body">
                            {{ csrf_field() }}
                            <table id="customers2" class="table datatable">
                                <thead>
                                    <tr>

                                        <th>
                                            EMP ID
                                        </th>
                                        <th>
                                            Employee Name
                                        </th>
                                        <th>
                                            Date Time
                                        </th>
                                        <th>
                                            Action
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach($datas as $data)
                                    <tr class="{{$data->id}}">
                                        <td>
                                            {{ $data->id}}
                                        </td>
                                        <td> 
                                           {{ $data->fname }}{{ $data->lname }}
                                        </td>
                                        <td>
                                            {{ date("d-m-Y h:i:s") }}
                                        </td>
                                        <td>
                                            <div class="form-group">                                                                                   
                                                <button class="btn btn-primary" data-id="{{ $data->id }}"  type="button" id="clockin"><i class="os-icon os-icon-ui-49">Clock In</i></button>                                              
                                            </div>
                                        </td>
                                       </tr>
                                     <?php $i++; ?>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>

            <div class="page-title">                    
                <h2> Clocked In Employees</h2>
            </div>
            <table id="customers3" class="table datatable">
                <thead>
                    <tr>
						<th>
						 Emp ID
						</th>
                        <th>
                            Employee Name
                        </th>
                        <th>
                           Clock In Time
                        </th>
						 <th>
                           Clock out Time
                        </th>
						 <th>
                            Total Hr
                        </th>
                        <th>
                            Action
                        </th>
                        
                    </tr>
                </thead>
                <tbody>

<?php $i = 1; $date='';$time=''; ?>

                    @foreach($att as $data)
                    <?php 
                    $d2=explode(' ',$data->clock_out_date);
                    ?>
                    <tr class="{{$data->id}}">
                        <td>
                            {{ $data->emp_id}}
                        </td> 
                        <td>
                            {{ $data->fname }}{{ $data->lname }}
                        </td>
                        <td>   
                            {{ $data->clock_in_date }}
                        </td>
                        <td>
                            {{ $data->clock_out_date }}
                        </td>
						<td>
						{{ $data->total_time }}
						</td>
                        <td>
						@if(empty($data->clock_out_date))
                        <button class="btn btn-primary"  type="button" data-id="{{ $data->emp_id }}" id="clockout"><i class="os-icon os-icon-ui-49">Clock out</i></button>
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
<!-- END PAGE CONTENT -->
</div>
</div>
</div>

@include('layouts.footer')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>   


<script>
$('#clockin').click(function (e) {
   $(':button').prop('disabled', true);
    var token = "{{ Session::token() }}";
    var emp_id=$(this).data('id');
    $.ajax({
        type: 'post',
        url: "{{URL::to('admin/staff_clockin')}}",
        data: "_token=" + token + "&emp_id=" + emp_id,
        success: function (data1) {
             $(':button').prop('disabled', false);
            if (data1 !== 0)
            {
                swal('Success!', 'Clocked In', 'success');
                 window.location.reload();
            } else
            {

            }
        }
    });
});
//Clock Out
$(document).on('click', '#clockout', function (e) {
    $(':button').prop('disabled', true);
    var emp_id=$(this).data('id');
    var token = "{{ Session::token() }}";
    swal({
        title: 'Are you sure?',
        text: "want to clock out!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, clock out!',
        showLoaderOnConfirm: true,
    },
            function (inputValue) {
                if (inputValue===false) {
                   $(':button').prop('disabled', false);
                  } else {
                $.ajax({
                    type: 'post',
                    url: "{{URL::to('admin/staff_clockout')}}",
                    data: "_token=" + token + "&emp_id=" + emp_id,
                    success: function (data1) {
                        $(':button').prop('disabled', false);
                        if (data1 == 1)
                        {
                            swal('Success!', 'Clocked Out', 'success');
                             window.location.reload();
                        } else
                        {

                        }
                    }
                });
                  }
            });
});
</script>