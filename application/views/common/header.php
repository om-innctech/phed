<header class="main-header">

    <!-- Logo -->

    <a href="<?php echo site_url("dashboard");?>" class="logo">

        <!-- mini logo for sidebar mini 50x50 pixels -->

        <span class="logo-mini"><?php echo CV_PROJECT_NAME_SMALL; ?></span>

        <!-- logo for regular state and mobile devices -->

        <span class="logo-lg"><?php echo CV_PROJECT_NAME_SMALL; ?></span>

    </a>

    <!-- Header Navbar: style can be found in header.less -->

    <nav class="navbar navbar-static-top">

        <!-- Sidebar toggle button-->

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">

            <span class="sr-only">Toggle navigation</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

        </a>



        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

            <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                        <img src="<?php echo base_url('img/user_default_img.jpg');?>" class="user-image" alt="User Image">

                        <span class="hidden-xs"><?php echo $this->session->userdata(CV_SES_USER_NAME); ?></span>

                    </a>

                    <ul class="dropdown-menu">

                        <!-- User image -->

                        <li class="user-header">

                            <img src="<?php echo base_url('img/user_default_img.jpg');?>" class="img-circle" alt="User Image">



                        <p>

                            <?php echo $this->session->userdata(CV_SES_USER_NAME); ?>

                            <small>Member since :: <?php echo $this->session->userdata(CV_SES_REGISTERED_ON); ?> </small>

                        </p>

                        </li>

                        <!-- Menu Footer-->

                        <li class="user-footer">

                            <div class="pull-left">

                                <a href="<?php echo site_url("change-password"); ?>" class="btn btn-default btn-flat">Change Password</a>

                            </div>

                            <div class="pull-right">

                                <a href="<?php echo site_url("logout"); ?>" class="btn btn-default btn-flat">Sign Out</a>

                            </div>

                        </li>

                    </ul>

                </li>

            </ul>

        </div>

    </nav>

</header>