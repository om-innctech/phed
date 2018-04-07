<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	function help_is_user_logged_in()
	{
		$CI = & get_instance();
		if($CI->session->userdata(CV_SES_USERID) <= 0 or $CI->session->userdata(CV_SES_ROLEID) <= 0)
		{
			redirect(site_url("logout"));
		}
	}
	
	function help_is_valid_district_come_for_rpt($district_id)
	{
		$CI = & get_instance();
		$usr_district_ids_arr = explode(",", $CI->session->userdata(CV_SES_USER_DISTRICTIDS));	
		if(!in_array($district_id, $usr_district_ids_arr))
		{
			redirect(site_url("dashboard"));
		}	
	}
	
	/*function help_is_valid_user($role_id=0)
	{
		$CI = & get_instance();
		if ( $CI->session->userdata(CV_SES_USERID)<=0 or $CI->session->userdata(CV_SES_ROLEID) != $role_id)
		{			
			help_is_user_logged_in();
		}		
	}*/