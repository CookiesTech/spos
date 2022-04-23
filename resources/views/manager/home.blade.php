@include('manager/layouts.links')
@include('manager/layouts.header')            
<ul class="breadcrumb">
    <li><a href="#">Home</a></li>                    
    <li class="active">Dashboard</li>
</ul>
<!-- END BREADCRUMB -->                       

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <!-- START WIDGETS -->                    
    <div class="row">
	    <div class="row" id="attendence">
        <div class="col-md-3">
            <?php $att = \App\Http\Controllers\ManagerController::get_attendence_info(Auth::user()->emp_id) ?>
           @if($att)
            @if($att->clock_out_date=='')           
            <div class="widget widget-default widget-item-icon">
                <?php
                $time = explode(' ', $att->clock_in_date)
                ?>                        
                <div class="widget-data">
                    <p>Clock Started at:{{ $time[1] }}</p>
                    <button class="btn btn-primary"  type="button" id="clockout"><i class="os-icon os-icon-ui-49">Clock out</i></button>
                </div>      

            </div>
            @else            
            <div class="widget widget-default widget-item-icon">                                       
                <div class="widget-data">
                    <button class="btn btn-primary"  type="button" id="clockin"><i class="os-icon os-icon-ui-49">Clock In</i></button>
                </div>      

            </div>     
			@endif
			@else            
            <div class="widget widget-default widget-item-icon">                                       
                <div class="widget-data">
                    <button class="btn btn-primary"  type="button" id="clockin"><i class="os-icon os-icon-ui-49">Clock In</i></button>
                </div>      
            </div>
            @endif
            <!-- END WIDGET SLIDER -->
        </div>
        <div class="col-md-3">
            <!-- START WIDGET SLIDER -->
            <div class="widget widget-default widget-carousel" onclick="location.href = 'products';">
                <div class="owl-carousel" id="owl-example">
                    <div>                                    
                        <div class="widget-title">Total Products</div>
                        <div class="widget-int">{{$pcount}}</div>
                    </div>

                </div>                            

            </div>         
            <!-- END WIDGET SLIDER -->

        </div>
            <div class="col-md-3">
            <!-- START WIDGET REGISTRED -->
            <div class="widget widget-default widget-item-icon">
                <div class="widget-item-left">
                    <span class="fa fa-shopping-cart"></span>
                </div>
                <div class="widget-data">
                    <div class="widget-title">Today Sales</div>
                    <div class="widget-int num-count">{{ $today_bill_count }}</div>
                </div>
            </div>                            
            <!-- END WIDGET REGISTRED -->
        </div>
        <div class="col-md-3">
            <!-- START WIDGET REGISTRED -->
            <div class="widget widget-default widget-item-icon">
                <div class="widget-item-left">
                    <span class="fa fa-money"></span>
                </div>
                <div class="widget-data">
                    <div class="widget-title">Today Sales Value</div>
                    <div class="widget-int num-count" style='font-size:25px !important;'>Rs{{rupee_format('%!i',$today_bill_value)}}</div>
                </div>
            </div>                            
            <!-- END WIDGET REGISTRED -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel-title-box">
                <h3>Latest 10 Orders</h3>
            </div>
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
                                    Invoice ID
                                </th>
                                <th>
                                    Customer Name
                                </th>
                                <th>
                                    Payment Mode
                                </th>
                                <th>
                                    Date
                                </th>
                                <th>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                                                     <tbody>
                            <?php $i = 1; ?>
                            @foreach($datas as $data)

                            <tr id="tr_{{$data->id}}">

                                <td>
                                    {{ $i }}
                                </td>
                                <td>
                                    #{{ $data->invoice_id }}
                                </td>
                                <td>
                                    {{ $data->customer_name }}
                                </td>
                                <td>
                                    {{ $data->payment_mode }}
                                </td>
                                <td>
                                    {{ $data->created_at }}
                                </td>

                                <td class="row-actions">
                                    <a href="{{url('manager/invoice')}}/{{$data->invoice_id}}" class="btn btn-primary" ><i class="os-icon os-icon-ui-49">View</i></a>                             
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
<!-- END PAGE CONTENT WRAPPER -->                                
</div>            
<!-- END PAGE CONTENT -->
</div>
</div>
</div>

@include('manager/layouts.footer')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>   

<script>
$('#clockin').click(function (e) {
    $(':button').prop('disabled', true);
    var token = "{{ Session::token() }}";
    $.ajax({
        type: 'post',
        url: "{{URL::to('manager/manager_clockin')}}",
        data: "_token=" + token,
        success: function (data1) {
            $(':button').prop('disabled', false);
            if (data1 !== 0)
            {
                swal('Success!', 'Clocked In', 'success');
                $("#attendence").load(window.location + " #attendence");
                $('#last_id').val(data1);

            } else
            {

            }


        }
    });
});
//Clock Out

$(document).on('click', '#clockout', function (e) {
   $(':button').prop('disabled', true);
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
                    url: "{{URL::to('manager/manager_clockout')}}",
                    data: "_token=" + token ,
                    success: function (data1) {
                        if (data1 == 1)
                        {
                            swal('Success!', 'Clocked Out', 'success');
                            $("#attendence").load(window.location + " #attendence");


                        } else
                        {

                        }
                    }
                });
                  }
            });
});
</script>