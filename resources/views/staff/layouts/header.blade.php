<body>
    <!-- START PAGE CONTAINER -->
    <div class="page-container">
        <!-- START PAGE SIDEBAR -->
        <div class="page-sidebar">
            <!-- START X-NAVIGATION -->
            <ul class="x-navigation">
                <li class="xn-logo">
                    <a href="{{ url('staff/staff_dashboard') }}"></a>
                    <a href="{{ url('staff/staff_dashboard') }}" class="x-navigation-control"></a>
                </li>
                <li class="xn-profile">

                    <div class="profile">

                        <div class="profile-data">
                            <div class="profile-data-name">{{ Auth::user()->name }}</div>
                            <div class="profile-data-title">{{ Auth::user()->email }}</div>
                        </div>

                    </div>                                                                        
                </li>
                	<?php  
		               $da=last(request()->segments());
		         ?>
                <li class="<?php if($da=="staff_dashboard"){ echo  "active"; } ?>">
                    <a href="{{ url('staff/staff_dashboard') }}"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>                        
                </li>                    
                <li class="<?php if($da=="staff_products"){ echo  "active"; } ?>">
                    <a href="{{ url('staff/staff_products') }}"><span class="fa fa-desktop"></span> <span class="xn-text">Products</span></a>                        
                </li>    
                <li class="<?php if($da=="staff_pos"){ echo  "active"; } ?>">
                    <a href="{{ url('staff/staff_pos') }}"><span class="fa fa-files-o"></span>Billing</a>                       
                </li>
                 <li class="<?php if($da=="staff_sales"){ echo  "active"; } ?>">
                    <a href="{{ url('staff/staff_sales') }}"><span class="fa fa-files-o"></span>Sales Report</a>                       
                </li>
                <li class="<?php if($da=="staff_timecards"){ echo  "active"; } ?>">
                    <a href="{{ url('staff/staff_timecards') }}"><span class="fa fa-files-o"></span>Time Cards</a>                       
                </li>
                <li class="<?php if($da=="sales_target"){ echo  "active"; } ?>">
                    <a href="{{ url('staff/sales_target') }}"><span class="fa fa-files-o"></span>Sales Target</a>                       
                </li>
                <li class="<?php if($da=="request"){ echo  "active"; } ?>">
                    <a href="{{ url('staff/request') }}"><span class="fa fa-files-o"></span>Request</a>                       
                </li>
            </ul>
            <!-- END X-NAVIGATION -->
        </div>
        <!-- END PAGE SIDEBAR -->
        <!-- PAGE CONTENT -->
        <div class="page-content">
            <!-- START X-NAVIGATION VERTICAL -->
            <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                <!-- TOGGLE NAVIGATION -->
                <li class="xn-icon-button">
                    <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                </li>
                <li class="xn-icon-button pull-right">
                    <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>                        
                </li> 
                <!-- END SIGN OUT -->
            </ul>
            <!-- END X-NAVIGATION VERTICAL -->   
             <div id="message">
                @if(Session::has('flash_message'))
                <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_message') !!}</em></div>
                @endif
                @if(Session::has('flash_message_delete'))
                <div class="alert alert-danger"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_message_delete') !!}</em></div>
                @endif
            </div>
            @section('content')
           