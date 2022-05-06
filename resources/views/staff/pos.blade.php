@include('staff/layouts.links')
<style>            
#billing {
  position:absolute;
  display: block;
  width: 100%;
  height:100%;
  }
  #bill {
    position: absolute;
    top: 50px;
    left: 0px;
    bottom:0px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    width: 70%;
    padding: 20px;
    margin: auto;
    box-sizing: border-box;
    background-color:white;
  }
  #cart #quantity {
    width:100px;
    height:40px;
    text-align:center;
  }
  .productname {
    width:100%;
    padding-top:22px;
  }
  #customername{
    width:100%;
    height:35px;
  }
  .total {
    position: absolute;
    right: 20px;
    padding-top: 20px;
  }
  #cart {
    border:1px solid #ddd            
	}
  #cart td {
    text-align:center;
    box-sizing: border-box;
  }
  #cart th {
    text-align:center;
    color:#6495ed;
    height:50px;
  }
  #cart  td:nth-of-type(1){
    text-align:left;
  }
  #billcart  td:nth-of-type(6),#billcart  td:nth-of-type(3), #billcart  th:nth-of-type(6), #billcart  th:nth-of-type(3){
    display: none;
  }
  #billcart  th:nth-of-type(2){
    text-align:left;
    width:150px;
  }
  #billcart  td:nth-of-type(2){
    word-break: break-word;
  }
  #billcart  td:nth-of-type(1){
    text-align: left;
    padding-left: 10px;
  }
  #billcart  td:nth-of-type(4){
    text-align:center;
  }
  #billcart  td:nth-of-type(5){
    text-align:right;
    padding-right: 10px;
  }
  #billcart  th:nth-of-type(5){
    text-align:right;
    padding-right: 5px;
  }
  #productselect {
    position:absolute;
    top:50px;
    right:0px;
    bottom:0px;
    ;
    background-color: white;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    width:30%;
    padding:20px;
    padding-bottom:0px;
    margin: auto;
    overflow: auto;
    box-sizing: border-box;
    margin-bottom:0;
  }
  .card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    margin: auto;
    text-align: center;
    font-family: arial;
    height: 80px;
    margin-bottom: 18px;
    cursor: pointer;
    width:142px;
  }
  hr{
    margin-top: 35px;
    margin-bottom: 20px;
  }
  img{
    height: 120px;
  }
  #price {
    color: grey;
  }
  #cart {
    margin: auto;
    margin-top:25px;
  }
  #cart tr {
    border-top:1px solid #ddd;
  }
  #billcart  {
    width:100%;
    overflow:hidden;
    position: relative;
  }
  #billcart th {
    padding:0px;
    margin:0px;
    text-align:center;
    width:50px;
    overflow:hidden;
    font-size:15px;
    padding-right:5px;
  }
  #billcart thead {
    border:1px dashed black;
    border-left:0;
    border-right:0;
  }
  #billcart td {
    padding:0px;
    font-size:12px;
  }
  #billcart  #quantity {
    border:0px;
    width:50px;
    text-align:center;
  }
  #categoryform{
    position:fixed;
    top:10px;
    left:53%;
  }
  #productcategory, #productsearch {
    font-size: 18px;
    color: cornflowerblue;
    position: relative;
    top: 20px;
    left: 0px;
    height: 35px;
    border: 1px solid cornflowerblue;
    width: 235px;
  }
  .searchbutton {
    font-size: 18px;
    color: cornflowerblue;
    position: relative;
    top: -15px;
    left: 467px;
    height: 35px;
    border: 1px solid cornflowerblue;
    width: 42px;
    background-color: white;
  }
  .listedproducts {
    position: absolute;
    left: 0;
    top: 85px;
    height: 500px;
    overflow-y: auto;
  }
  .bg-gray {
    color: #000;
    background-color: #d2d6de !important;
  }
  .panel-body {
    padding: 15px;
  }
  .panel-default {
    border-color: #ddd;
  }
  .panel {
    margin-bottom: 20px;
    margin-top:-20px;
    background-color: #fff;
    border: 1px solid transparent;
    border-radius: 4px;
    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
    box-shadow: 0 1px 1px rgba(0,0,0,.05);
  }
  .sno,.pname{
    display:inline            }
  .modal-dialog {
    width:300px;
    margin: 0 auto;
  }
  #myModal{
    background-color:white;
    display:none;
    position:fixed;
    top:0px;
    font-family: arial;
    font-weight:bold;
  }
  .moal-dialog {
    margin:0px auto;
  }
  .modal-body{
    padding: 0px;
    color:black;
  }
  .modal-footer{
    height:100px;
    text-align:center;
    background:white;
    border:0px;
  }
  .modal-header{
    text-align: center;
    font-weight: 600;
    background:white;
    line-height: 20px;
    padding-bottom:0px;
    border:0px;
  }
  .modal-header p{
    padding:0px;
    margin-bottom: 0;
  }
  .modal-header h3{
    color:black;
    font-family: arial;
    font-size:16px;
    padding-top:10px;
  }
  .modal-content {
    color:black;
  }
  #date {
    float:left;
    text-align:left;
  }
  #time {
    text-align:right;
  }
  .alignleft {
    float:left;
    text-align:left;
    padding-left:10px;
  }
  .alignamt {
    text-align:right;
    padding-right:10px;
  }
  .cashwrap{
    font-size:14px;
    border:1px dashed black;
    border-left:0;
    border-right:0;
    border-bottom:0;
    padding-top: 6px;
    margin-bottom: -5px;
  }
  .billtotalitem{
    position:relative;
    float:left;
    padding-left:0px;
    padding-right:0px;
    width:33.3%;
  }
  #billquantity{
    padding-left: 96px;
  }
  .input-group-addon{
    border-color: #d2d6de;
    color: cornflowerblue;
    background-color: white;
    vertical-align: middle;
  }
   #keypad{
          position: absolute;
          background-color: lightblue;
          width: 21vw;
          height: 33vh;
          border-color: grey;
          border-width: 1px;
          border-style: solid;
          border-radius: 2%;
     }
    .keypads
    {
         display: inline;
        width: 28%;
        height: 19%;
        margin-top: 3%;
        margin-left: 3%;
         border-color: grey;
         border-width: 1px;
         border-style: solid;
         border-radius: 2%;
   }
   .payment_mode{
       font-size:20px !important;
   }
