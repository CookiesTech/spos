<?php 
setlocale(LC_MONETARY, 'en_IN');
?>
<style>
#invoice-POS{
  box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
  padding:2mm;
  margin: 0 auto;
  width: 70mm;
  background: #FFF;

::selection {background: #f31544; color: #FFF;}
::moz-selection {background: #f31544; color: #FFF;}
}
h1{
  font-size: 1.5em;
  color: #222;
}
h2{font-size: .9em;}
h3{
  font-size: 1.2em;
  font-weight: 300;
}
p{
  font-size: .9em;
  color:black;
  line-height: 1.2em;
}
.logo h2
{
font-family: 'Lustria', serif;
font-size: 12px;
color:  black;
padding: 0px;
margin: 0px;
}
#top, #mid,#bot{ /* Targets all id with 'col-' */
  border-bottom: 1px solid #EEE;
}
#top{min-height: 20px;}
#mid{min-height: 80px;} 
#bot{ min-height: 50px;}

.info{
  margin-left: 0;
  margin-top: -16px;
}
.title{
  float: right;
}
.title p{text-align: right;} 
table{
  width: 65mm;
  border-collapse: collapse;
}
.tabletitle{
  font-size: .8em;
}
.service{border-bottom: 1px solid #EEE;}
.item{width: 10mm; text-align:left;}
.itemtext{font-size: .7em; text-align:center;}
.itemname{font-size: .7em; text-align:left;}
.itemprice{font-size: .7em;}
.product{text-align:left;}
#legalcopy{
  margin-top: 5mm;
} 
@media print {
  #printPageButton {
    display: none;
  }
}
.back
{
text-decoration:none;
font-size:18px;
background-color:black;
color:white;
right:44%;
position:absolute;
padding:5px;
}
.print
{
text-decoration:none;
font-size:18px;
background-color:black;
color:white;
left:44%;
position:absolute;
padding:3px;
}
 table tfoot
{
   border-top: 1px solid black;
}
</style>
  <div id="invoice-POS">
    <center id="top">
      <div class="logo"> 
      <h2 style="margin-top:20px;font-size:18px;">S</h2>
      <h2>SRIDEVI TRADERS</h2>
      </div>
    </center><!--End InvoiceTop-->
    <div id="mid">
      <div class="info">
        <p style="text-align:center"> 
            183 Arcot Road<br>
            Vadapalani,Chennai-600026.<br>
            GSTIN-33AJYPV3468LZ5
        </p>
        <h2 style="margin:0px;" >Invoice No: {{$payment_details->invoice_id}}</h2>
        <p>Date: <?php echo date('Y-m-d H:i:s');?></p>
      </div>
    </div><!--End Invoice Mid-->
    <div id="bot">
					<div id="table">
						<table>
							<tr class="tabletitle" style="border-bottom:1px solid black;">
								<td class="item"><h2>S.No</h2></td>
								<td class="product"><h2>Product</h2></td>
								<td class="Hours"><h2>Qty</h2></td>
								<td class="Rate"><h2>Price</h2></td>
							</tr>
                        	@foreach($products as $key=> $p)
							<tr class="service">
							    <td><p class="itemno">{{$key+1}}</p></td>
								<td><p class="itemname">{{$p->product_name}}</p></td>
								<td><p class="itemtext">{{$p->quantity}}</p></td>
								<td><p class="itemprice">Rs {{$p->price}}.00</p></td>
							</tr>
							@endforeach
							<!---<tr class="tabletitle">
								<td></td>
								<td></td>
								<td class="Rate"><h2>Paid Amt</h2></td>
								<td class="payment"><h2>Rs {{$payment_details->payable_amount}}.00</h2></td>
							</tr>--->
							<tr class="tabletitle">
								<td></td>
								<td></td>
								<td class="Rate"><h2>Total</h2></td>
								<td class="payment"><h2>Rs {{$payment_details->total_amount}}.00</h2></td>
							</tr>
							<!---<tr class="tabletitle">
								<td></td>
								<td></td>
								<td class="Rate"><h2>Balance</h2></td>
								<td class="payment"><h2>Rs {{$payment_details->balance}}.00</h2></td>
							</tr>---->
						</table>
						<!---<table class="tabletitle">
						<tr>
						<th>#</th>
						<th>Amount</th>
						<th>CGST</th>
						<th>SGST</th>
						<th>ISGT</th>
						<th>Total</th>
						</tr>
						<tbody>
						<?php $total_net_amount=0; $total_price=0; $total2=0; $one_tax_total=0;$total_tax=0;$total_net_amount=0;?>
						@foreach($tax_data as $t)
						@if($in_tamilnadu->in_tamilnadu=='no')
						<tr>
						<td>{{$t->igst}}</td>
						<td><?php $net_amount1=$t->total_amt*(100/(100+$t->total_igst));$net_amount= number_format($net_amount1, 2, '.', ''); echo rupee_format('%!i',$net_amount);
						  $total_net_amount=$total_net_amount+$net_amount;
						  $total_price=$total_price+$t->total_amt;
						?></td>
						<td>0.00</td>
						<td>0.00</td>
						<td>{{rupee_format('%!i',$t->total_amt-$net_amount)}}</td>
						<td>{{rupee_format('%!i',$t->total_amt)}}</td>
						</tr>
						@else
						<?php $net_amount1=$t->total_amt*(100/(100+$t->total_cgst));$net_amount= number_format($net_amount1, 2, '.', ''); $one_tax=$t->total_amt-$net_amount; 
						$total_price=$total_price+$t->total_amt; 
						$total_net_amount=$total_net_amount+$t->total_amt-($one_tax+$one_tax); 
						$total_tax=$t->total_amt-($one_tax+$one_tax); 
					    $one_tax_total=$one_tax_total+$one_tax;?>
						<tr>
						<td>{{$t->cgst}}</td>
						<td>
						<?php echo rupee_format('%!i',$t->total_amt-($one_tax+$one_tax)); ?>
						 </td>
						<td><?php echo rupee_format('%!i',$one_tax);?></td> 
						<td><?php echo rupee_format('%!i',$one_tax);?></td> 
						</td>
						<td>0.00</td>
						<td>{{rupee_format('%!i',$t->total_amt)}}</td>
						</tr>
						@endif
						@endforeach
						@if($in_tamilnadu->in_tamilnadu=='no')
						<tfoot>
						<tr>
						<td></td>
						<td><?php  echo rupee_format('%!i',$total_net_amount);?></td>
						<td>0.00</td>
						<td>0.00</td>
						<td>{{rupee_format('%!i',$total_price-$total_net_amount)}}</td>
						<td>{{rupee_format('%!i',$total_price)}}</td>
						</tr>
					  </tfoot>
					  @else
					   <tfoot>
						<tr>
						<td></td>
						<td><?php  echo rupee_format('%!i',$total_net_amount);?></td>
						<td>{{rupee_format('%!i',$one_tax_total)}}</td>
						<td>{{rupee_format('%!i',$one_tax_total)}}</td>
						<td>0.00</td>
						<td>{{rupee_format('%!i',$total_price)}}</td>
						</tr>
					  </tfoot>
					  @endif
						</tbody>
						</table>--->
					</div><!--End Table-->
					<div id="legalcopy">
					     <p style="text-align:center">Inclusive Of GST<br>No Exchange No Return</p>
						<p class="legal"  style="text-align:center"><strong>Thank you for your business..... Visit Again!</strong> </p>
					     <p>-----------------------------------------------------</p>
					</div>
				</div><!--End InvoiceBot-->
  </div><!--End Invoice-->
  				<div id="printPageButton">
					  <button  class="print" onClick="window.print();">Print</button>
                      <a  class="back"  href="{{url('staff/staff_pos')}}" >Back</a>
                </div>
<script>
window.print();
</script>