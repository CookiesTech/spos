@include('layouts.links')
@include('layouts.header')
<style>
    .money
    {
        text-align: center;
        font-size: 12px;
        font-weight: bold;
    }
    body{
    margin-top:20px;
    background:#eee;
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
<ul class="breadcrumb">
    <li><a href="#">Home</a></li>                    
    <li class="active">Dashboard</li>
</ul>
<!-- END BREADCRUMB -->                       
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <!-- START WIDGETS -->                    
    <div class="row">
        <div class="col-md-3">
            <!-- START WIDGET SLIDER -->
            <div class="widget widget-default widget-carousel" onclick="location.href = 'products';">
                <div class="owl-carousel" id="owl-example">
                    <div>                                    
                        <div class="widget-title">Total Products</div>
                        <div class="widget-int">{{ $pcount }}</div>
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
    @if($today_target_data)
    <div class="bootdey">
<div class="row bootstrap snippets bootdey">
@foreach($today_target_data as $data)
    <div class="col-md-3">
      <div class="box box-widget widget-user-2">
        <div class="widget-user-header bg-yellow">
          <h3 class="widget-user-username">{{$data->fname}}</h3>
          <h5 class="widget-user-desc">{{$data->emp_id}}</h5>
        </div>
        <div class="box-footer no-padding">
          <ul class="nav nav-stacked">
            <li><a href="#">Target Amount  <span class="pull-right badge bg-defult">{{$data->target_amt}}</span></a></li>
            <li><a href="#">Carry Forward <span class="pull-right badge bg-defult">{{$data->carry_forward_amt}}</span></a></li>
            <li><a href="#">Today Sales<span class="pull-right badge bg-defult">{{$data->day_sales_value}}</span></a></li>
            <li><a href="#">Total Target <span class="pull-right badge bg-defult">{{$data->target_amt+$data->carry_forward_amt}}</span></a></li>
            <?php
                $balance=0;
                $total_target=$data->target_amt+$data->carry_forward_amt;
                if($total_target > $data->day_sales_value)
                    $btn='<li><a href="#">Balance <span class="pull-right badge bg-red">'.($total_target-$data->day_sales_value).'</span></a></li>';
                else
                    $btn='<li><a href="#">Balance <span class="pull-right badge bg-green">'.($data->day_sales_value-$total_target).'</span></a></li>';
            ?>
            <?php echo $btn;?>
          </ul>
        </div>
      </div>
    </div>
    @endforeach
</div>
</div>
@endif
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
                                    <a href="{{url('admin/invoice')}}/{{$data->invoice_id}}" class="btn btn-primary" ><i class="os-icon os-icon-ui-49">View</i></a>                             
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

@include('layouts.footer')