</style>
@include('staff/layouts.header')

<title>Staff-Billing</title>
<!-- PAGE CONTENT WRAPPER -->                 
 @section('content') 
       
<div id="billing">
     
 <form id="create_invoice" name="create_invoice" autocomplete="off" action="{{url('staff/create_invoice_staff')}}" method="post">                                        
  <div id ="bill">	    
  <input type="hidden" name="customer_name" id="customer_name" value="">
    {{csrf_field()}}                                                      
      <div class="row" style="height:510px; overflow:auto;padding-top:10px;"> 
      <div class="col-lg-4 col-sm-4 col-xs-4 col-md-4 ">                                    
          <div class=""> 
          <label>Barcode:</label>
             <input type="text" class="form-control" name="documentID"  onmouseover="this.focus();" id="barcode_data" placeholder="Enter Sku " 
             onclick="showKeypad(0, 0, this.id)" />                                   
          </div>                                
        </div>
        <div class="col-lg-4 col-sm-4 col-xs-4 col-md-4 ">                                    
          <div class="">  
               <label>Billed By:</label>
               <select name="emp_id" id="emp_id" class="form-control" style="width:100%" required>														
                      <option value="">Select
                      </option>	
                      @foreach($branch_employees as $emp)
                      <option value="{{ $emp->emp_id }}" empname="{{ $emp->name }}" class="payment_mode">{{ $emp->name }}-{{ $emp->emp_id }}<br>
                      </option>	
                      @endforeach
                    </select>		
                                                  
                  
          </div>                                
        </div>
       <div class="col-lg-4 col-sm-4 col-xs-4 col-md-4 ">  
         <div class=""> 
         <label>Customer Ph:</label>
            <input type="text" name="phone"  id="phone" value="" class="form-control"  onclick="showKeypad(0, 0, this.id)" placeholder="Enter Phone Number">                                  
          </div>
        </div>
        <table id="cart"  class="table-responsive table-striped table-condensed">                                    
          <thead>                                        
            <tr>                                            
              <th class="col-lg-1 col-md-1">S.No
              </th>
              <th class="col-lg-3 col-md-3">SKU
              </th> 
              <th class="col-lg-3 col-md-3">PRODUCT
              </th>                                            
              <th class="col-lg-2 col-md-2">PRICE
              </th>                                            
              <th class="col-lg-2 col-md-2">QUANTITY
              </th>                                            
              <th class="col-lg-2 col-md-2">AMOUNT
              </th>                                            
              <th class="col-lg-2 col-md-2">REMOVE
              </th>                                        
            </tr>                                    
          </thead>                                    
          <tbody>
          </tbody>                                    
      </table>                            
  </div>                                                                        
