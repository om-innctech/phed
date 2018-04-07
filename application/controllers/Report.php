<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Report extends CI_Controller 
{
    public function __construct()
	{
        parent::__construct();
		$this->load->model("report_model");
		date_default_timezone_set(CV_TIME_ZONE_NAME);
    }
	
	/*private function is_valid_district_come_for_rpt($district_id)
	{
		$usr_district_ids_arr = explode(",", $this->session->userdata(CV_SES_USER_DISTRICTIDS));	
		if(!in_array($district_id, $usr_district_ids_arr))
		{
			redirect(site_url("dashboard"));
		}
	}*/
	
	public function index()
	{		
		$cnd_arr = "districts.id in (".$this->session->userdata(CV_SES_USER_DISTRICTIDS).")";
		$data["rpt_dtls"] = $this->report_model->get_rpt_districts($cnd_arr);
		$data['title'] = "Report";
		$data['body'] = "rpt_districts";
		$this->load->view('common/structure',$data);
	}
	
	public function rpt_sub_divisions($district_id)
	{		
		//$this->is_valid_district_come_for_rpt($district_id);
		help_is_valid_district_come_for_rpt($district_id);
		$data['rpt_for'] = 8;// AE Designation Id
		$data["rpt_dtls"] = $this->report_model->get_rpt_sub_divisions($data['rpt_for'], array("blocks.district_id"=>$district_id));
		$data['title'] = "Report";
		$data['body'] = "rpt_sub_divisions_blocks";
		$this->load->view('common/structure',$data);
	}

	public function rpt_blocks($district_id)
	{		
		//$this->is_valid_district_come_for_rpt($district_id);
		help_is_valid_district_come_for_rpt($district_id);
		$data['rpt_for'] = 9;//Sub Engg.  Designation Id
		$data["rpt_dtls"] = $this->report_model->get_rpt_blocks($data['rpt_for'], array("districts.id"=>$district_id));
		$data['title'] = "Report";
		$data['body'] = "rpt_sub_divisions_blocks";
		$this->load->view('common/structure',$data);
	}
	
	public function rpt_sarpanchs($district_id)
	{		
		//$this->is_valid_district_come_for_rpt($district_id);
		help_is_valid_district_come_for_rpt($district_id);
		$data['rpt_for'] = 10;//Sarpanch Designation Id
		$data["rpt_dtls"] = $this->report_model->get_rpt_panchayats($data['rpt_for'], array("districts.id"=>$district_id));
		$data['title'] = "Report";
		$data['body'] = "rpt_panchayats";
		$this->load->view('common/structure',$data);
	}
	
	public function rpt_sachivs($district_id)
	{		
		//$this->is_valid_district_come_for_rpt($district_id);
		help_is_valid_district_come_for_rpt($district_id);
		$data['rpt_for'] = 11;//Sachiv Designation Id
		$data["rpt_dtls"] = $this->report_model->get_rpt_panchayats($data['rpt_for'], array("districts.id"=>$district_id));
		$data['title'] = "Report";
		$data['body'] = "rpt_panchayats";
		$this->load->view('common/structure',$data);
	}
	
} // End of the controller