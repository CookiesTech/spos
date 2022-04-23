<div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                        <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="btn btn-success btn-lg">Yes</a>
                                                     
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
    <!-- START SCRIPTS -->
     <audio id="audio-alert" src="{{ asset('public/assets/audio/alert.mp3')}}" preload="auto"></audio>
        <audio id="audio-fail" src="{{ asset('public/assets/audio/fail.mp3')}}" preload="auto"></audio>
        <!-- START PLUGINS -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">-->
       <script type="text/javascript" src="{{ asset('public/assets/js/plugins/jquery/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/js/plugins/jquery/jquery-ui.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/js/plugins/bootstrap/bootstrap.min.js')}}"></script>        
        <!-- END PLUGINS -->

        <!-- START THIS PAGE PLUGINS-->        
        <script type='text/javascript' src="{{ asset('public/assets/js/plugins/icheck/icheck.min.js')}}"></script>        
        <script type="text/javascript" src="{{ asset('public/assets/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/js/plugins/scrolltotop/scrolltopcontrol.js')}}"></script>
        
        <script type="text/javascript" src="{{ asset('public/assets/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/js/plugins/tableexport/tableExport.js')}}"></script>
	<script type="text/javascript" src="{{ asset('public/assets/js/plugins/tableexport/jquery.base64.js')}}"></script>
	<script type="text/javascript" src="{{ asset('public/assets/js/plugins/tableexport/html2canvas.js')}}"></script>
	<script type="text/javascript" src="{{ asset('public/assets/js/plugins/tableexport/jspdf/libs/sprintf.js')}}"></script>
	<script type="text/javascript" src="{{ asset('public/assets/js/plugins/tableexport/jspdf/jspdf.js')}}"></script>
	<script type="text/javascript" src="{{ asset('public/assets/js/plugins/tableexport/jspdf/libs/base64.js')}}"></script>   
         <script type="text/javascript" src="{{ asset('public/assets/js/plugins/owl/owl.carousel.min.js')}}"></script> 
        <script type="text/javascript" src="{{ asset('public/assets/js/plugins/bootstrap/bootstrap-select.js')}}"></script>
        
        <script type="text/javascript" src="{{ asset('public/assets/js/plugins/bootstrap/bootstrap-file-input.js')}}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/js/plugins/moment.min.js')}}"></script>
        <!-- END THIS PAGE PLUGINS-->        
         <script type="text/javascript" src="{{ asset('public/assets/js/demo_tables.js')}}"></script> 
        
        <script type="text/javascript" src="{{ asset('public/assets/js/plugins.js')}}"></script>        
        <script type="text/javascript" src="{{ asset('public/assets/js/actions.js')}}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/js/toastr/toastr.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('public/assets/js/demo_dashboard.js')}}"></script>
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->   
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>  
    <script>
  toastr.options = {
  "positionClass" : "toast-top-right",
  "debug" : false,
  "newestOnTop" : false,
  "progressBar" : false,
  "preventDuplicates" : false,
  "onclick" : null,
  "showDuration" : "1",
  "hideDuration" : "1000",
  "timeOut" : "5000",
  "extendedTimeOut" : "1000",
  "showEasing" : "swing",
  "hideEasing" : "linear",
  "showMethod" : "fadeIn",
  "hideMethod" : "fadeOut"
 }
 <?php if(Session::get('success')) { ?>
 toastr.success('{{Session::get("success")}}')
 <?php  } if(Session::get('error')) {?>
 toastr.error('{{Session::get("error")}}')
 <?php } ?>
</script>
    
    </body>
</html>

    </body>
</html>
