<link rel="stylesheet" href="<?php echo base_url(); ?>dist/fastselect.min.css">
<script src="<?php echo base_url(); ?>dist/fastselect.standalone.js"></script>
<style>
	.fstElement { font-size: 10px; border: 2px solid #e6ecef !important; }
	.fstToggleBtn { min-width: 16.5em; }
	.submitBtn { display: none; }
	.fstMultipleMode { display: block; }
	.fstMultipleMode .fstControls { width: 100%; }
</style>

<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title"><?php echo $title; ?></h3>
                <div class="box-tools">                 	
                    	<a href="<?php echo site_url('dl-members-list'); ?>" class="btn btn-success btn-sm"><i class="fa fa-th-list" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp; Users List</a>
                </div>
            </div>
            
            <?php echo form_open(); ?>
          	<div class="box-body">
          		<div class="row clearfix">
                
                	<div class="col-md-12">
                	<?php $readonly_class=""; 
						if(isset($edit_dtls))
						{							
							 $readonly_class="readonly"; 
						}
						echo $this->session->flashdata('message'); ?>
					<?php if($msg or validation_errors()) { ?>
                         <div class="alert alert-danger">
                            <?php if($msg){echo $msg ."<br/>"; } echo validation_errors();?>
                        </div>
                    <?php } ?>
                    </div>
                	
                    <div class="col-md-4">
						<label class="control-label"><span class="text-danger">*</span>User Id</label>
						<div class="form-group">
							<input type="text" name="txt_user_id" value="" class="form-control" id="txt_user_id" maxlength="20" required onblur="check_userid_exist(this.value);" <?php echo $readonly_class; ?>/>							
						</div>
					</div>
                    
					<div class="col-md-4">
						<label class="control-label"><span class="text-danger">*</span>Name</label>
						<div class="form-group">
							<input type="text" name="txt_name" value="" class="form-control" id="txt_name" maxlength="50" required />							
						</div>
					</div>
					
					<div class="col-md-4">
						<label class="control-label">Emial Id</label>
						<div class="form-group">
							<input type="email" name="txt_email_id" value="" class="form-control" id="txt_email_id" maxlength="50"/>
						</div>
					</div>
					<div class="col-md-4">
						<label class="control-label">Mobile No</label>
						<div class="form-group">
							<input type="text" name="txt_mobile_no" value="" class="form-control" id="txt_mobile_no" maxlength="10" />
						</div>
					</div>	
                    <div class="col-md-4">
						<label class="control-label"><span class="text-danger">*</span>Designation</label>
						<div class="form-group">
                        	<select class="form-control" name="ddl_designation" id="ddl_designation" required onchange="reset_ddls()">
                            	<option value="">Select</option>
                               	<?php foreach($designations as $row){?>
                              		<option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
							    <?php } ?>							
                            </select>
						</div>
					</div>	
                    			
                    <div class="col-md-4">
                    	<label class="control-label"><span class="text-danger">*</span>Division</label>
                        <div class="form-group">
                            <select class="form-control" name="ddl_division" id="ddl_division" onchange="get_sub_divisions(this.value)" required>
                                <option value="">Select</option>
                                <?php if($divisions){ foreach($divisions as $row){?>
                                    <option value="<?php echo $row["id"]; ?>" ><?php echo $row["name"]; ?></option>
                                <?php }} ?>							
                            </select>
                        </div>
                    </div>                    
                    <div class="col-md-4" id="dv_sub_division"></div>   
                    <div class="col-md-4" id="dv_block"></div>   
                    <div class="col-md-4" id="dv_panchayat"></div>
				</div>
			</div>
          	<div class="box-footer text-right">
            	<button type="submit" class="btn btn-success">
            		<i class="fa fa-check"></i> Submit
            	</button>
          	</div>
            <?php echo form_close(); ?>

      	</div>
    </div>
</div>

<script>
$('.multipleSelect').fastselect();
function hide_list(obj_id)
{
    $('#'+ obj_id +' :selected').each(function(i, selected)
    {
        if($(selected).val()=='all')
        {
            $('#'+ obj_id).closest(".fstElement").find('.fstChoiceItem').each(function()
            {
            	$(this).find(".fstChoiceRemove").trigger("click");
            });
			show_list(obj_id);
            $("div").removeClass("fstResultsOpened fstActive");
        }
    });    
}

function show_list(obj)
{
    $('#'+ obj ).siblings('.fstResults').children('.fstResultItem') .each(function(i, selected)
	{
        if($(this).html()!='All')
        {
            $(this).trigger("click");
        }
    });
}

function check_userid_exist(uid)
{
	if(uid)
	{
		$.post('<?php echo site_url('common_controller/check_userid_exist') ?>', {uid: uid}, function(r) 
		{
			if(r != '')
			{
				$("#txt_user_id").val('');
				alert("User Id "+ uid + " already exist, please enter new user id.");
			}
		});
	}
}

var sub_division_ids = "";
var block_ids = "";
var panchayat_ids = "";

<?php if(isset($edit_dtls)){ ?>

	sub_division_ids = "<?php echo $edit_dtls["sub_division_ids"]; ?>";
	block_ids = "<?php echo $edit_dtls["block_ids"]; ?>";
	panchayat_ids = "<?php echo $edit_dtls["panchayat_ids"]; ?>";
	
<?php } ?>

function reset_ddls()
{
	$("#ddl_division").val('');
	$("#dv_sub_division").html('');
	$("#dv_block").html('');
	$("#dv_panchayat").html('');
}

function get_sub_divisions(did)
{
	var des_id = $('#ddl_designation').val();
	if(des_id<=0)
	{
		$("#ddl_division").val('');
		alert('Please select any Designation first.');
		return false;	
	}
	$("#dv_block").html('');
	$("#dv_panchayat").html('');
	$.post('<?php echo site_url('common_controller/get_sub_divisions') ?>', {did : did, des_id: des_id, sub_division_ids:sub_division_ids}, function(r) 
	{
		if(r != '')
		{
			$('#dv_sub_division').html(r);
		}
	});	
}

function get_blocks(sdid)
{
	var des_id = $('#ddl_designation').val();
	$("#dv_panchayat").html('');
	$.post('<?php echo site_url('common_controller/get_blocks') ?>', {sdid : sdid, des_id: des_id, block_ids: block_ids}, function(r) 
	{
		if(r != '')
		{
			$('#dv_block').html(r);
		}
	});	
}

function get_panchayats(bid)
{
	var des_id = $('#ddl_designation').val();
	
	$.post('<?php echo site_url('common_controller/get_panchayats') ?>', {bid : bid, des_id: des_id, panchayat_ids: panchayat_ids}, function(r) 
	{
		if(r != '')
		{
			$('#dv_panchayat').html(r);
		}
	});	
}
<?php if(isset($edit_dtls)){?>
	
	$('#txt_user_id').val('<?php echo $edit_dtls["username"]; ?>');
	$('#txt_name').val('<?php echo $edit_dtls["name"]; ?>');
	$('#txt_email_id').val('<?php echo $edit_dtls["email_id"]; ?>');
	$('#txt_mobile_no').val('<?php echo $edit_dtls["mobile_no"]; ?>');
	$('#ddl_designation').val('<?php echo $edit_dtls["designation_id"]; ?>');
	$('#ddl_division').val('<?php echo $edit_dtls["division_ids"]; ?>');
	
	<?php if($edit_dtls["designation_id"] >= 8){?>
	get_sub_divisions('<?php echo $edit_dtls["division_ids"]; ?>');
	<?php }if($edit_dtls["designation_id"] >= 9){?>
	get_blocks('<?php echo $edit_dtls["sub_division_ids"]; ?>');
	<?php }if($edit_dtls["designation_id"] >= 10){?>
	get_panchayats('<?php echo $edit_dtls["block_ids"]; ?>');	
	<?php }?>
	
	sub_division_ids = "";
	block_ids = "";
	panchayat_ids = "";
	
<?php } ?>
</script>