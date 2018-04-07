<?php if($ddl_type == "Zone"){?>
    <label class="control-label"><span class="text-danger">*</span>Zone</label>
    <div class="form-group">
    <?php if($designation_id <= 5){?>
        <select class="form-control multipleSelect" name="ddl_zone[]" id="ddl_zone" multiple="multiple" onchange="hide_list('ddl_zone');" required>
            <option value="all">All</option>
            <?php if($data){ foreach($data as $row)
                { ?>
                    <option value="<?php echo $row["id"]; ?>" <?php if(($selected_ids_arr) and in_array($row["id"], $selected_ids_arr)){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
            <?php }} ?>
        </select>
    <?php }else{?>
        <select class="form-control" name="ddl_zone" id="ddl_zone" onchange="get_circles(this.value)" required>
            <option value="">Select</option>
            <?php if($data){ foreach($data as $row){?>
                <option value="<?php echo $row["id"]; ?>" <?php if(($selected_ids_arr) and in_array($row["id"], $selected_ids_arr)){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
            <?php }} ?>							
        </select>
    <?php } ?>
    </div>
<?php } ?>

<?php if($ddl_type == "Circle"){?>
    <label class="control-label"><span class="text-danger">*</span>Circle</label>
    <div class="form-group">
    <?php if($designation_id <= 6){?>
        <select class="form-control multipleSelect" name="ddl_circle[]" id="ddl_circle" multiple="multiple" onchange="hide_list('ddl_circle');" required>
            <option value="all">All</option>
            <?php if($data){ foreach($data as $row)
                { ?>
                    <option value="<?php echo $row["id"]; ?>" <?php if(($selected_ids_arr) and in_array($row["id"], $selected_ids_arr)){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
            <?php }} ?>
        </select>
    <?php }else{?>
        <select class="form-control" name="ddl_circle" id="ddl_circle" onchange="get_divisions(this.value)" required>
            <option value="">Select</option>
            <?php if($data){ foreach($data as $row){?>
                <option value="<?php echo $row["id"]; ?>" <?php if(($selected_ids_arr) and in_array($row["id"], $selected_ids_arr)){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
            <?php }} ?>							
        </select>
    <?php } ?>
    </div>
<?php } ?>

<?php if($ddl_type == "Division"){?>
    <label class="control-label"><span class="text-danger">*</span>Division</label>
    <div class="form-group">
    <?php if($designation_id <= 7){?>
        <select class="form-control multipleSelect" name="ddl_division[]" id="ddl_division" multiple="multiple" onchange="hide_list('ddl_division');" required>
            <option value="all">All</option>
            <?php if($data){ foreach($data as $row)
                { ?>
                    <option value="<?php echo $row["id"]; ?>" <?php if(($selected_ids_arr) and in_array($row["id"], $selected_ids_arr)){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
            <?php }} ?>
        </select>
    <?php }else{?>
        <select class="form-control" name="ddl_division" id="ddl_division" onchange="get_sub_divisions(this.value)" required>
            <option value="">Select</option>
            <?php if($data){ foreach($data as $row){?>
                <option value="<?php echo $row["id"]; ?>" <?php if(($selected_ids_arr) and in_array($row["id"], $selected_ids_arr)){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
            <?php }} ?>							
        </select>
    <?php } ?>
    </div>
<?php } ?>

<?php if($ddl_type == "Sub Division"){?>
    <label class="control-label"><span class="text-danger">*</span>Sub Division</label>
    <div class="form-group">
    <?php if($designation_id <= 8){?>
        <select class="form-control multipleSelect" name="ddl_sub_division[]" id="ddl_sub_division" multiple="multiple" onchange="hide_list('ddl_sub_division');" required>
            <option value="all">All</option>
            <?php if($data){ foreach($data as $row)
                { ?>
                    <option value="<?php echo $row["id"]; ?>" <?php if(($selected_ids_arr) and in_array($row["id"], $selected_ids_arr)){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
            <?php }} ?>
        </select>
    <?php }else{?>
        <select class="form-control" name="ddl_sub_division" id="ddl_sub_division" onchange="get_blocks(this.value)" required>
            <option value="">Select</option>
            <?php if($data){ foreach($data as $row){?>
                <option value="<?php echo $row["id"]; ?>" <?php if(($selected_ids_arr) and in_array($row["id"], $selected_ids_arr)){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
            <?php }} ?>							
        </select>
    <?php } ?>
    </div>
<?php } ?>

<?php if($ddl_type == "Block"){?>
    <label class="control-label"><span class="text-danger">*</span>Block</label>
    <div class="form-group">
    <?php if($designation_id <= 9){?>
        <select class="form-control multipleSelect" name="ddl_block[]" id="ddl_block" multiple="multiple" onchange="hide_list('ddl_block');" required>
            <option value="all">All</option>
            <?php if($data){ foreach($data as $row)
                { ?>
                    <option value="<?php echo $row["id"]; ?>" <?php if(($selected_ids_arr) and in_array($row["id"], $selected_ids_arr)){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
            <?php }} ?>
        </select>
    <?php }else{?>
        <select class="form-control" name="ddl_block" id="ddl_block" onchange="get_panchayats(this.value)" required>
            <option value="">Select</option>
            <?php if($data){ foreach($data as $row){?>
                <option value="<?php echo $row["id"]; ?>" <?php if(($selected_ids_arr) and in_array($row["id"], $selected_ids_arr)){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
            <?php }} ?>							
        </select>
    <?php } ?>
    </div>
<?php } ?>

<?php if($ddl_type == "Panchayat"){?>
    <label class="control-label"><span class="text-danger">*</span>Panchayat</label>
    <div class="form-group">
    <?php if($designation_id <= 11){?>
        <select class="form-control multipleSelect" name="ddl_panchayat[]" id="ddl_panchayat" multiple="multiple" onchange="hide_list('ddl_panchayat');" required>
            <option value="all">All</option>
            <?php if($data){ foreach($data as $row)
                { ?>
                    <option value="<?php echo $row["id"]; ?>" <?php if(($selected_ids_arr) and in_array($row["id"], $selected_ids_arr)){echo 'selected="selected"';}?>><?php echo $row["name"]; ?></option>
            <?php }} ?>
        </select>
    <?php } ?>
    </div>
<?php } ?>

<script>
	$('.multipleSelect').fastselect();
</script>
