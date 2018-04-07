<div class="row">
  <div class="col-md-12">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo $title; ?></h3>
      </div>
      <?php echo form_open(); ?>
      <div class="box-body">
        <div class="row clearfix">
          <div class="col-md-12">
            <?php echo $this->session->flashdata('message'); ?>
            <?php if($msg or validation_errors()) { ?>
            <div class="alert alert-danger">
              <?php if($msg){echo $msg ."<br/>"; } echo validation_errors();?>
            </div>
            <?php } ?>
          </div>
          
          <div class="col-md-4">
            <label class="control-label"><span class="text-danger">*</span>Zone</label>
            <div class="form-group">
              <select class="form-control" name="ddl_zone" id="ddl_zone" required onchange="get_circles(this.value)">
                <option value="">Select</option>
                <?php foreach($zones as $row){?>
                <option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <label class="control-label">Circle</label>
            <div class="form-group">
              <select class="form-control" name="ddl_circle" id="ddl_circle" onchange="get_divisions(this.value)">
                <option value="">Select</option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <label class="control-label">Division</label>
            <div class="form-group">
              <select class="form-control" name="ddl_division" id="ddl_division" onchange="get_sub_divisions(this.value)">
                <option value="">Select</option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <label class="control-label">Sub Division</label>
            <div class="form-group">
              <select class="form-control" name="ddl_sub_division" id="ddl_sub_division" onchange="reset_district()">
                <option value="">Select</option>
              </select>
            </div>
          </div>
          
          <div class="col-md-4">
            <label class="control-label"><span class="text-danger">*</span>District</label>
            <div class="form-group">
              <select class="form-control" name="ddl_district" id="ddl_district"  required onchange="get_blocks(this.value);">
                <option value="">Select</option>
                <?php foreach($districts as $row){?>
                <option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          
          <div class="col-md-10" id="dv_blocks">
          </div>
          
        </div>
      </div>
      
      <?php echo form_close(); ?> </div>
  </div>
</div>
<script>

function get_blocks(district_id)
{
  $('#dv_blocks').html('');
  if($('#ddl_sub_division').val()<=0)
  {
    $('#ddl_district').val('');
    alert("Please select Sub Division first.");
    return;
  }
  var sub_division_id = $('#ddl_sub_division').val();
	$.post('<?php echo site_url('common_controller') ?>/get_blocks_for_mapping', {district_id : district_id, sub_division_id: sub_division_id}, function(r) 
	{
		if(r != '')
		{
			$('#dv_blocks').html(r);
		}
	});	
}

function get_circles(zid)
{
  $('#ddl_district').val('');
  $('#dv_blocks').html('');
	$('#ddl_circle').html('<option value="">Select</option>');
	$('#ddl_division').html('<option value="">Select</option>');
	$('#ddl_sub_division').html('<option value="">Select</option>');
	$.post('<?php echo site_url('common_controller/get_circles_for_block_mapping') ?>', {zid : zid}, function(r) 
	{
		if(r != '')
		{
			$('#ddl_circle').html(r);
		}
	});	
}

function get_divisions(cid)
{
  $('#ddl_district').val('');
  $('#dv_blocks').html('');
	$('#ddl_division').html('<option value="">Select</option>');
	$('#ddl_sub_division').html('<option value="">Select</option>');
	$.post('<?php echo site_url('common_controller/get_divisions_for_block_mapping') ?>', {cid : cid}, function(r) 
	{
		if(r != '')
		{
			$('#ddl_division').html(r);
		}
	});	
}

function get_sub_divisions(did)
{
  $('#ddl_district').val('');
  $('#dv_blocks').html('');
	$('#ddl_sub_division').html('<option value="">Select</option>');
	$.post('<?php echo site_url('common_controller/get_sub_divisions_for_block_mapping') ?>', {did : did}, function(r)
	{
		if(r != '')
		{
			$('#ddl_sub_division').html(r);
		}
	});	
}

function reset_district()
{
  $('#ddl_district').val('');
  $('#dv_blocks').html('');
}

function check_uncheck_all(obj)
{
  var val = $(obj).is(":checked");
  
  $("input[name='chk_blocks[]']").each(function ()
  {
    $(this).prop('checked', val);
  });
}
</script>