<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();		
    }	
	
	public function is_valid_user($uname, $pass)
	{
		$this->db->select("*");
		$this->db->from("users");
		$this->db->where(array("password"=>$pass, "username"=>$uname, "status"=>CV_STATUS_ACTIVE));
		return $this->db->get()->row_array();
	}	

	public function update_data($table, $condition, $data)
	{
		$this->db->update($table, $data, $condition);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	public function insert_data($table,$data)
    {
        $this->db->insert($table,$data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	
	public function get_table($table, $fields, $condition_arr, $order_by = "id") 
	{
		$this->db->select($fields);		
        $this->db->from($table);
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->order_by($order_by);
		return $this->db->get()->result_array();		
	}
	
	public function get_table_row($table, $fields, $condition_arr, $order_by = "id") 
	{
		$this->db->select($fields);		
        $this->db->from($table);
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->order_by($order_by);
		return $this->db->get()->row_array();		
	}

    public function send_emails($mail_from="", $mail_to="", $subject="", $mail_body="")
	{
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		$this->email->from($mail_from);
		$this->email->to($mail_to);
		$this->email->subject($subject);
		$this->email->message($mail_body);
		$this->email->send();
		$this->email->clear();
	}	
	
	public function send_sms($mobile_no="",$message="")
	{
		if(($mobile_no) and ($message))
		{
			$message = str_replace(' ', '%20', $message);
			
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://trans.smsfresh.co/api/sendmsg.php?user=ripsrewa&pass=ripsrewa&sender=RIPSCH&phone=".$mobile_no."&text=".$message."&priority=ndnd&stype=normal",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"postman-token: c2f596bf-56b4-7136-3967-11133c462e55"
			  ),
			));
			
			$response = curl_exec($curl);
			//$err = curl_error($curl);			
			curl_close($curl);
			
			/*if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
			  echo $response;
			}*/
		}
	}   
	
	public function get_dashboard_statics_dtls() 
	{
		//$this->db->select("COUNT(*) as total_districts, (select count(*) from blocks where blocks.status=".CV_STATUS_ACTIVE.") as total_blocks, (select count(*) from gram_panchayats where gram_panchayats.status=".CV_STATUS_ACTIVE.") as total_panchayats, (select count(*) from villages where villages.status=".CV_STATUS_ACTIVE.") as total_villages, (select count(*) from habitations where habitations.status=".CV_STATUS_ACTIVE.") as total_habitations, (select count(*) from reports) as total_reports, (select count(*) from reports where reports.status=2) as total_approved_reports, (select count(*) from reports where reports.status=3) as total_published_reports, (select count(*) from labs where labs.status=".CV_STATUS_ACTIVE.") as total_labs");		
		$this->db->select("COUNT(*) as total_districts, (select count(*) from blocks where blocks.status=".CV_STATUS_ACTIVE.") as total_blocks, (select count(*) from gram_panchayats where gram_panchayats.status=".CV_STATUS_ACTIVE.") as total_panchayats");
        $this->db->from("districts");
		$this->db->where(array("districts.status"=>CV_STATUS_ACTIVE));
		return $this->db->get()->row_array();		
	}  
}