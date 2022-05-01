<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<title>View-Invoice</title>
<style>
    #invoice{
        padding: 30px;
        padding: 30px;
        width: 80%;
        float: right;
        margin-right: 144px;
    }

    .invoice {
        position: relative;
        background-color: #FFF;
        min-height: 680px;
        padding: 15px
    }

    .invoice header {
        padding: 10px 0;
        margin-bottom: 20px;
        border-bottom: 1px solid #3989c6
    }

    .invoice .company-details {
        text-align: right
    }

    .invoice .company-details .name {
        margin-top: 0;
        margin-bottom: 0
    }

    .invoice .contacts {
        margin-bottom: 20px
    }

    .invoice .invoice-to {
        text-align: left
    }

    .invoice .invoice-to .to {
        margin-top: 0;
        margin-bottom: 0
    }

    .invoice .invoice-details {
        text-align: right
    }

    .invoice .invoice-details .invoice-id {
        margin-top: 0;
        color: #3989c6
    }

    .invoice main {
        padding-bottom: 50px
    }

    .invoice main .thanks {
        margin-top: -100px;
        font-size: 2em;
        margin-bottom: 50px
    }

    .invoice main .notices {
        padding-left: 6px;
        border-left: 6px solid #3989c6
    }

    .invoice main .notices .notice {
        font-size: 1.2em
    }

    .invoice table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 20px
    }

    .invoice table td,.invoice table th {
        padding: 15px;
        background: #eee;
        border-bottom: 1px solid #fff
    }

    .invoice table th {
        white-space: nowrap;
        font-weight: 400;
        font-size: 16px
    }

    .invoice table td h3 {
        margin: 0;
        font-weight: 400;
        color: #3989c6;
        font-size: 1.2em
    }

    .invoice table .qty,.invoice table .total,.invoice table .unit {
        text-align: right;
        font-size: 1.2em
    }

    .invoice table .no {
        color: #fff;
        font-size: 1.6em;
        background: #3989c6
    }

    .invoice table .unit {
        background: #ddd
    }

    .invoice table .total {
        background: #3989c6;
        color: #fff
    }

    .invoice table tbody tr:last-child td {
        border: none
    }

    .invoice table tfoot td {
        background: 0 0;
        border-bottom: none;
        white-space: nowrap;
        text-align: right;
        padding: 10px 20px;
        font-size: 1.2em;
        border-top: 1px solid #aaa
    }

    .invoice table tfoot tr:first-child td {
        border-top: none
    }

    .invoice table tfoot tr:last-child td {
        color: #3989c6;
        font-size: 1.4em;
        border-top: 1px solid #3989c6
    }

    .invoice table tfoot tr td:first-child {
        border: none
    }

    .invoice footer {
        width: 100%;
        text-align: center;
        color: #777;
        border-top: 1px solid #aaa;
        padding: 8px 0
    }

    @media print {
        .invoice {
            font-size: 11px!important;
            overflow: hidden!important
        }

        .invoice footer {
            position: absolute;
            bottom: 10px;
            page-break-after: always
        }

        .invoice>div:last-child {
            page-break-before: always
        }
    }
</style>

