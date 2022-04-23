@include('layouts.links')
@include('layouts.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<ul class="breadcrumb">
    <li><a href="home">Home</a></li>
    <li><a href="sales">Branch Sale Report</a></li>
</ul>
<div class="page-title">                    
    <h2><span class="fa fa-arrow-circle-o-left"></span> Branch Report</h2>
</div>
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <form action="{{url('admin/branch_bill_status')}}">
                <div class="col-sm-3">
                    From Date
                    <div class="form-group">
                        <input class="form-control"  name="from_date"  type="date" required >
                    </div>
                </div>
                 <div class="col-sm-3">
                     To Date
                    <div class="form-group">
                        <input class="form-control"  name="to_date"  type="date" required >
                    </div>
                </div>
                <div class="col-sm-3">
                       <button class="btn btn-primary" type="submit"> Search</button>
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
                            <?php $i = 1; ?>
                            @foreach($data as $d)
                            <tr>
                                <td>{{$i}}</td>
                                <td>
                                    {{ $d['name'] }}
                                </td>
                                <td>
                                    Rs{{rupee_format('%!i',$d['pay_amt'])}}
                                </td>
                                 <td>
                                    Rs{{rupee_format('%!i',$d['bl_amt'])}}
                                </td>
                                 <td>
                                    Rs{{rupee_format('%!i',$d['tol_amt'])}}
                                </td>
                                <td>
                                    {{ $d['bill_count'] }}
                                </td>
                                <td>
                                    @foreach($d['source'] as $bill_sources)
                                    <p class="money">{{$bill_sources['payment_mode']}}: Rs{{rupee_format('%!i',$bill_sources['p_total'])}}</p>
                                    @endforeach
                                </td>
                                <td>
                                   {{ date('d/m/Y',strtotime($d['created_at'])) }}
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
@include('layouts.footer')
