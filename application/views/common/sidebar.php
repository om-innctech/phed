<?php if($this->session->userdata(CV_SES_ROLEID) == CV_ADMIN_LEVEL){ ?>

    <li class="<?php if($this->uri->segment(1) =="add-member") echo "active"; ?>"> <a href="<?php echo site_url('add-member');?>"><i class="fa fa-plus"></i><span>Add Users</span></a> </li>

    <li class="<?php if($this->uri->segment(1) =="members-list") echo "active"; ?>"> <a href="<?php echo site_url('members-list');?>"><i class="fa fa-list-ul"></i><span>Users List</span></a> </li>
    
    <li class="<?php if($this->uri->segment(1) =="block-mapping") echo "active"; ?>"> <a href="<?php echo site_url('block-mapping');?>"><i class="fa fa-list-ul"></i><span>Block Mapping</span></a> </li>

<?php }elseif($this->session->userdata(CV_SES_ROLEID) == CV_DIVISION_LEVEL){ ?>

    <li class="<?php if($this->uri->segment(1) =="add-dl-member") echo "active"; ?>"> <a href="<?php echo site_url('add-dl-member');?>"><i class="fa fa-plus"></i><span>Add Users</span></a> </li>

    <li class="<?php if($this->uri->segment(1) =="dl-members-list") echo "active"; ?>"> <a href="<?php echo site_url('dl-members-list');?>"><i class="fa fa-list-ul"></i><span>Users List</span></a> </li>

<?php }

if($this->session->userdata(CV_SES_ROLEID) == CV_ADMIN_LEVEL or $this->session->userdata(CV_SES_DESIGNATIONID) <= 7){ ?>
    
    <li class="<?php if($this->uri->segment(1) =="view-report") echo "active"; ?>"> <a href="<?php echo site_url('view-report');?>"><i class="fa fa-plus"></i><span>View Report</span></a> </li>

<?php } ?>