<!--Author      : @arboshiki-->
<div id="invoice">

    <!--<div class="toolbar hidden-print">
        <div class="text-right">
            <button id="printInvoice" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
        </div>
        <hr>
    </div>-->
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header>
                <div class="row">

                    <div class="col company-details">
                        <h2 class="name">
                            <a target="_blank" href="s">
                                <img src="http://localhost/spos/public/assets/img/logo.png" />
                            </a>
                        </h2><b>
                        <div>No 12, 43rd street, 6th Avenue, Ashok nagar, Chennai-600083</div>
                        <div>98408 78383 | 90031 90230</div>
                        <div>enquiry@sjewelry.in</div></b>
                    </div>
                </div>
            </header>
            <main>
                <div class="row contacts">
                    <div class="col invoice-to">
                        <div class="text-gray-light">INVOICE TO:<b>{{ $data[0]->customer_name }}</b></div>
                        <div class="address">PHone : {{ $data[0]->phone }}</div>
                        <div class="email"> Payment Mode : <span class="badge badge-pill badge-info">{{ ucfirst($data[0]->payment_mode) }}<span></div>
                    </div>
                    <div class="col invoice-details">
                        <h1 class="invoice-id">BILL NO:{{ $data[0]->invoice_id }}</h1>
                        <div class="date">Date of Invoice: {{ date('d/m/Y H:i',strtotime($data[0]->created_at)) }}</div>
                    </div>
                </div>
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <td class="text-center">S.No</td>
                             <td class="text-center ">SKU</td>
                            <th class="text-center">Product Name</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Exchange Qty</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $sub_total = 0;
                        ?>
                        @foreach($datas as $s)
                        <?php
                        $sub_total = $sub_total + $s->amount;
                        
                        ?>
                        <tr>
                            <td class="unit">{{ $i }}</td>
                              <td class="no">{{ $s->sku }}</td>
                            <td class="text-center">
                                {{ $s->product_name }}
                            </td>
                            <td class="unit">{{ $s->price }}</td>
                            <td class="qty">{{ $s->quantity }}</td>
                            <td class="qty">{{ $s->exchange_qty }}</td>
                            <td class="total">{{ $s->amount }}</td>
                            @if($s->exchange_qty==$s->quantity)
                            <td><button type="button" class="btn btn-danger"  disable>Exchanged</button></td>
                            @else
                            <td><button type="button" class="btn btn-primary exchange" data-invoice_id="{{ $s->invoice_id }}"  data-quantity="{{ $s->quantity-$s->exchange_qty }}" data-sku="{{$s->sku}}" data-id="{{$s->id}}" >Exchange</button></td>
                            @endif
                        </tr>
                        <?php $i++; ?>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <td colspan="3">SUBTOTAL</td>
                            <td>Rs. <?php echo $sub_total; ?></td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td colspan="3">Inclusive of GST</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td colspan="3">GRAND TOTAL</td>
                            <td>Rs. <?php echo  $sub_total; ?></td>
                        </tr>
                    </tfoot>
                </table>
                <hr>
                <h1>Exchange Details</h1>
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <td class="text-center">S.No</td>
                            <td class="text-center">SKU</td>
                            <th class="text-center">Exchange Date</th>
                            <th class="text-center">Exchange Type</th>
                            <th class="text-center">Exchange Process By</th>
                            <th class="text-center">Exchange Qty</th>
                            <th class="text-center">Commends</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @foreach($sales_exchange_data as $s)
                        <tr>
                            <td class="no">{{ $i }}</td>
                              <td class="unit">{{ $s->sku }}</td>
                            <td class="text-center">
                            {{ date('d/m/Y H:i',strtotime($s->exchange_date)) }}
                            </td>
                            <td class="unit">{{ $s->exchange_type }}</td>
                            <td class="qty">{{ $s->exchange_process_by }}</td>
                            <td class="qty">{{ $s->exchange_qty }}</td>
                            <td class="total">{{ $s->commends }}</td>
                        </tr>
                        <?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>
            </main>
            <p align="center"><strong>Thank you for your business!</strong>  
            </p>
        </div>
        <div>
        </div>
    </div>
</div>
<!--Exchange Model Popup-->
<div aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade" id="exampleModal1" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Exchange Process </h5> <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{url('staff/product_exchange')}}"  id="exchange_form" autocomplete="off" > 
                {{ csrf_field() }}
                    <div class="row">
                        <input type="hidden" name="sku" id="sku" required>
                        <input type="hidden" name="id" id="id" required>
                        <input type="hidden" name="invoice_id" id="invoice_id" required>
                        <div class="col-sm-6">
                            <div class="form-group">
                                 <label for="">Processed By:</label>
                                  <select name="exchange_process_by" required class="form-control">
                                     <option value="">Select Emp ID</option>
                                     @foreach($branch_employees as $employee)
                                     <option value="{{$employee->emp_id}}">{{$employee->name}}({{$employee->emp_id}})</option>
                                     @endforeach
                                 </select> 
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group"> <label for="">Exchange Type:</label>
                            <select class="form-control" name="exchange_type" required>
                                <option value="">[Select]</option>
                                <option value="cash">Cash</option>
                                <option vlaue="product" selected> Product</option>
                            </select>
                             </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group"> 
                            <label for="">Quantity</label> <span class="saled_qty badge badge-pill badge-danger">0</span>
                            <input type="number" class="form-control border"  id="exchange_qunatity" name="exchange_qunatity"   required></input> </div>
                            
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group"> 
                            <label for="">Commends:</label>
                            <textarea class="form-control"  name="commends" required></textarea> </div>
                        </div>
                    </div>
                      <br>
                    <div class="modal-footer">
                         <button class="btn btn-secondary" data-dismiss="modal" type="button"> Close</button>
                         <button class="btn btn-primary" type="submit"> Save</button> </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script>
$( ".exchange" ).click(function() {
    $('#exchange_form').trigger("reset");
    $('.saled_qty').text($(this).data('quantity'));
    $('#invoice_id').val($(this).data("invoice_id"));
    $('#sku').val($(this).data("sku"));
    $('#id').val($(this).data("id"));
    $('#exampleModal1').modal('show');
});
//Saled Qty > Exchange Qty check
$("form#exchange_form").submit(function(e) {
    var exchange_qty=parseInt($('#exchange_qunatity').val());
    var saled_qty=$('.saled_qty').text();
    if(exchange_qty >saled_qty ||  exchange_qty==0)
    {
        $('#exchange_qunatity').addClass('border-danger');
        return false;
    }
    else
        $('#exchange_qunatity').removeClass('border-danger');
 })
</script>