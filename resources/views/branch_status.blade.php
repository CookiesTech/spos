@include('layouts.links')
@include('layouts.header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<ul class="breadcrumb">
    <li><a href="home">Home</a></li>
    <li><a href="sales">Branch Sale Report</a></li>
</ul>
<div class="page-title">                    
    <h2><span class="fa fa-arrow-circle-o-left"></span> Branch Report ({{ date("j F", strtotime($filter['from_date'])).' - '.date("j F", strtotime($filter['to_date']))}} )</h2>
</div>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
        <div class="panel panel-default">
           <div class = "panel-heading">
                Branch Sales  Report
           </div>  
           <form action="{{url('admin/branch_bill_status')}}">
               <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for=""> Select Date Range:</label>
                               <div class="input-group input-large"  data-date-format="yyyy-mm-dd" >
                                <input type="date" class="form-control" name="from_date" value="{{$filter['from_date']}}" >
                                <span class="input-group-addon">
                                    to </span>
                                <input type="date" class="form-control" name="to_date"  value="{{$filter['to_date']}}"  >
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">               
                        <label for="">Month Wise:</label>
                       <input type="text" name="month_filter" class="form-control" id="datepicker"> 
                        </div>
                   </div>
                    <div class="col-sm-3">
                            <div class="form-group">               
                            <label for="">Branch :</label>
                            <select name="branch_id"  class="form-control"  id="s_branch_id">
                                <option value="all">All</option>
                                @foreach($branches as $branch)
                                <option @if($branch->branch_id==$filter['branch_id']) {{"selected"}} @endif value="{{$branch->branch_id}}">{{$branch->name}} ({{$branch->branch_id}})</option>
                                @endforeach
                            </select>         
                     </div>
                  <button class="btn btn-primary search_filter" type="submit" style='margin-top: 10px;float: right;margin-right: 10px;'>Submit</button>    
               </div>
            </div>
            </div>
        </form>
          
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
                                    Branch Name
                                </th>
                                <th>
                                    Cash Received
                                </th>
                                <th>
                                    Balance
                                </th>
                                <th>
                                    Total Amount
                                </th>
                                <th>
                                    Bill Count
                                </th>
                                 <th>
                                    Bill Source
                                </th>
                                 <th>
                                    Date
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; $total_cash_recevied=0; $total_bal=0; $total_amt=0;$total_bill=0; $gpay=0;$card=0;$cash=0;?>
                            @foreach($data as $d)
                            @php 
                              $total_cash_recevied=$total_cash_recevied+$d['pay_amt'];
                              $total_bal=$total_bal+$d['bl_amt'];
                              $total_amt=$total_amt+$d['tol_amt'];
                              $total_bill=$total_bill+$d['bill_count'];
                            @endphp
                            <tr>
                                <td>{{$i}}</td>
                                <td>
                                    {{ $d['name'] }}
                                </td>
                                <td>
                                    Rs. {{rupee_format('%!i',$d['pay_amt'])}}
                                </td>
                                 <td>
                                    Rs. {{rupee_format('%!i',$d['bl_amt'])}}
                                </td>
                                 <td>
                                    Rs. {{rupee_format('%!i',$d['tol_amt'])}}
                                </td>
                                <td>
                                    {{ $d['bill_count'] }}
                                </td>
                                <td>
                                    <?php foreach($d['source'] as $bill_sources) { 
                                        if($bill_sources['payment_mode']=='Card')
                                            $card=$card+$bill_sources['p_total'];
                                        if($bill_sources['payment_mode']=='Cash')
                                            $cash=$cash+$bill_sources['p_total'];
                                        if($bill_sources['payment_mode']=='Gpay')
                                            $gpay=$gpay+$bill_sources['p_total'];
                                      ?>
                                     <p class="money">{{$bill_sources['payment_mode']}}: Rs. {{rupee_format('%!i',$bill_sources['p_total'])}}</p>
                                    <?php } ?>
                                </td>
                                <td>
                                   {{ date('d/m/Y',strtotime($d['created_at'])) }}
                                </td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                                <th colspan="2">
                                </th>
                                <th>
                                Rs. {{rupee_format('%!i',$total_cash_recevied)}}
                                </th>
                                <th>
                                Rs. {{rupee_format('%!i',$total_bal)}}
                                </th>
                                <th>
                                Rs. {{rupee_format('%!i',$total_amt)}}
                                </th>
                                <th>
                                   {{$total_bill}}
                                </th>
                                <th>
                                <p class="money">Card: Rs. {{rupee_format('%!i',$card)}}</p>
                                <p class="money">Cash: Rs. {{rupee_format('%!i',$cash)}}</p>
                                <p class="money">Gpay: Rs. {{rupee_format('%!i',$gpay)}}</p>
                               </th>
                                <th>
                                </th>
                            </tr>
                        </tfoot>
                    </table>                                    
                </div>
            </div>
        </div>
    </div>
</div>  
@include('layouts.footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" ></script>
<script>
    $("#datepicker").datepicker( {
    format: "mm-yyyy",
    startView: "months", 
    minViewMode: "months"
});
</script>