</div>                    
<div class="row" id ="productselect">                        
<!--<h4>Payment Details</h4>-->
  <div class="panel panel-default">                                
    <div class="panel-body bg-gray disabled" style="margin-bottom: 0px !important">                                    
      <table class="table table-condensed" style="margin-bottom: 0px !important;margin-top:0px;">                                        
        <tbody>                                            
          <tr>                                                
            <td style="border:0px;">                                                    
              <div class="row">                                                        
                <div class="col-md-12">                                                                                                           
                    <b>Payable Amount:</b>                                                        
                    <input type='hidden' name='total' id='totalprice' style="width:100%"> 
				
                    <span id="subtotal" style="font-size:27px" class="text-bold">0</span>
					</div>
					</div> 
					<div class="row">                                                        
                <div class="col-md-12">                                                                                                           
                    <b>Received Amount:</b>                                                        
                     <input type='text' style="width:100%"  name='amountreceived' id='amountreceived' required onclick="showKeypad(0, 0, this.id)" onchange="balancecal()">
					</div>
					</div> 
                  <div class="row"> 					                                                   
                  <div class="col-md-12">                                                        
                    <b>Balance:</b>                                                        
                    <input type ='text' style="width:100%" name='balance' onclick="showKeypad(0, 0, this.id)" id='balance'>                                                    
                  </div> 
                   </div>				  
                  <div class="row"> 					                                                   
                  <div class="col-md-12">                                                    
                    <label>Mode:</label> 														
                    <select name="mode" class="btn btn-info" style="width:100%" id="pay_mode" required onchange="balancecal()">														
                      <option value="">Select
                      </option>														
                      <option value="Cash" class="payment_mode">Cash
                      </option>														
                      <option value="Card" class="payment_mode">Card
                      </option> 														
                      <option value="Gpay" class="payment_mode">Gpay
                      </option>														
                    </select>														
                  </div> 
                   </div>
                 <div class="row">				   
                  <div class="col-md-6 ">                                                        
                    <b>Qty:</b>                                                        
                    <input type ='text' style="width:100%"  readonly name='totalquantity' id='totalquantity' >                                                    
                  </div>  
                  <br>                                                  
                  <div class="col-md-6">                                                    
                    <label>Confirm:
                    </label>														
                    <button  type="submit" class="but btn-success submit">Submit
                    </button>                                                    
                  </div>                                                    
                </div>                                                                                                     
            </td>                                            
          </tr>                                        
        </tbody>                                    
      </table>                                
    </div> 
</div> 
  <div class="row">                                
        <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 ">   
    <div id="keypad">
        <input type="button" class="keypads" value="1" onclick="SendInputs('1')">
        <input type="button" class="keypads" value="2" onclick="SendInputs('2')">
        <input type="button" class="keypads" value="3" onclick="SendInputs('3')"><br>
        <input type="button" class="keypads" value="4" onclick="SendInputs('4')">
        <input type="button" class="keypads" value="5" onclick="SendInputs('5')">
        <input type="button" class="keypads" value="6" onclick="SendInputs('6')"><br>
        <input type="button" class="keypads" value="7" onclick="SendInputs('7')">
        <input type="button" class="keypads" value="8" onclick="SendInputs('8')">
        <input type="button" class="keypads" value="9" onclick="SendInputs('9')"><br>
        <input type="button" class="keypads" value="CE" style="color:red;" onclick="SendInputs('CE')">
        <input type="button" class="keypads" value="0" onclick="SendInputs('0')">
        <input type="button" class="keypads" value="X" style="color:red;" onclick="hideKeyPad()">
    </div>
  </div>
  </div>
  </div>
  </form> 
