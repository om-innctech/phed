<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title><?php echo CV_PROJECT_NAME; ?> | <?php echo $title; ?></title>

        <!-- Tell the browser to be responsive to screen width -->

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- Bootstrap 3.3.6 -->

        <link rel="stylesheet" href="<?php echo base_url('css/bootstrap.min.css');?>">

        <!-- Font Awesome -->

        <link rel="stylesheet" href="<?php echo base_url('css/font-awesome.min.css');?>">

        <!-- Ionicons -->

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

        <!-- Datetimepicker -->

        <link rel="stylesheet" href="<?php echo base_url('css/bootstrap-datetimepicker.min.css');?>">

        <!-- Theme style -->

        <link rel="stylesheet" href="<?php echo base_url('css/AdminLTE.min.css');?>">

        <!-- AdminLTE Skins. Choose a skin from the css/skins

             folder instead of downloading all of them to reduce the load. -->

        <link rel="stylesheet" href="<?php echo base_url('css/_all-skins.min.css');?>">

        

<style>

.loader {

  border: 16px solid #f3f3f3;

  border-radius: 50%;

  border-top: 16px solid blue;

  border-right: 16px solid green;

  border-bottom: 16px solid red;

  width: 80px;

  height: 80px;

  -webkit-animation: spin 2s linear infinite;

  animation: spin 2s linear infinite;

}



@-webkit-keyframes spin {

  0% { -webkit-transform: rotate(0deg); }

  100% { -webkit-transform: rotate(360deg); }

}



@keyframes spin {

  0% { transform: rotate(0deg); }

  100% { transform: rotate(360deg); }

}

</style>

<!-- jQuery 2.2.3 -->

<script src="<?php echo base_url('js/jquery-2.2.3.min.js');?>"></script>



<div id="dv_loader" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;">

    <p style="position: absolute; color: White; top: 40%; left: 45%;" class="loader">

    </p>

</div>



</head>

    

    <body class="hold-transition skin-blue sidebar-mini">

    	

        <div class="wrapper">

            <?php $this->load->view('common/header'); ?>

            <!-- Left side column. contains the logo and sidebar -->

            

            <aside class="main-sidebar">

                <!-- sidebar: style can be found in sidebar.less -->

                <section class="sidebar">

                    <!-- Sidebar user panel -->

                    <div class="user-panel">

                        <div class="pull-left image">

                            <img src="<?php echo base_url('img/user_default_img.jpg');?>" class="img-circle" alt="User Image">

                        </div>

                        <div class="pull-left info">

                            <p><?php echo $this->session->userdata(CV_SES_USER_NAME); ?></p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>

                        </div>

                    </div>

                    <!-- sidebar menu: : style can be found in sidebar.less -->

                    <ul class="sidebar-menu">

                        <li class="header">MAIN NAVIGATION</li>

                        <li class="<?php if($this->uri->segment(2) =="dashboard") echo "active"; ?>">

                            <a href="<?php echo site_url("dashboard");?>">

                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>

                            </a>

                        </li>

                        

                        <?php $this->load->view('common/sidebar'); ?>

                        

                    </ul>

                </section>

                <!-- /.sidebar -->

            </aside>             



            <!-- Content Wrapper. Contains page content -->

            <div class="content-wrapper">

                <!-- Main content -->

                <section class="content">

                   <?php $this->load->view($body); ?>                      

                </section>

                <!-- /.content -->

            </div>

            <!-- /.content-wrapper -->

            <?php $this->load->view('common/footer'); ?>



            <!-- Add the sidebar's background. This div must be placed

            immediately after the control sidebar -->

            <div class="control-sidebar-bg"></div>

        </div>

        <!-- ./wrapper -->





        <!-- Bootstrap 3.3.6 -->

        <script src="<?php echo base_url('js/bootstrap.min.js');?>"></script>

        <!-- FastClick -->

        <script src="<?php echo base_url('js/fastclick.js');?>"></script>

        <!-- AdminLTE App -->

        <script src="<?php echo base_url('js/app.min.js');?>"></script>

        <!-- AdminLTE for demo purposes -->

        <script src="<?php echo base_url('js/demo.js');?>"></script>

        <!-- DatePicker -->

        <script src="<?php echo base_url('js/moment.js');?>"></script>

        <script src="<?php echo base_url('js/bootstrap-datetimepicker.min.js');?>"></script>

        <script src="<?php echo base_url('js/global.js');?>"></script>

        

        <script>

			$(window).load(function(){ 

				$("#dv_loader").hide();

			});

	    </script>

    </body>

</html>

