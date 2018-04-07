<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?php echo $title; ?></h3>
            	<div class="box-tools">
                    <a href="<?php echo site_url('add-dl-member'); ?>" class="btn btn-success btn-sm">Add Member</a> 
                </div>
            </div>
            <div class="box-body">
            <?php echo $this->session->flashdata('message'); ?>
                <table class="table table-striped">
                    <tr>
						<th>No.</th>
                        <th>User Id</th>
						<th>Name</th>
						<th>Email Id</th>
						<th>Mobile No</th>						
                        <th>Designation</th>
                        <th>Division</th>
                        <th>Block</th> 
                        <th>Panchayat</th>
                        <th>Reset Password</th>
						<th>Actions</th>
                    </tr>
                    <?php if($list_data){ 
							foreach($list_data as $row){ ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td><?php echo $row['name'] ; ?></td>
                                    <td><?php echo $row['email_id']; ?></td>
                                    <td><?php echo $row['mobile_no']; ?></td>
                                    <td><?php echo $row['designation_name']; ?></td>                                    
                                    <td><?php echo $row['division_names']; ?></td> 
                                    <td><?php echo $row['block_names']; ?></td> 
                                    <td><?php echo $row['panchayat_names']; ?></td>

                                    <td>
                                    	<?php if($row['designation_id'] <= 9){?>
                                        	<a href="javascript:;" onclick="reset_password(<?php echo $row['id']; ?>);">Reset</a>
                                      	<?php } ?>
                                </td>
                                <td>                                              
                                        <a href="<?php echo site_url('add-dl-member/'.$row['id']); ?>" title="Edit Record"><i class="fa fa_sz green_f fa-pencil"></i></a> 
                                       
                                        <a href="<?php echo site_url('delete-dl-member/'.$row['id']); ?>" title="Delete Record" onclick="return confirm('Are you sure?')"><i class="fa fa_sz red_f fa-trash"></i></a>
                                    </td>
                                </tr>
                    <?php $count++; }
                    	 }else{ ?>
                        <tr><td><p style="color:#FF0000;">No record found.</p></td></tr>
                   <?php } ?>
                </table>
                <div class="pull-right">
                    <?php echo $links; ?>                    
                </div>                
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function reset_password(uid)
    {
        var conf = confirm('Are you sure, you want to reset password.');
        if(conf)
        {
            jQuery.post('<?php echo site_url('reset-password') ?>', {uid : uid}, function(r)
            {
                if(r != '')
                {
                    alert(r);
                }
            });
        }
    }
</script>