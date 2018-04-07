<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?php echo $title; ?></h3>
                <div class="box-tools">
                    <a href="<?php echo site_url('download/download_districts_rpt'); ?>" class="btn btn-success btn-sm">Download</a> 
                    <?php /*?><input type="button" class="btn btn-success btn-sm" onclick="printDiv('printableArea')" value="Print Report" /><?php */?>
                </div>
            </div>
            <div class="box-body" id="printableArea">
            <?php echo $this->session->flashdata('message'); ?>
                <table class="table table-striped">
                    <tr>
						<th>No.</th>
						<th>District Name</th>
						<th>No of Blocks</th>
						<th>No of Panchayats</th>						
                        <th>No of AE</th>
                        <th>No of SE</th> 
                        <th>No of Sarpanchs</th>
                        <th>No of Sachivs</th>
                    </tr>
                    <?php if($rpt_dtls){
							$count = 1; 
							foreach($rpt_dtls as $row){ ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['block_cnts'] ; ?></td>
                                    <td><?php echo $row['gp_cnts']; ?></td>
                                    <td><?php if($row['ae_cnts']){ ?><a href="<?php echo site_url('ae/'.$row['id']); ?>"><?php echo $row['ae_cnts']; ?></a><?php }else{echo "0";} ?></td>
                                    <td><?php if($row['se_cnts']){ ?><a href="<?php echo site_url('se/'.$row['id']); ?>"><?php echo $row['se_cnts']; ?></a><?php }else{echo "0";} ?></td> 
                                    <td><?php if($row['sarpanch_cnts']){ ?><a href="<?php echo site_url('sarpanchs/'.$row['id']); ?>"><?php echo $row['sarpanch_cnts']; ?></a><?php }else{echo "0";} ?></td>
                                    <td><?php if($row['sachiv_cnts']){ ?><a href="<?php echo site_url('sachivs/'.$row['id']); ?>"><?php echo $row['sachiv_cnts']; ?></a><?php }else{echo "0";} ?></td>
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