<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()

	{ 

        parent::__construct();

		$this->load->model('admin_model');

		$this->load->model("common_model");

        $this->load->library(array('session', 'form_validation', 'encrypt', 'pagination'));

		$config['full_tag_open'] 	= '<ul class="pagination">';

		$config['full_tag_close'] 	= '</ul>';

		$config['first_link'] 		= 'First';

		$config['first_tag_open'] 	= '<li>';

		$config['first_tag_close'] 	= '</li>';

		$config['last_link'] 		= 'Last';

		$config['last_tag_open'] 	= '<li>';

		$config['last_tag_close'] 	= '</li>';

		$config['next_link'] 		= 'Next &gt;';

		$config['next_tag_open'] 	= '<li>';

		$config['next_tag_close'] 	= '</li>';

		$config['prev_link'] 		= '&lt; Prev';

		$config['prev_tag_open'] 	= '<li>';

		$config['prev_tag_close'] 	= '</li>';

		$config['cur_tag_open'] 	= '<li class="active"><a href="#">';

		$config['cur_tag_close'] 	= '</a></li>';

		$config['num_tag_open'] 	= '<li>';

		$config['num_tag_close'] 	= '</li>';

		$this->pagination->initialize($config);		



		date_default_timezone_set(CV_TIME_ZONE_NAME);		

		help_is_user_logged_in();

    }

	public function index() 

	{

		$data["statics_data"] = $this->common_model->get_dashboard_statics_dtls();

		$data['title'] = "Dashboard";

		$data['body'] = "dashboard";

		$this->load->view('common/structure',$data);			

	}

	

	public function add_member($uid=0) 

	{	

		if($this->session->userdata(CV_SES_ROLEID) != CV_ADMIN_LEVEL)

		{

			redirect("dashboard");

		}

		$data["msg"]="";

		

		if($this->input->post())

		{

			$usr_lvl = "";

			$zone_ids = "";

			$circle_ids = "";

			$division_ids = "";

			$sub_division_ids = "";

			$block_ids = "";

			$panchayat_ids = "";

			

			$usr_designation = $this->input->post("ddl_designation");

			

			if(!$uid)

			{

				$this->form_validation->set_rules('txt_user_id', 'User Id', 'trim|required|max_length[20]|is_unique[users.username]');

			}

			$this->form_validation->set_rules('txt_name', 'Name', 'trim|required|max_length[50]');			

			$this->form_validation->set_rules('txt_email_id', 'Email Id', 'trim|max_length[50]|valid_email');

			$this->form_validation->set_rules('txt_mobile_no', 'Mobile No', 'trim|max_length[10]');

			$this->form_validation->set_rules('ddl_designation', 'Designation', 'trim|required');

			

			if($usr_designation <=5)

			{

				$usr_lvl = CV_ZONE_LEVEL;

				$zone_ids = implode(",", $this->input->post("ddl_zone"));

				$this->form_validation->set_rules('ddl_zone[]', 'Zone', 'trim|required');

			}

			else

			{

				$zone_ids = $this->input->post("ddl_zone");

				$this->form_validation->set_rules('ddl_zone', 'Zone', 'trim|required');

			}

			if($usr_designation == 6)

			{

				$usr_lvl = CV_CIRCLE_LEVEL;

				$circle_ids = implode(",", $this->input->post("ddl_circle"));

				$this->form_validation->set_rules('ddl_circle[]', 'Circle', 'trim|required');

			}

			elseif($usr_designation > 6)

			{

				$circle_ids = $this->input->post("ddl_circle");

				$this->form_validation->set_rules('ddl_circle', 'Circle', 'trim|required');

			}

			if($usr_designation == 7)

			{

				$usr_lvl = CV_DIVISION_LEVEL;

				$division_ids = implode(",", $this->input->post("ddl_division"));

				$this->form_validation->set_rules('ddl_division[]', 'Division', 'trim|required');

			}

			elseif($usr_designation > 7)

			{

				$division_ids = $this->input->post("ddl_division");

				$this->form_validation->set_rules('ddl_division', 'Division', 'trim|required');

			}

			if($usr_designation == 8)

			{

				$usr_lvl = CV_SUB_DIVISION_LEVEL;

				$sub_division_ids = implode(",", $this->input->post("ddl_sub_division"));

				$this->form_validation->set_rules('ddl_sub_division[]', 'Sub Division', 'trim|required');

			}

			elseif($usr_designation > 8)

			{

				$sub_division_ids = $this->input->post("ddl_sub_division");

				$this->form_validation->set_rules('ddl_sub_division', 'Sub Division', 'trim|required');

			}

			if($usr_designation == 9)

			{

				$usr_lvl = CV_BLOCK_LEVEL;

				$block_ids = implode(",", $this->input->post("ddl_block"));

				$this->form_validation->set_rules('ddl_block[]', 'Block', 'trim|required');

			}

			elseif($usr_designation > 9)

			{

				$block_ids = $this->input->post("ddl_block");

				$this->form_validation->set_rules('ddl_block', 'Block', 'trim|required');

			}

			if($usr_designation == 10 or $usr_designation == 11)

			{

				$usr_lvl = CV_PANCHAYAT_LEVEL;

				$panchayat_ids = implode(",", $this->input->post("ddl_panchayat"));

				$this->form_validation->set_rules('ddl_panchayat[]', 'Panchayat', 'trim|required');

			}			

			

			

			if($this->form_validation->run())

			{					

				if($uid)

				{

					$db_data = array("name"=>$this->input->post("txt_name"),

								"email_id"=>$this->input->post("txt_email_id"),

								"mobile_no"=>$this->input->post("txt_mobile_no"),

								"designation_id"=>$this->input->post("ddl_designation"),

								"designation_id"=>$usr_designation,

								"zone_ids"=>$zone_ids,

								"circle_ids"=>$circle_ids,

								"division_ids"=>$division_ids,

								"sub_division_ids"=>$sub_division_ids,

								"block_ids"=>$block_ids,

								"panchayat_ids"=>$panchayat_ids,

								"role"=>$usr_lvl,					

								"updated_by" => $this->session->userdata(CV_SES_USERID),

								"updated_on" => date('Y-m-d H:i:s'));

							

					$this->common_model->update_data("users", array("users.id"=>$uid), $db_data);										

					$this->session->set_flashdata("message","<div style='color:green;'>Data updated successfully.</div>");

					redirect("members-list");					

				}

				

				$this->load->helper('string');

				$pwd = random_string('alnum', 7);

				$db_data = array("username"=>$this->input->post("txt_user_id"),

						"name"=>$this->input->post("txt_name"),

						"email_id"=>$this->input->post("txt_email_id"),

						"mobile_no"=>$this->input->post("txt_mobile_no"),

						"designation_id"=>$usr_designation,

						"zone_ids"=>$zone_ids,

						"circle_ids"=>$circle_ids,

						"division_ids"=>$division_ids,

						"sub_division_ids"=>$sub_division_ids,

						"block_ids"=>$block_ids,

						"panchayat_ids"=>$panchayat_ids,

						"password"=>md5($pwd),

						"role"=>$usr_lvl,

						"created_by" => $this->session->userdata(CV_SES_USERID),

						"created_on" => date('Y-m-d H:i:s'));

				//echo "<pre>";print_r($db_data);die;			

				$this->common_model->insert_data("users", $db_data);	

				if($usr_designation <= 9)

				{								

					$this->session->set_flashdata("message","<div style='color:green;'>Data saved successfully.<br> Password for this user is :- <b>".$pwd."<b></div>");

				}

				else

				{

					$this->session->set_flashdata("message","<div style='color:green;'>Data saved successfully.</div>");

				}

				redirect("add-member");				

			} 

		}

		

		if($uid)

		{

			$data['edit_dtls'] = $this->common_model->get_table_row("users", "*", array("status !="=>CV_STATUS_DELETED, "id"=>$uid));

		}

		

		$data['designations'] = $this->common_model->get_table("designations", "*", array("status"=>CV_STATUS_ACTIVE), "id asc");

		$data['title'] = "Add Users";

		$data['body'] = "add_users";

		$this->load->view('common/structure',$data);			

	}

	

	public function members_list() 

	{

		if($this->session->userdata(CV_SES_ROLEID) != CV_ADMIN_LEVEL)

		{

			redirect("dashboard");

		}

		

		$condition_arr = array("users.status !="=>CV_STATUS_DELETED);

		$config['base_url'] = site_url('members-list');

		$config['total_rows'] = $this->admin_model->get_members_list($condition_arr);

		$config['per_page'] = CV_RECORD_PER_PAGE;

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

		

		$data["count"] = $this->uri->segment(2)+1;

		$data["links"] = $this->pagination->create_links();

		$data["list_data"] = $this->admin_model->get_members_list($condition_arr, $config["per_page"], $page);	

		

		$data['title'] = "Users List";

		$data['body'] = "members_list";

		$this->load->view('common/structure',$data);			

	}	

	

	public function delete_member($member_id)

	{	

		if($this->session->userdata(CV_SES_ROLEID) != CV_ADMIN_LEVEL)

		{

			redirect("dashboard");

		}

		

		$usr_dtls = $this->common_model->get_table_row("users", "*", array("users.id"=>$member_id, "users.status != " => CV_STATUS_DELETED));

		

		if(!$usr_dtls)

		{

			$this->session->set_flashdata("message","<div style='color:red; font-weight:bold;'>Invalid request, You can't delete.</div>");

			redirect("members-list");

		}

		

		$updated_on = date('Y-m-d H:i:s');

		$db_data = array("status"=>CV_STATUS_DELETED,

					"updated_by" => $this->session->userdata(CV_SES_USERID),

					"updated_on" => $updated_on);	

					

		$this->common_model->update_data("users", array("users.id"=>$member_id), $db_data);

		$this->session->set_flashdata("message","<div style='color:green;'>Record deleted successfully.</div>");

		redirect("members-list");

	}

	

	public function block_mapping()

	{

		if($this->session->userdata(CV_SES_ROLEID) != CV_ADMIN_LEVEL)

		{

			redirect("dashboard");

		}

		$data["msg"]="";

		if($this->input->post())

		{

			$this->form_validation->set_rules('ddl_zone', 'Zone', 'trim|required');

			$this->form_validation->set_rules('ddl_circle', 'Circle', 'trim|required');

			$this->form_validation->set_rules('ddl_division', 'Division', 'trim|required');

			$this->form_validation->set_rules('ddl_sub_division', 'Sub Division', 'trim|required');

			$this->form_validation->set_rules('ddl_district', 'District', 'trim|required');

			$this->form_validation->set_rules('chk_blocks[]', 'Blocks', 'trim|required');



			if($this->form_validation->run())

			{

				$sub_division_id = $this->input->post("ddl_sub_division");

				$db_data = array("mapped_block_ids"=>implode(",", $this->input->post("chk_blocks")));

							

				$this->common_model->update_data("sub_divisions", array("sub_divisions.id"=>$sub_division_id), $db_data);										

				$this->session->set_flashdata("message","<div style='color:green;'>Data updated successfully.</div>");

				redirect("block-mapping");

			}

		}

		

		$data['districts'] = $this->common_model->get_table("districts", "*", array("status"=>CV_STATUS_ACTIVE), "name asc");

		$data['zones'] = $this->common_model->get_table("zones", "*", array("status"=>CV_STATUS_ACTIVE), "name asc");

		$data['title'] = "Block Mapping";

		$data['body'] = "block_mapping";

		$this->load->view('common/structure',$data);	

	}



	public function reset_password()

	{ 		

		if($this->session->userdata(CV_SES_ROLEID) != CV_ADMIN_LEVEL and $this->session->userdata(CV_SES_ROLEID) != CV_DIVISION_LEVEL)

		{

			redirect("dashboard");

		}

			

		if($this->input->post())

		{  

			$user_detail = $this->common_model->get_table_row("users", "id", array('users.id'=>$this->input->post("uid")));			

			if($user_detail)

			{			

				$this->load->helper('string');	

				$new_pwd = strtolower(random_string('alnum', 7));

				$this->common_model->update_data("users", array("users.id"=>$user_detail["id"]), array("users.password"=> md5($new_pwd), "users.updated_on"=>date("Y-m-d H:i:s")));

				echo "Password reset successfully. New password is : $new_pwd";

			}

			else

			{

				echo "Password not updated. Try again !";

			}

		}

		else

		{

			echo "Some error !";

		}

	}

	

	public function add_dl_member($uid=0) 

	{	

		if($this->session->userdata(CV_SES_ROLEID) != CV_DIVISION_LEVEL)

		{

			redirect("dashboard");

		}

		$data["msg"]="";

		

		$data['dl_usr_dtls'] = $this->common_model->get_table_row("users", "*", array("id"=>$this->session->userdata(CV_SES_USERID)));

		

		if($this->input->post())

		{

			$sub_division_ids = "";

			$block_ids = "";

			$panchayat_ids = "";			

			$usr_designation = $this->input->post("ddl_designation");

			

			if(!$uid)

			{

				$this->form_validation->set_rules('txt_user_id', 'User Id', 'trim|required|max_length[20]|is_unique[users.username]');

			}

			$this->form_validation->set_rules('txt_name', 'Name', 'trim|required|max_length[50]');			

			$this->form_validation->set_rules('txt_email_id', 'Email Id', 'trim|max_length[50]|valid_email');

			$this->form_validation->set_rules('txt_mobile_no', 'Mobile No', 'trim|max_length[10]');

			$this->form_validation->set_rules('ddl_designation', 'Designation', 'trim|required');

			$this->form_validation->set_rules('ddl_division', 'Division', 'trim|required');

			

			if($usr_designation == 8)

			{

				$usr_lvl = CV_SUB_DIVISION_LEVEL;

				$sub_division_ids = implode(",", $this->input->post("ddl_sub_division"));

				$this->form_validation->set_rules('ddl_sub_division[]', 'Sub Division', 'trim|required');

			}

			elseif($usr_designation > 8)

			{

				$sub_division_ids = $this->input->post("ddl_sub_division");

				$this->form_validation->set_rules('ddl_sub_division', 'Sub Division', 'trim|required');

			}

			if($usr_designation == 9)

			{

				$usr_lvl = CV_BLOCK_LEVEL;

				$block_ids = implode(",", $this->input->post("ddl_block"));

				$this->form_validation->set_rules('ddl_block[]', 'Block', 'trim|required');

			}

			elseif($usr_designation > 9)

			{

				$block_ids = $this->input->post("ddl_block");

				$this->form_validation->set_rules('ddl_block', 'Block', 'trim|required');

			}

			if($usr_designation == 10 or $usr_designation == 11)

			{

				$usr_lvl = CV_PANCHAYAT_LEVEL;

				$panchayat_ids = implode(",", $this->input->post("ddl_panchayat"));

				$this->form_validation->set_rules('ddl_panchayat[]', 'Panchayat', 'trim|required');

			}			

			

			if($this->form_validation->run())

			{					

				if($uid)

				{

					$db_data = array("name"=>$this->input->post("txt_name"),

								"email_id"=>$this->input->post("txt_email_id"),

								"mobile_no"=>$this->input->post("txt_mobile_no"),

								"designation_id"=>$this->input->post("ddl_designation"),

								"designation_id"=>$usr_designation,

								"zone_ids"=>$data['dl_usr_dtls']["zone_ids"],

								"circle_ids"=>$data['dl_usr_dtls']["circle_ids"],

								"division_ids"=>$this->input->post("ddl_division"),

								"sub_division_ids"=>$sub_division_ids,

								"block_ids"=>$block_ids,

								"panchayat_ids"=>$panchayat_ids,

								"role"=>$usr_lvl,					

								"updated_by" => $this->session->userdata(CV_SES_USERID),

								"updated_on" => date('Y-m-d H:i:s'));

							

					$this->common_model->update_data("users", array("users.id"=>$uid), $db_data);										

					$this->session->set_flashdata("message","<div style='color:green;'>Data updated successfully.</div>");

					redirect("dl-members-list");					

				}

				

				$this->load->helper('string');

				$pwd = random_string('alnum', 7);

				$db_data = array("username"=>$this->input->post("txt_user_id"),

						"name"=>$this->input->post("txt_name"),

						"email_id"=>$this->input->post("txt_email_id"),

						"mobile_no"=>$this->input->post("txt_mobile_no"),

						"designation_id"=>$usr_designation,

						"zone_ids"=>$data['dl_usr_dtls']["zone_ids"],

						"circle_ids"=>$data['dl_usr_dtls']["circle_ids"],

						"division_ids"=>$this->input->post("ddl_division"),

						"sub_division_ids"=>$sub_division_ids,

						"block_ids"=>$block_ids,

						"panchayat_ids"=>$panchayat_ids,

						"password"=>md5($pwd),

						"role"=>$usr_lvl,

						"created_by" => $this->session->userdata(CV_SES_USERID),

						"created_on" => date('Y-m-d H:i:s'));

				//echo "<pre>";print_r($db_data);die;			

				$this->common_model->insert_data("users", $db_data);	

				if($usr_designation <= 9)

				{								

					$this->session->set_flashdata("message","<div style='color:green;'>Data saved successfully.<br> Password for this user is :- <b>".$pwd."<b></div>");

				}

				else

				{

					$this->session->set_flashdata("message","<div style='color:green;'>Data saved successfully.</div>");

				}

				redirect("add-dl-member");				

			} 

		}

		

		if($uid)

		{

			$data['edit_dtls'] = $this->common_model->get_table_row("users", "*", array("status !="=>CV_STATUS_DELETED, "id"=>$uid));//echo "<pre>";print_r($data['edit_dtls']);die;

		}

		

		$data['designations'] = $this->common_model->get_table("designations", "*", array("status"=>CV_STATUS_ACTIVE, "id >"=>$this->session->userdata(CV_SES_DESIGNATIONID)), "id asc");

		

		$data["divisions"] = $this->common_model->get_table("divisions", "id, name", "status = ".CV_STATUS_ACTIVE. " AND id in (".$data['dl_usr_dtls']["division_ids"].")", "name asc");

		

		$data['title'] = "Add Users";

		$data['body'] = "add_dl_users";

		$this->load->view('common/structure',$data);			

	}	

	

	public function dl_members_list() 

	{

		if($this->session->userdata(CV_SES_ROLEID) != CV_DIVISION_LEVEL)

		{

			redirect("dashboard");

		}

		

		$dl_usr_dtls = $this->common_model->get_table_row("users", "*", array("id"=>$this->session->userdata(CV_SES_USERID)));

		

		$condition_arr = "users.status != ".CV_STATUS_DELETED. " AND users.id != ".$dl_usr_dtls["id"]. " AND users.division_ids in (".$dl_usr_dtls["division_ids"].")";

		

		$config['base_url'] = site_url('dl-members-list');

		$config['total_rows'] = $this->admin_model->get_members_list($condition_arr);

		$config['per_page'] = CV_RECORD_PER_PAGE;

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

		

		$data["count"] = $this->uri->segment(2)+1;

		$data["links"] = $this->pagination->create_links();

		$data["list_data"] = $this->admin_model->get_members_list($condition_arr, $config["per_page"], $page);	

		

		$data['title'] = "Users List";

		$data['body'] = "dl_members_list";

		$this->load->view('common/structure',$data);			

	}	

	

	public function delete_dl_member($member_id)

	{	

		if($this->session->userdata(CV_SES_ROLEID) != CV_DIVISION_LEVEL)

		{

			redirect("dashboard");

		}

		

		$dl_usr_dtls = $this->common_model->get_table_row("users", "*", array("id"=>$this->session->userdata(CV_SES_USERID)));

		$condition_arr = "users.status != ".CV_STATUS_DELETED. " AND users.id != ".$dl_usr_dtls["id"]. " AND users.id = ".$member_id. " AND users.division_ids in (".$dl_usr_dtls["division_ids"].")";

		

		

		$usr_dtls = $this->common_model->get_table_row("users", "*", $condition_arr);

		

		if(!$usr_dtls)

		{

			$this->session->set_flashdata("message","<div style='color:red; font-weight:bold;'>Invalid request, You can't delete.</div>");

			redirect("dl-members-list");

		}

		

		$updated_on = date('Y-m-d H:i:s');

		$db_data = array("status"=>CV_STATUS_DELETED,

					"updated_by" => $this->session->userdata(CV_SES_USERID),

					"updated_on" => $updated_on);	

					

		$this->common_model->update_data("users", array("users.id"=>$member_id), $db_data);

		$this->session->set_flashdata("message","<div style='color:green;'>Record deleted successfully.</div>");

		redirect("dl-members-list");

	}	



	/*public function rr()
	{
		$this->load->helper('string');
					
		$condition_arr = array("users.id >"=>1, "users.status !="=>CV_STATUS_DELETED);
		$records = $this->admin_model->get_members_list($condition_arr, 200, 0);	
		$temp_arr = array();
		foreach($records as $row)
		{
			$pwd = random_string('alnum', 7);
			$this->common_model->update_data("users", array("users.id"=>$row["id"]), array("users.password"=>md5($pwd)));
			$row["password"] = $pwd;
			$temp_arr[] = $row;		
		}
		
		
		
		$filename =  time().".csv";       
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=\"$filename\"");
		
		
		$fh = fopen( 'php://output', 'w' );
		$heading = false;
			if(!empty($temp_arr))
			  foreach($temp_arr as $row) {
				if(!$heading) {
				  fputcsv($fh, array_keys($row));
				  $heading = true;
				}
				 fputcsv($fh, array_values($row));

			  }
	  fclose($fh);
	}*/

} // End of the controller