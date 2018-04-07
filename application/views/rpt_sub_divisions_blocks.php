<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?php echo $title; ?></h3>
                <div class="box-tools">
                    <a href="<?php echo site_url('report'); ?>" class="btn btn-success btn-sm">Back</a> 
                    <?php /*?><?php if($rpt_dtls){
							if($rpt_for=="8"){?>
                    			<a href="<?php echo site_url('download/download_sub_divisions_rpt/'.$this->uri->segment(2)); ?>" class="btn btn-success btn-sm">Download</a>
                    		<?php }else{?>
                            <a href="<?php echo site_url('download/download_blocks_rpt/'.$this->uri->segment(2)); ?>" class="btn btn-success btn-sm">Download</a>                            
                    <?php }} ?>
                    <input type="button" class="btn btn-success btn-sm" onclick="printDiv('printableArea')" value="Print Report" /><?php */?>
                </div>
            </div>
            <div class="box-body" id="printableArea">
            <?php echo $this->session->flashdata('message'); ?>
                <table class="table table-striped">
                    <tr>
						<th>No.</th>
						<th>District Name</th>
                        <?php if($rpt_for=="8"){?>
                        <th>Sub Division Name</th>
                        <th>AE Name</th>
                        <?php }else{?>
						<th>Block Name</th>
                        <th>Sub Engg Name</th>
                        <?php }?>											
                        <th>Mobile No</th>
                        <th>Email Id</th> 
                        <th>ID Created</th>
                    </tr>
                    <?php if($rpt_dtls){
							$count = 1; 
							foreach($rpt_dtls as $row){ ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $row['district_name']; ?></td>
                                    <td><?php if($rpt_for=="8"){echo $row['sub_division_name'];}
											else{echo $row['block_name'];} ?></td>
                                    <td><?php echo $row['usr_dtls']['name']; ?></td>
                                    <td><?php echo $row['usr_dtls']['mobile_no']; ?></td>
                                    <td><?php echo $row['usr_dtls']['email_id']; ?></td> 
                                    <td><?php echo $row['usr_dtls']['username']; ?></td>
                                </tr>
                    <?php $count++; }
                    	 }else{ ?>
                        <tr><td><p style="color:#FF0000;">No record found.</p></td></tr>
                   <?php } ?>
                </table>
                <div class="pull-right">
                    <?php //echo $links; ?>                    
                </div>                
            </div>
        </div>
    </div>
</div>