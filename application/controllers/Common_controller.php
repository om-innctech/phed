<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common_controller extends CI_Controller
{
    public function __construct()
	{ 
        parent::__construct();		
		$this->load->model("common_model");		
    }
	
	public function check_userid_exist() 
	{	
		$usr_dtls = $this->common_model->get_table_row("users", "id", array("username"=>$this->input->post("uid")), "name asc");
		if($usr_dtls)
		{
			echo true;
		}
	}	

	public function get_zones() 
	{	
		$data["selected_ids_arr"] = explode(",", $this->input->post("zone_ids"));	
		//echo "<pre>";print_r($data);
		$data["ddl_type"] = "Zone";
		$data["designation_id"] = $this->input->post("des_id");
		$data['data'] = $this->common_model->get_table("zones", "*", array("status"=>CV_STATUS_ACTIVE), "name asc");
		$this->load->view('fill_ddls_dynamically',$data);	
	}
	
	public function get_circles() 
	{	
		$data["selected_ids_arr"] = explode(",", $this->input->post("circle_ids"));	
		$data["ddl_type"] = "Circle";
		$data["designation_id"] = $this->input->post("des_id");
		$data["data"] = $this->common_model->get_table("circles", "id, name", array("zone_id"=>$this->input->post("zid"), "status"=>CV_STATUS_ACTIVE), "name asc");
		$this->load->view('fill_ddls_dynamically',$data);
	}	
	
	public function get_divisions() 
	{	
		$data["selected_ids_arr"] = explode(",", $this->input->post("division_ids"));	
		$data["ddl_type"] = "Division";
		$data["designation_id"] = $this->input->post("des_id");
		$data["data"] = $this->common_model->get_table("divisions", "id, name", array("circle_id"=>$this->input->post("cid"), "status"=>CV_STATUS_ACTIVE), "name asc");
		$this->load->view('fill_ddls_dynamically',$data);
	}
	
	public function get_sub_divisions() 
	{		
		$data["selected_ids_arr"] = explode(",", $this->input->post("sub_division_ids"));	
		$data["ddl_type"] = "Sub Division";
		$data["designation_id"] = $this->input->post("des_id");
		$data["data"] = $this->common_model->get_table("sub_divisions", "id, name", array("division_id"=>$this->input->post("did"), "status"=>CV_STATUS_ACTIVE), "name asc");
		$this->load->view('fill_ddls_dynamically',$data);
	}
	
	public function get_blocks() 
	{	
		$data["selected_ids_arr"] = explode(",", $this->input->post("block_ids"));	
		$data["ddl_type"] = "Block";
		$data["designation_id"] = $this->input->post("des_id");
		$sub_division_dtls = $this->common_model->get_table_row("sub_divisions", "*", array("sub_divisions.id"=>$this->input->post("sdid"), "status"=>CV_STATUS_ACTIVE), "id desc");
		$data["data"] = "";
		if($sub_division_dtls["mapped_block_ids"])
		{
			$data["data"] = $this->common_model->get_table("blocks", "id, name", "status = ".CV_STATUS_ACTIVE." and id in (".$sub_division_dtls["mapped_block_ids"].")", "name asc");
		}
		$this->load->view('fill_ddls_dynamically',$data);
	}
	
	public function get_panchayats() 
	{	
		$data["selected_ids_arr"] = explode(",", $this->input->post("panchayat_ids"));	
		$data["ddl_type"] = "Panchayat";
		$data["designation_id"] = $this->input->post("des_id");
		$data["data"] = $this->common_model->get_table("gram_panchayats", "id, name", array("block_id"=>$this->input->post("bid"), "status"=>CV_STATUS_ACTIVE), "name asc");
		$this->load->view('fill_ddls_dynamically',$data);
	}
	
	public function get_blocks_for_mapping() 
	{		
		$district_id = $this->input->post("district_id");
		$sub_division_id = $this->input->post("sub_division_id");

		$data = $this->common_model->get_table("blocks", "id, name", array("district_id"=>$district_id, "status"=>CV_STATUS_ACTIVE), "name asc");
                $this->db->simple_query('SET SESSION group_concat_max_len=9999999');
		$mapped_blockes = $this->common_model->get_table_row("sub_divisions", "GROUP_CONCAT(CONCAT(`mapped_block_ids`)) AS `mapped_block_ids`", array("id !="=>$sub_division_id, "mapped_block_ids !="=>""));
		$mapped_blockes_arr = explode(",", $mapped_blockes["mapped_block_ids"]);

		$sub_division_old_dtls = $this->common_model->get_table_row("sub_divisions", "mapped_block_ids", array("id"=>$sub_division_id));
		$sub_division_block_ids_arr = explode(",", $sub_division_old_dtls["mapped_block_ids"]);
		$str = "";
		if($data)
		{
			$str = "<p><h4>Blocks</h4>
	<div class='checkbox'>
	  <label style='font-size:16px;'><input type='checkbox' name='chk_all' value='all' onclick='check_uncheck_all(this);'/>Select All</label>
	</div></p>";
			foreach($data as $row)
			{
				if(!in_array($row["id"], $mapped_blockes_arr))
				{
					$str .= "<div class='col-md-4'><div class='form-group'><div class='checkbox'><label style='font-size:15px;'>";
					if(in_array($row["id"], $sub_division_block_ids_arr))
					{
						$str .= "<input type='checkbox' name='chk_blocks[]' value='".$row["id"]."' checked='checked'>";
					}
					else
					{
						$str .= "<input type='checkbox' name='chk_blocks[]' value='".$row["id"]."'>";
					}
					
					$str .= $row["name"]."</label></div></div></div>";
				}
			}
			
			$str .= "<div class='box-footer text-right'>
	        <button type='submit' class='btn btn-success'> <i class='fa fa-check'></i> Submit </button>
	      </div>";
	  }
		echo $str;
	}
	
	
	
	
	public function get_circles_for_block_mapping() 
	{		
		
		$data = $this->common_model->get_table("circles", "id, name", array("zone_id"=>$this->input->post("zid"), "status"=>CV_STATUS_ACTIVE), "name asc");
		echo "<option value=''>Select</option>";
		foreach($data as $row)
		{
			echo "<option value='".$row['id']."'>".$row['name']."</option>";
		}		
	}
	public function get_divisions_for_block_mapping() 
	{		
		
		$data = $this->common_model->get_table("divisions", "id, name", array("circle_id"=>$this->input->post("cid"), "status"=>CV_STATUS_ACTIVE), "name asc");
		echo "<option value=''>Select</option>";
		foreach($data as $row)
		{
			echo "<option value='".$row['id']."'>".$row['name']."</option>";
		}		
	}
	public function get_sub_divisions_for_block_mapping() 
	{		
		
		$data = $this->common_model->get_table("sub_divisions", "id, name", array("division_id"=>$this->input->post("did"), "status"=>CV_STATUS_ACTIVE), "name asc");
		echo "<option value=''>Select</option>";
		foreach($data as $row)
		{
			echo "<option value='".$row['id']."'>".$row['name']."</option>";
		}		
	}
	
	
	
	/*public function get_rpt_dtls_NIU($id) 
	{
		//$data = $this->technician_model->get_report_details(array("reports.id"=>$id));
		$data['lab_params'] = $this->common_model->get_table("lab_parameters", "*", array("status"=>CV_STATUS_ACTIVE), "id asc");
		$this->load->view(CV_LAB_TECHNICIAN_FOLDER."/view_report_details",$data);			
	}*/
	
	
} // End of the controller