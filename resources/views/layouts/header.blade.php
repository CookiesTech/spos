<body>

    <!-- START PAGE CONTAINER -->

    <div class="page-container">

        <!-- START PAGE SIDEBAR -->

        <div class="page-sidebar">

            <!-- START X-NAVIGATION -->

            <ul class="x-navigation">

                <li class="xn-logo">

                    <a href="home">Sjewelry</a>

                    <a href="#" class="x-navigation-control"></a>

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
                <li class="<?php if($da=="home"){ echo  "active"; } ?>">
                    <a href="{{ url('admin/home') }}"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>                        
                </li>
                <li class="<?php if($da=="branches"){ echo  "active"; } ?>">
                    <a href="{{ url('admin/branches') }}"><span class="fa fa-files-o"></span>Branches</a>                       
                </li>
                <li class="<?php if($da=="employees"){ echo  "active"; } ?>">
                    <a href="{{ url('admin/employees') }}"><span class="fa fa-files-o"></span>Employees</a>                       
                </li>
                <li class="<?php if($da=="attendance"){ echo  "active"; } ?>">
                    <a href="{{ url('admin/attendance') }}"><span class="fa fa-files-o"></span>Attendance</a>                       
                </li>
                <li class="<?php if($da=="category"){ echo  "active"; } ?>">
                    <a href="{{ url('admin/category') }}"><span class="fa fa-files-o"></span>Category</a>                       
                </li>
                 <li class="<?php if($da=="all_products"){ echo  "active"; } ?>">
                    <a href="{{ url('admin/products/all_products') }}"><span class="fa fa-files-o"></span>Products</a>                       
                </li>
                <li class="<?php if($da=="low_stocks"){ echo  "active"; } ?>">
                    <a href="{{ url('admin/products/low_stocks') }}"><span class="fa fa-files-o"></span>Low Products</a>                       
                </li>
                <li class="<?php if($da=="sales"){ echo  "active"; } ?>">
                    <a href="{{ url('admin/sales') }}"><span class="fa fa-files-o"></span>Sales</a>                       
                </li>
                <li class="<?php if($da=="hide_sales"){ echo  "active"; } ?>">
                    <a href="{{ url('admin/hide_sales') }}"><span class="fa fa-files-o"></span>Hide Sales</a>                       
                </li>
                 <li class="<?php if($da=="branch_bill_status"){ echo  "active"; } ?>">
                    <a href="{{ url('admin/branch_bill_status') }}"><span class="fa fa-files-o"></span>Branch Report</a>                       
                </li>
                <li class="<?php if($da=="time_cards"){ echo  "active"; } ?>">
                    <a href="{{ url('admin/time_cards') }}"><span class="fa fa-files-o"></span>Time Cards</a>                       
                </li>
                <li class="<?php if($da=="reports"){ echo  "active"; } ?>">
                    <a href="{{ url('admin/reports') }}"><span class="fa fa-files-o"></span>Reports</a>                       
                </li>
                 <li class="<?php if($da=="target"){ echo  "active"; } ?>">
                    <a href="{{ url('admin/target') }}"><span class="fa fa-files-o"></span>Target Sheet</a>                       
                </li>
                <li class="<?php if($da=="request"){ echo  "active"; } ?>">
                    <a href="{{ url('admin/request') }}"><span class="fa fa-files-o"></span>Branch Request</a>                       
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

           