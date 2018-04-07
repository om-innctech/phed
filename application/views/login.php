<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Log in</title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<!-- bootstrap 3.0.2 -->
<link href="<?php echo base_url("css/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css" />
<!-- font Awesome -->
<link href="<?php echo base_url("css/font-awesome.min.css"); ?>" rel="stylesheet" type="text/css" />
<!-- Theme style -->
<link href="<?php echo base_url("css/AdminLTE.min.css"); ?>" rel="stylesheet" type="text/css" />

<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" rel="stylesheet" type="text/css" />

</head>
<body class="bg-black bg-black_log">
<div class="login_new">
<div class="container">
<div class="gen_info">
<div class="row">
<div class="col-sm-7">
<div class="basic animated fadeInLeft">
<div class="logo">
<div class="row">
<div class="col-lg-2 col-sm-12">
<img src="<?php echo base_url("img/LOGO_NEW.png"); ?>">
</div>
<div class="col-lg-10 col-sm-12">
<h3>Drinking Water Testing Information Management</h3>
<h5>Madya Pradesh Public Health Engineering Department</h5>
</div>
</div>

</div>
<div class="text_info">
<h4>An Initiative taken By Madya Pradesh Public Health Engineering Department</h4>
</div>
<div class="image-box">
<img src="<?php echo base_url("img/map_mp.png"); ?>">
</div>
</div>
</div>
<div class="col-sm-5">
<div class="login_info animated fadeInRight">
<div class="textt">
<h3 class="header">Sign In</h3>
<div class="foot">
 <?php echo $this->session->flashdata('message'); ?>
	<?php if($msg or validation_errors()) { ?>
         <div class="alert alert-danger">
         <?php echo $msg; echo "<br/>". validation_errors();?>
        </div>
  <?php } ?>
<form method="post">
  <div class="form-group">
    
    <input type="text" class="form-control" placeholder="Enter User Name" name="username" value="" maxlength="20" required>
  </div>
  <div class="form-group">

    <input type="password" class="form-control" placeholder="Enter Password" name="passwd" value="" maxlength="20" required>
  </div>
  <button type="submit" class="btn btn-success">Log In</button>
  
  <?php /*?><a href="<?php echo "#";//site_url("forgot-password");?>"><h4>Forgot Password</h4></a><?php */?>
</form>
</div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php /*?><div class="form-box" id="login-box">
  <div class="header">Sign In</div>
 <?php echo $this->session->flashdata('message'); ?>
	<?php if($msg or validation_errors()) { ?>
         <div class="alert alert-danger">
         <?php echo $msg; echo "<br/>". validation_errors();?>
        </div>
  <?php } ?>
  <form action="" method="post">
    <div class="body bg-gray">
      <div class="form-group">
		<input type="email" class="form-control" placeholder="Enter Email Id" name="username" value="" maxlength="50" required>
      </div>
      <div class="form-group">
        <input type="password" class="form-control" placeholder="Enter Password" name="passwd" value="" maxlength="20" required>
      </div>
      
    </div>
    <div class="footer">
      <button type="submit" class="btn bg-olive btn-block">LogIn</button>
    
      <p align="right" style="padding-right:15px;"><a href="<?php echo "#";//site_url("forgot-password");?>" style="font-size:18px; font-weight:bold" >Forgot Password</a> </p>
    </div>
  </form>
  
</div><?php */?>

<!-- jQuery 2.0.2 --> 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script> 
<!-- Bootstrap --> 
<script src="<?php echo base_url("js/bootstrap.min.js"); ?>" type="text/javascript"></script>
</body>
</html>
<style>
.login_new{ display:block; width:100%; padding:3% 0%;}
.login_new .gen_info{ display:block; width:100%; padding:3%;}
.login_new .gen_info .basic{ display:block; width:100%; padding:3%; background:rgba(66, 129, 160, 0.9) none repeat scroll 0 0; border-radius:6px; border:1px solid #3d9970;}
.login_new .gen_info .basic .logo{ width:100%; display:block; padding-bottom:3%; border-bottom:1px solid #FFF; margin-bottom:10px;}




.login_new .gen_info .basic .logo img{ width:100%;}
.login_new .gen_info .basic .logo h3{margin-top:10px; font-size:21px; color:#FFF; font-weight:bold;}
.login_new .gen_info .basic .logo h5{ font-size:18px; color:#FF0; margin-top:0px;}
.login_new .gen_info .basic .text_info{ display:block; width:100%;}
.login_new .gen_info .basic .text_info h3{color:#fff; text-align:center; font-size:23px; margin-top:20px; padding-bottom:20px; border-bottom:1px solid #FFF; font-weight:bold;}
.login_new .gen_info .basic .text_info h4{ color:#fff; text-align:center; font-size:20px; margin-top:20px;margin-bottom:20px; font-weight:bold;}
.login_new .gen_info .basic .image-box{ display:block; width:100%; text-align:center;}
.login_new .gen_info .basic .image-box img{ width:60%;}

.login_new .gen_info .login_info{ display:block; width:100%; margin-top:15%;}
.login_new .gen_info .login_info .textt{ display:block; width:100%; padding:2% 0%; text-align:center; }
.login_new .gen_info .login_info .textt h3{color: #060;
    font-size: 30px;
    font-weight: bold;
    margin: 0px;
    text-transform: uppercase; padding-bottom:5%;}

.login_new .gen_info .login_info .textt .btn{ width:100%; font-size:18px; background-color: #538ca9;}

.login_new .gen_info .login_info .textt h3.header{background: #538ca9 none repeat scroll 0 0;
    border-radius: 4px 4px 0 0;
    box-shadow: 0 -3px 0 rgba(0, 0, 0, 0.2) inset;
    color: #fff;
    font-size: 26px;
    font-weight: 300;
    padding: 20px 10px;
    text-align: center;}

.login_new .gen_info .login_info .textt .foot{background: #fff none repeat scroll 0 0;
    color: #444;
    padding:30px 20px 30px 20px;
	 border-radius:0 0 4px 4px;
	 border:1px solid #538ca9;
	
	}

.login_new .gen_info .login_info .textt .foot .form-group{ margin-bottom:20px;}

.login_new .gen_info .login_info .textt .foot a h4{ color:#538ca9; margin-top:10px; font-size: 16px; margin-top: 18px; text-align:left;}

@media (max-width:767px){
	.login_new .gen_info .basic .logo img{ width:50%;}
	.login_new .gen_info .basic .logo{ text-align:center;}
	}

@media (min-width:768px) and (max-width:1279px){
	.login_new .gen_info .basic .logo img{ width:15%;}
	.login_new .gen_info .basic .logo{ text-align:center;}
	}
.form-box{ display:none;}




</style>