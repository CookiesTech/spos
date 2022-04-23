@include('layouts.links')
@include('layouts.header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    #invoice{
        padding: 30px;
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
<ul class="breadcrumb">
    <li><a href="home">Home</a></li>
    <li>unsales</li>
</ul>

<div class="page-content-wrap">
    <input type="checkbox" class="check_all" style="margin-left:20px;"><span class="">Select All</span>
    <div class="row">
        <div class="col-md-12">
            <!-- START DATATABLE EXPORT -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <button style="margin: 5px;" class="btn btn-danger btn-xs delete-all" data-url="">UnHide</button>
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
                                    {{ $data->invoice_id }}
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
@include('layouts.footer')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script>
       $('.check_all').change(function(){
           alert('hi');
         if($(this).is(':checked',true))  
         {
            $(".checkbox").prop('checked', true);  

         } else {  
            $(".checkbox").prop('checked',false);  
         }  
        });


         $('.checkbox').on('click',function(){
            if($('.checkbox:checked').length == $('.checkbox').length){

                $('#check_all').prop('checked',true);

            }else{

                $('#check_all').prop('checked',false);
            }
         });

        $('.delete-all').on('click', function(e) {
            var idsArr = [];  
            $(".checkbox:checked").each(function() {  
                idsArr.push($(this).attr('data-id'));

            });  
            if(idsArr.length <=0)  
            {  
                alert("Please select atleast one record to delete.");  
            }  else {  
                if(confirm("Are you sure, you want to delete the selected categories?")){  
                    var strIds = idsArr.join(","); 
                    $.ajax({
                        url: "{{URL::to('admin/unhide_invoice')}}",
                        type: 'post',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+strIds,
                        success: function (data) {
                            if (data!=0) {
                                $(".checkbox:checked").each(function() {  
                                    $(this).parents("tr").remove();
                                });
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });
        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function (event, element) {
                element.closest('form').submit();
            }
        });   
                }  
            }  
        });
</script>
<script>
    $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var token = "{{ Session::token() }}";
        var parent = $(this).parent();
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            showLoaderOnConfirm: true,
        },
                function () {
                    $.ajax({
                        type: 'delete',
                        url: "{{URL::to('admin/delete_invoice')}}",
                        data: "_token=" + token + "&id=" + id,
                        beforeSend: function () {
                            $("." + id).css("background-color", "#fb6c6c");
                        },
                        success: function (data1) {
                            parent.slideUp(300, function () {
                                if (data1 == 0)
                                {
                                    swal('Deleted!', 'Branch Deleted', 'success');
                                    $("." + id).remove();
                                    $("#customers2 tbody").html("<tr><td colspan='8' align='center'>Nodata </td></tr>");
                                    $("#customers2_info").html("Showing 0 entries");
                                } else
                                {
                                    $("." + id).remove();
                                    $("#customers2_info").html("Showing 1 to " + data1 + " of " + data1 + " entries");
                                }

                            });
                        }
                    });
                });
    });
</script>