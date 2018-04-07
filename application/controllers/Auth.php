<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller 
{
    public function __construct()
	{
        parent::__construct();
		$this->load->model("common_model");
		date_default_timezone_set(CV_TIME_ZONE_NAME);
    }	

	public function index() 
	{ 
		if($this->session->userdata(CV_SES_USERID))
		{
			redirect(site_url("dashboard"));
		}

		$data['msg']='';

		if ($_POST)
		{ 
			$this->form_validation->set_rules('username', 'user name', 'trim|required|max_length[20]');
			$this->form_validation->set_rules('passwd', 'password', 'trim|required');

			if ($this->form_validation->run()) 
			{				
				$uname = $this->input->post('username');
				$pass=md5($this->input->post("passwd"));
				$result=$this->common_model->is_valid_user($uname,$pass);
				if($result)
				{
					$detail = array(
						CV_SES_USERID=>$result['id'],
						CV_SES_USER_NAME => $result['name'],
						CV_SES_EMAILID => $result['email_id'],
						CV_SES_ROLEID => $result['role'],
						CV_SES_DESIGNATIONID => $result['designation_id'],
						CV_SES_REGISTERED_ON => date('d M Y', strtotime($result['created_on']))
						);
					$this->session->set_userdata($detail);	
					
					//-------- Code for getting District Ids of the logged in User Start -------					
					$this->db->simple_query('SET SESSION group_concat_max_len=9999999');
					$this->db->select("GROUP_CONCAT(CONCAT(sub_divisions.mapped_block_ids)) as block_ids");
					$this->db->from('zones');
					$this->db->join('circles',"zones.id = circles.zone_id");
					$this->db->join('divisions',"circles.id = divisions.circle_id");
					$this->db->join('sub_divisions',"divisions.id = sub_divisions.division_id");
					$this->db->where(array("zones.status"=>CV_STATUS_ACTIVE, "circles.status"=>CV_STATUS_ACTIVE, "divisions.status"=>CV_STATUS_ACTIVE, "sub_divisions.status"=>CV_STATUS_ACTIVE, "sub_divisions.mapped_block_ids !="=>""));
					if($result['zone_ids'])
					{
						$this->db->where_in("zones.id", explode(",", $result['zone_ids']));
					}
					if($result['circle_ids'])
					{
						$this->db->where_in("circles.id", explode(",", $result['circle_ids']));
					}
					if($result['division_ids'])
					{
						$this->db->where_in("divisions.id", explode(",", $result['division_ids']));
					}										
					$block_ids = $this->db->get()->row_array();					
					
					$this->db->select("district_id");
					$this->db->from('blocks');
					$this->db->where(array("blocks.status"=>CV_STATUS_ACTIVE));
					$this->db->where_in("blocks.id", explode(",", $block_ids["block_ids"]));
					$this->db->group_by('district_id'); 
					$district_dtls = $this->db->get()->result_array();
					$district_ids = "";
					if($district_dtls)
					{
						$district_ids_arr = array();
						foreach($district_dtls as $dist_id)
						{
							$district_ids_arr[] = $dist_id["district_id"];
						}
						$district_ids = implode(",", $district_ids_arr);
					}
					$this->session->set_userdata(array(CV_SES_USER_DISTRICTIDS=>$district_ids));
					//-------- Code for getting District Ids of the logged in User Start -------
					
					redirect(site_url("dashboard"));
				}
				else
				{
					$data["msg"]="User name or password not valid.";
				}			
			}
		}

		$data['title'] = "Login";
		$this->load->view('login',$data);
	}

		

	public function logout()
	{		
		$this->session->sess_destroy();
        setcookie(session_name(), "", time() - 3600);

		//$this->session->set_flashdata('message', '<div align="left" style="color:red;" id="notify"><span><b>Logged out successfully.</b></span></div>');					
		redirect(site_url());
	}

	public function change_password()
	{
		help_is_user_logged_in();
		$data['msg']='';			
		if($_POST)
		{
			$this->form_validation->set_rules('old_password','old password','trim|required');
			$this->form_validation->set_rules('new_password', 'new password', 'trim|required|min_length[5]|matches[confirm_password]');
			$this->form_validation->set_rules('confirm_password', 'confirm password', 'trim|required|min_length[5]');
			if ($this->form_validation->run()) 
			{
				$old_pass=md5($this->input->post("old_password"));
				$new_pass=md5($this->input->post("new_password"));
				$temp = $this->common_model->update_data("users", array("id" => $this->session->userdata(CV_SES_USERID), "password" => $old_pass), array("password" => $new_pass));


				if($temp)
				{
					$this->session->set_flashdata('message', '<div align="left" style="color:green;" id="notify"><span><b>Password updated successfully.</b></span></div>');
				}
				else
				{
					$this->session->set_flashdata('message', '<div align="left" style="color:red;" id="notify"><span><b>Incorrect old password.</b></span></div>');					
				}
				redirect("change-password");
			}
		}
		
		$data['title'] = "Change Password";
		$data['body'] = "change_password";
		$this->load->view('common/structure',$data);
	}

	public function forgot_password_NIU()
	{

		$data['msg']='';

		if($_POST)

		{

			$this->form_validation->set_rules('username', 'Email', 'trim|required|min_length[5]|max_length[50]|valid_email');



			if ($this->form_validation->run())

			{

				$user_dtls = $this->common_model->get_table_row("admin", "*", array("status"=>CV_STATUS_ACTIVE, "username" => $this->input->post("username")));

				

				if($user_dtls)

				{

					$this->load->helper('string');

					$new_pass = random_string('alnum', 6);

					$this->common_model->update_data("admin", array("id" => $user_dtls["id"]), array("password" =>  md5($new_pass)));

					

					$mail_body = "Dear ".strtoupper($user_dtls["first_name"]).",

								<br /><br />

								Your Username :".$user_dtls["username"]."<br />

								<br /><br />

								New Password :".$new_pass."<br />

								<br /><br />";



					$mail_sub = "New Password.";

					

					$this->common_model->send_emails(CV_EMAIL_FROM, $user_dtls["username"], $mail_sub, $mail_body);						

					$this->session->set_flashdata('message', '<div align="left" style="color:green;" id="notify"><span><b>Please check your mail box for getting login details.</b></span></div>');

					redirect("admin");				

				}

				else

				{

					$data['msg']='Email id is not valid.';

				}

			}

		}

		$data['title'] = "Forgot Password";

		$data['body'] = "admin/forgot_password";

		$this->load->view('admin/common/structure',$data);

	}

	

} // End of the controller