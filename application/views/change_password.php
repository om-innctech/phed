<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title; ?></h3>
            </div>
            
           
                
            <?php echo form_open('change-password'); ?>
          	<div class="box-body">
          		<div class="row clearfix">
                <div class="col-sm-6 col-sm-offset-3"> 
				<?php echo $this->session->flashdata('message'); ?>
				<?php if($msg or validation_errors()) { ?>
                     <div class="alert alert-danger">
                        <?php if($msg){echo $msg ."<br/>"; } echo validation_errors();?>
                    </div>
                <?php } ?>
					<div class="reg_login">
                      <div class="form-group">
                            <label for="exampleInputPassword1"><span class="text-danger">*</span>Old Password</label>
                            <input type="password" class="form-control" placeholder="Old Password" name="old_password" value="" maxlength="20" required>
                      </div>
                      <div class="form-group">
                            <label for="exampleInputPassword1"><span class="text-danger">*</span>New Password</label>
                            <input type="password" class="form-control" placeholder="New Password" name="new_password" id="new_password" value="" maxlength="20" required onblur="validate();">
                      </div>
                      <div class="form-group">
                            <label for="exampleInputPassword1"><span class="text-danger">*</span>Confirm Password</label>
                            <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" id="confirm_password" value="" maxlength="20" required onblur="validate();">
                      </div>
                      <div class="action">
                          <div class="row">
                              <div class="col-sm-12 text-right">
                                <button type="submit" class="btn btn btn-success">Change Password</button>
                              </div>
                          </div>
                     </div>
                    </div>
                    </div>
				</div>
			</div>
          	
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>

	

<script>
function validate()
{
	var new_password = $('#new_password').val();
	var confirm_password = $('#confirm_password').val();
	if(confirm_password=='' || new_password == '')
	{	return;		}
	if(new_password != confirm_password)
	{
		alert('New password and confirm password are not same.');
		$('#confirm_password').val('')	
	}
}
</script> 