</div> 
</div>
</div>
<!-- START PLUGINS -->    
<script type="text/javascript" src="{{ asset('public/assets/js/plugins/jquery/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/plugins/jquery/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/plugins/bootstrap/bootstrap.min.js')}}"></script> <!-- END PLUGINS -->
<!-- START THIS PAGE PLUGINS-->
<script type='text/javascript' src="{{ asset('public/assets/js/plugins/icheck/icheck.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/plugins/scrolltotop/scrolltopcontrol.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/plugins/bootstrap/bootstrap-select.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/plugins/bootstrap/bootstrap-file-input.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/plugins/moment.min.js')}}"></script> <!-- END THIS PAGE PLUGINS-->
<script type="text/javascript" src="{{ asset('public/assets/js/demo_tables.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/plugins.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/actions.js')}}"></script>
<script type="text/javascript" src="{{ asset('public/assets/js/demo_dashboard.js')}}"></script> <!-- END TEMPLATE -->
<!-- END SCRIPTS -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
<script> 
    window.onload = function() {
       var input = document.getElementById("barcode_data").focus();
       }
window.setTimeout(function() {
    $("#message").fadeTo(500, 0).slideUp(500, function() {
        $(this).remove();
    });
}, 4000); 


    $(document).on('change', '#emp_id', function(e) {
       var customer_name = $('option:selected', this).attr('empname');

        $('#customer_name').val(customer_name); 
    }); 
 
</script>    	  
<script> 
   $(document).on('change', '#barcode_data', function(e) {
    var token = "{{ Session::token() }}";
    var html = '';
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: "{{URL::to('staff/getProductsBySku')}}",
        data: "_token=" + token + "&sku=" + $('#barcode_data').val(),
        success: function(data) {
            if (data.length != 0) {
                $('#barcode_data').val('').focus();
                $.each(data, function(key, value) {
                    cart1(value.id, value.product_name, value.discount_price, value.sku);
                });
            } 
            else 
            {
                
            }
        }
    });
});
/* add row to table*/
function cart1(id, a, b, sku) {
    var table = document.getElementById("cart").getElementsByTagName('tbody')[0];
    var row = table.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    var cell6 = row.insertCell(5);
    var cell7 = row.insertCell(6);
    var q = 1;
    var cp1 = q * b;
    cell1.innerHTML = "<div class='sno'>0</div>"
    cell2.innerHTML = "<div style='width:100%'><div class='sku'>" + sku + "</div></div>";
    cell3.innerHTML = "<input type='hidden' name='productnames[]' id='itemname' class='itemname'><input type='hidden' name='sku[]' id='sku' class='sku' value='" + sku + "'><input type='hidden' name='id[]' id='id' class='id' value='" + id + "'><div style='width:100%'><div class='pname'>" + a + "</div></div>";
    cell4.innerHTML = "<input type='hidden' name='productprice[]' id='itemprice' class='itemprice' ><p id ='productprice' class='productprice '>" + b + "</p>";
    cell5.innerHTML = "<div  id='quantityselect' > <input type='text' value='1' id='quantity"+sku+"'  onclick='showKeypad(0, 0, this.id)' class='proquantity' name='quantity[]'/ ></div>";
    cell6.innerHTML = "<input type='hidden' name='costprice[]'value='" + cp1 + "' id='costprice' class='procost'><p id ='cart-price' class='proprice '>" + cp1 + "</p>";
    cell7.innerHTML = " <input type='button' class='btn btn-warning ' value='Delete' />";
    getTotal();
	//$('#cart tbody tr:last #quantity').focus();
    removeDuplicateRows($('table'));
}
/* quantity on change*/
$(document).on('change', '.proquantity', function(e) {
    var index = $(this).closest('td').parent()[0].sectionRowIndex;
    var q = $(this).closest('tr').find('.proquantity').val();
    var b = $(this).closest('tr').find('.productprice').text();
    var cp1 = q * b;
    $(this).closest('tr').find('.proprice').text(cp1);
    var rowCount = $('#cart tr').length;
    for (var i = 1; i <= rowCount; i++) {
        var q = $('#cart tr:nth-child(' + i + ') .proprice').text();
        $('#cart tr:nth-child(' + i + ') .procost').val(q)
    }
    getTotal();
});
/*get total of price*/
function getTotal() {
    var rowCount = $('#cart tr').length;
    for (var i = 1; i <= rowCount; i++) {
        var q = $('#cart tr:nth-child(' + i + ') .proprice').text();
        $('#cart tr:nth-child(' + i + ') .procost').val(q)
    }
    for (var i = 1; i <= rowCount; i++) {
        var q = $('#cart tr:nth-child(' + i + ') .pname').text();
        $('#cart tr:nth-child(' + i + ') .itemname').val(q)
    }
    for (var i = 1; i <= rowCount; i++) {
        var q = $('#cart tr:nth-child(' + i + ') .productprice').text();
        $('#cart tr:nth-child(' + i + ') .itemprice').val(q)
    }
    var total = 0;
    $("#cart .proprice").each(function() {
        total += parseInt($(this).text());
    });
    document.getElementById("subtotal").innerHTML = total;
    serialcall();
    totalquantity();
}
/*delete row*/
$('#cart').on('click', 'input[type="button"]', function() {
    $(this).closest('tr').remove();
    getTotal();
});
/* balance amount*/
function balancecal() {
    var mode=$('#pay_mode').val();
    if(mode=='Cash'){
        var rec = $('#amountreceived').val();
        var amt = $('#subtotal').text();
        var bal = rec - amt;
        $('#balance').val(bal);
        document.getElementById("balance").readOnly = true;
    }
   else{
       var amt = $('#subtotal').text();
        var rec = $('#amountreceived').val(amt);
       $('#balance').val(0);
   }
}
/*final bill*/
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('input[name="csrf-token"]').attr('content')
    }
});
//create invoice     
$("#create_invoice").validate({
    rules: {
        mode: {
            required: true
        },
        amountreceived: {
            required: true,
            number: true
        }
    },
    submitHandler: function(form) {
        $(".submit").attr("disabled", true);
        form.submit();
    }
}); /* serial number*/
function serialcall() {
    var rowCount = $('#cart tr').length;
    for (var i = 1; i <= rowCount; i++) {
        $('#cart tr:nth-child(' + i + ') .sno').text(i)
    }
}

