<?php 
setlocale(LC_MONETARY, 'en_IN');
?>
@include('staff/layouts.links')
@include('staff/layouts.header')            
<title>Staff- Dashboard</title>
<style>
    .money
    {
        text-align: center;
        font-size: 12px;
        font-weight: bold;
    }
    .box-widget {
    border: none;
    position: relative;
}
.box {
    position: relative;
    border-radius: 3px;
    background: #ffffff;
    border-top: 3px solid #d2d6de;
    margin-bottom: 20px;
    width: 100%;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}
.box-widget .widget-user-header {
    padding: 2px;
    border-top-right-radius: 3px;
    border-top-left-radius: 3px;
}

.widget-user-desc {
    text-align: center;
    color:#fff;
    margin-top: 0;
}
.widget-user-username {
    margin-top: 5px;
    margin-bottom: 5px;
    font-size: 20px;
    font-weight: 300;
    color:#fff;
    text-align: center;
}
.widget-user-image>img {
    width: 65px;
    height: auto;
    float: left;
}
.no-padding {
    padding: 0 !important;
}
.box-footer {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-bottom-right-radius: 3px;
    border-bottom-left-radius: 3px;
    border-top: 1px solid #f4f4f4;
    padding: 10px;
    background-color: #fff;
}
.box .nav-stacked>li {
    border-bottom: 1px solid #f4f4f4;
    margin: 0;
}
.nav-stacked>li>a {
    border-radius: 0;
    border-top: 0;
    border-left: 3px solid transparent;
    color: #444;
}
.bg-yellow {
    background-color: #f39c12 !important;
}
.bg-green {
    background-color: #00a65a !important;
}
.bg-red {
    background-color: #dd4b39 !important;
}
</style>
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <br><br>
    <!-- START WIDGETS -->                    
    <div class="row" id="attendence">
        <div class="col-md-3">
            <?php $att = \App\Http\Controllers\StaffController::get_attendence_info(Auth::user()->emp_id) ?>
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
                    <div class="widget-int num-count" style="font-size:25px !important;">Rs{{rupee_format('%!i',$today_bill_value)}}</div>
                </div>
            </div>                            
            <!-- END WIDGET REGISTRED -->
        </div>
        <div class="col-md-3">
            <!-- START WIDGET REGISTRED -->
            <div class="widget widget-default widget-item-icon">
                <div class="widget-title">Today Money Source</div>
                @foreach($today_bill_source as $today_bill_sources)
                <p class="money">{{$today_bill_sources->payment_mode}}: Rs{{rupee_format('%!i',$today_bill_sources->total_amt)}}</p>
                @endforeach
            </div>                            
            <!-- END WIDGET REGISTRED -->
        </div>
    </div>
    <!---Today Target Amount----->
    @if(!empty($today_target_data))
    <div class="bootdey">
    <div class="row bootstrap snippets bootdey">
    <div class="col-md-3">
      <div class="box box-widget widget-user-2">
      <div class="widget-user-header bg-yellow">
          <h3 class="widget-user-username">Today Target</h3>
          <h5 class="widget-user-desc">We Can Do It..</h5>
        </div>
        <div class="box-footer no-padding">
          <ul class="nav nav-stacked">
            <li><a href="#">Target Amount  <span class="pull-right badge bg-defult">{{$today_target_data->target_amt}}</span></a></li>
            <li><a href="#">Carry Forward <span class="pull-right badge bg-defult">{{$today_target_data->carry_forward_amt}}</span></a></li>
            <li><a href="#">Today Sales<span class="pull-right badge bg-defult">{{$today_target_data->day_sales_value}}</span></a></li>
            <li><a href="#">Total Target <span class="pull-right badge bg-defult">{{$today_target_data->target_amt+$today_target_data->carry_forward_amt}}</span></a></li>
            <?php
                $balance=0;
                $total_target=$today_target_data->target_amt+$today_target_data->carry_forward_amt;
                if($total_target > $today_target_data->day_sales_value)
                    $btn='<li><a href="#">Balance <span class="pull-right badge bg-red">'.($total_target-$today_target_data->day_sales_value).'</span></a></li>';
                else
                    $btn='<li><a href="#">Balance <span class="pull-right badge bg-green">'.($today_target_data->day_sales_value-$total_target).'</span></a></li>';
            ?>
            <?php echo $btn;?>
          </ul>
        </div>
      </div>
    </div>
</div>
@endif
</div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel-title-box">
                <h3>Today Latest 10 Orders</h3>
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
                                    Cash Recevied
                                </th>
                                 <th>
                                    Balance
                                </th>
                                 <th>
                                    Total
                                </th>
                                <th>
                                    Date
                                </th>
                                <th>
                                    Actions
                                </th>
                            </tr>
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
                                    Rs{{rupee_format('%!i',$data->payable_amount)}}
                                </td>
                                 <td>
                                    Rs{{rupee_format('%!i',$data->balance)}}
                                </td>
                                 <td>
                                    Rs{{rupee_format('%!i',$data->total_amount)}}
                                </td>
                                <td>
                                    {{ date('d/m/Y H:i:s a',strtotime($data->created_at)) }}
                                </td>
                                <td class="row-actions">
                                    <a href="{{url('staff/invoice')}}/{{$data->invoice_id}}" class="btn btn-primary" ><i class="os-icon os-icon-ui-49">View</i></a>                             
                                </td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                        </tbody>
                        </thead>
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

@include('staff/layouts.footer')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>   


<script>
$('#clockin').click(function (e) {
    $(':button').prop('disabled', true);
    var token = "{{ Session::token() }}";
    $.ajax({
        type: 'post',
        url: "{{URL::to('staff/staff_clockin')}}",
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
                    url: "{{URL::to('staff/staff_clockout')}}",
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