<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
                            <td class="item text-center">S.No</td>
                            <td class="item text-center">SKU</td>
                            <th class="text-center">Product Name</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Exchange Qty</th>
                            <th class="text-center">Total</th>
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
                            <td class="text-left">
                                {{ $s->product_name }}
                            </td>
                            <td class="unit">{{ $s->price }}</td>
                            <td class="qty">{{ $s->quantity }}</td>
                            <td class="qty">{{ $s->exchange_qty }}</td>
                            <td class="total">{{ $s->amount }}</td>
                        </tr>
                        <?php $i++; ?>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="3">SUBTOTAL</td>
                            <td>Rs. <?php echo $sub_total; ?></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="3">Inclusive of GST</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
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
