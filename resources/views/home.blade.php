@include('layouts.links')
@include('layouts.header')
<style>
    .money
    {
        text-align: center;
        font-size: 12px;
        font-weight: bold;
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