function totalquantity() {
    var quantity = 0;
    $("#cart .proquantity").each(function() {
        quantity += parseInt($(this).val());
    });
    $('#totalquantity').val(quantity);
    document.getElementById("totalquantity").readOnly = true;
} /*prevent duplicate entries of product */
function removeDuplicateRows($table) {
    function getVisibleRowText($row) {
        return $row.find('td:nth-child(3) .sku').val();
    }
    $table.find('tr').each(function(index, row) {
        var $row = $(row);
        $row.nextAll('tr').each(function(index, next) {
            var $next = $(next);
            if (getVisibleRowText($next) == getVisibleRowText($row)) {
                $next.remove();
                var q = $row.find('.proquantity').val();
                q = q * 1 + 1;
                $row.find('.proquantity').val(q);
                var b = $row.find('.productprice').text();
                var cp1 = q * b;
                $row.find('.proprice').text(cp1);
                $row.find('#costprice').val(cp1);
                getTotal();
            }
        })
    });
    getTotal();
} 
  var focused;
  var selected;
   function showKeypad(x, y, tBox){
         var keypad = document.getElementById("keypad");
         if(x != 0 && y != 0){
             keypad.style.marginLeft = x + "vw";             //Setting x and y are optional but it can be 
             keypad.style.marginTop = y + "vh";             //      set to render near textboxes   // Set x & y to 0 to ignore
         }
         keypad.style.display = "block";
         selected=tBox;
         window.focused = document.getElementById(tBox);
    }
    function hideKeyPad(){
          var oldText = focused.value;
          focused.value = oldText.slice(0, -1);;
          $('#'+selected).trigger("change");
    }
    function SendInputs(input)
    {
       if(focused)
       {
            if(input != "CE")
            {
                 var oldText = focused.value;
                 oldText += input;
                 focused.value = oldText;
                 $('#'+selected).trigger("change");
            }
            else
            {
                  focused.value = "";
            }
       }
    }
</script> 
</body> 
</html>