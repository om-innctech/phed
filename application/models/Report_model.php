<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();		
    }	
		
	public function get_rpt_districts($condition_arr="")
    {
        $this->db->select("id, name, (select count(*) from blocks where blocks.district_id = districts.id and blocks.status=1) as block_cnts, (SELECT GROUP_CONCAT(CONCAT(`id`)) from blocks WHERE blocks.district_id = districts.id AND blocks.status=1) as block_ids, (SELECT COUNT(*) from gram_panchayats where gram_panchayats.block_id in (SELECT id FROM blocks where blocks.district_id = districts.id and blocks.status=1) and gram_panchayats.status=1) as gp_cnts, (select 0) as ae_cnts, (select 0) as se_cnts, (select 0) as sarpanch_cnts, (select 0) as sachiv_cnts, ");
		$this->db->from('districts');
		$this->db->where(array("status"=>CV_STATUS_ACTIVE));
		if($condition_arr)
		{
			$this->db->where($condition_arr);
		}
		$this->db->order_by('districts.name','asc');
		$data = $this->db->get()->result_array();
		
		$temp_arr = array();
		foreach($data as $d_row)//District loop (d_row = District Row)
		{
			$block_id_arr = explode(",", $d_row["block_ids"]);
			$b_str = "";
			$b_str_for_ae = "";
			if(count($block_id_arr)>0)
			{
				$all_se_usrs = $this->db->select("block_ids")->from('users')->where(array("status"=>CV_STATUS_ACTIVE, "designation_id"=>9))->get()->result_array();
				foreach($all_se_usrs as $se_row)
				{
					$se_block_arr = explode(",", $se_row["block_ids"]);
					foreach($se_block_arr as $se_block)
					{
						if(in_array($se_block, $block_id_arr))
						{
							$d_row["se_cnts"]++;
							break;
						}
					}
				}								
				
				foreach($block_id_arr as $b_row)//Block loop (b_row = Block Row)
				{
					$b_str .= "FIND_IN_SET(".$b_row.", block_ids) OR ";
					$b_str_for_ae .= "FIND_IN_SET(".$b_row.", mapped_block_ids) OR ";
				}
				
				if($b_str)
				{
					//$this->db->select("id")->from('users')->where(array("status"=>CV_STATUS_ACTIVE, "designation_id"=>9));
					//$d_row["se_cnts"] = $this->db->where("(".rtrim($b_str," OR ").")")->count_all_results();
					
					$this->db->select("id")->from('users')->where(array("status"=>CV_STATUS_ACTIVE, "designation_id"=>10));
					$d_row["sarpanch_cnts"] = $this->db->where("(".rtrim($b_str," OR ").")")->count_all_results();
					
					$this->db->select("id")->from('users')->where(array("status"=>CV_STATUS_ACTIVE, "designation_id"=>11));
					$d_row["sachiv_cnts"] = $this->db->where("(".rtrim($b_str," OR ").")")->count_all_results();
					
					$this->db->select("id")->from('sub_divisions')->where(array("status"=>CV_STATUS_ACTIVE));
					$sd_dtls = $this->db->where("(".rtrim($b_str_for_ae," OR ").")")->get()->result_array();
					if($sd_dtls)
					{
						$sd_str = "";
						foreach($sd_dtls as $sd_row)//Sub Divisions loop (sd_row = Sub Divisions Row)
						{
							$sd_str .= "FIND_IN_SET(".$sd_row["id"].", sub_division_ids) OR ";
						}
						
						if($sd_str)
						{
							$this->db->select("id")->from('users')->where(array("status"=>CV_STATUS_ACTIVE, "designation_id"=>8));
							$d_row["ae_cnts"] = $this->db->where("(".rtrim($sd_str," OR ").")")->count_all_results();
						}
					}
				}
			}
			$temp_arr[] = $d_row;
		}
		return $temp_arr;	
    }
	
	public function get_rpt_sub_divisions($rpt_for, $condition_arr)
    {
		$this->db->select("GROUP_CONCAT(CONCAT(blocks.id)) as block_ids, districts.name as district_name");
		$this->db->from('districts');
		$this->db->join('blocks',"districts.id = blocks.district_id");
		$this->db->where(array("blocks.status"=>CV_STATUS_ACTIVE));
		$this->db->where($condition_arr);
		$data = $this->db->get()->row_array();
		
		$block_ids_arr = explode(",", $data["block_ids"]);
		$b_str = "";
		foreach($block_ids_arr as $block)
		{
			$b_str .= "FIND_IN_SET(".$block.", mapped_block_ids) OR ";
		}
		
		$this->db->select("GROUP_CONCAT(CONCAT(id)) as sd_ids")->from('sub_divisions');
		$this->db->where(array("sub_divisions.status"=>CV_STATUS_ACTIVE))->where("(".rtrim($b_str," OR ").")");
		$sd_dtls = $this->db->get()->row_array();
		$sd_ids_arr = explode(",", $sd_dtls["sd_ids"]);	
		
		$district_name = $data["district_name"];
		$block_id_arr = explode(",", $data["block_ids"]);
		$temp_arr = array();
		
		$all_ae_usrs = $this->db->select("*")->from('users')->where(array("status"=>CV_STATUS_ACTIVE, "designation_id"=>$rpt_for))->order_by('users.sub_division_ids','asc')->get()->result_array();
		foreach($all_ae_usrs as $ae_row)
		{
			$flag = 0;
			$ae_sd_arr = explode(",", $ae_row["sub_division_ids"]);
			foreach($ae_sd_arr as $ae_sd_id)
			{
				if(in_array($ae_sd_id, $sd_ids_arr))
				{
					$flag = 1;break;
				}
			}
			if($flag)
			{
				$this->db->select("GROUP_CONCAT(CONCAT(name)) as sd_names")->from('sub_divisions');
				$this->db->where(array("sub_divisions.status"=>CV_STATUS_ACTIVE))->where("id in (".$ae_row["sub_division_ids"].")");
				$sd_name_dtls = $this->db->get()->row_array();
				$temp_arr[] = array("district_name"=>$district_name, "sub_division_name"=>$sd_name_dtls["sd_names"], "usr_dtls"=>$ae_row);
			}
		}	
		//echo "<pre>";print_r($temp_arr);die;							
		return $temp_arr;	
    }
	
	public function get_rpt_blocks($rpt_for, $condition_arr)
    {
        $this->db->select("GROUP_CONCAT(CONCAT(blocks.id)) as block_ids, districts.name as district_name");
		$this->db->from('districts');
		$this->db->join('blocks',"districts.id = blocks.district_id");
		$this->db->where(array("blocks.status"=>CV_STATUS_ACTIVE));
		$this->db->where($condition_arr);
		$data = $this->db->get()->row_array();
		//echo "<pre>";print_r($data);die;
		
		$district_name = $data["district_name"];
		$block_id_arr = explode(",", $data["block_ids"]);
		$temp_arr = array();
		
		$all_se_usrs = $this->db->select("*")->from('users')->where(array("status"=>CV_STATUS_ACTIVE, "designation_id"=>$rpt_for))->order_by('users.block_ids','asc')->get()->result_array();
		foreach($all_se_usrs as $se_row)
		{
			$flag = 0;
			$se_block_arr = explode(",", $se_row["block_ids"]);
			foreach($se_block_arr as $se_block)
			{
				if(in_array($se_block, $block_id_arr))
				{
					$flag = 1;break;
				}
			}
			if($flag)
			{
				$this->db->select("GROUP_CONCAT(CONCAT(name)) as block_names")->from('blocks');
				$this->db->where(array("status"=>CV_STATUS_ACTIVE))->where("id in (".$se_row["block_ids"].")");
				$block_name_dtls = $this->db->get()->row_array();
				$temp_arr[] = array("district_name"=>$district_name, "block_name"=>$block_name_dtls["block_names"], "usr_dtls"=>$se_row);
			}
		}								
		return $temp_arr;	
    }
	
	public function get_rpt_panchayats($rpt_for, $condition_arr)
    {
		/*$this->db->select("GROUP_CONCAT(CONCAT(gram_panchayats.id)) as gp_ids, districts.name as district_name");
		$this->db->from('districts');
		$this->db->join('blocks',"districts.id = blocks.district_id");
		$this->db->join('gram_panchayats',"blocks.id = gram_panchayats.block_id");
		$this->db->where(array("blocks.status"=>CV_STATUS_ACTIVE, "gram_panchayats.status"=>CV_STATUS_ACTIVE));
		$this->db->where($condition_arr);
		$data = $this->db->get()->row_array();
		
		$district_name = $data["district_name"];
		$gp_ids_arr = explode(",", $data["gp_ids"]);*/
		
		$district_name = "";
		$gp_ids_arr = array();
		$temp_arr = array();
		
		$this->db->select("gram_panchayats.id as gp_id, districts.name as district_name");
		$this->db->from('districts');
		$this->db->join('blocks',"districts.id = blocks.district_id");
		$this->db->join('gram_panchayats',"blocks.id = gram_panchayats.block_id");
		$this->db->where(array("blocks.status"=>CV_STATUS_ACTIVE, "gram_panchayats.status"=>CV_STATUS_ACTIVE));
		$this->db->where($condition_arr);
		$data = $this->db->get()->result_array();
		
		foreach($data as $row)
		{
			$district_name = $row["district_name"];
			$gp_ids_arr[] = $row["gp_id"];
		}
		
		$all_gp_usrs = $this->db->select("*")->from('users')->where(array("status"=>CV_STATUS_ACTIVE, "designation_id"=>$rpt_for))->order_by('users.panchayat_ids','asc')->get()->result_array();
		foreach($all_gp_usrs as $gp_row)
		{
			$flag = 0;
			$usr_gp_id_arr = explode(",", $gp_row["panchayat_ids"]);
			foreach($usr_gp_id_arr as $usr_gp_id)
			{
				if(in_array($usr_gp_id, $gp_ids_arr))
				{
					$flag = 1;break;
				}
			}
			if($flag)
			{
				$this->db->select("GROUP_CONCAT(CONCAT(name)) as block_names")->from('blocks');
				$this->db->where(array("status"=>CV_STATUS_ACTIVE))->where("id in (".$gp_row["block_ids"].")");
				$block_name_dtls = $this->db->get()->row_array();
				
				$this->db->select("GROUP_CONCAT(CONCAT(name)) as gp_names")->from('gram_panchayats');
				$this->db->where(array("status"=>CV_STATUS_ACTIVE))->where("id in (".$gp_row["panchayat_ids"].")");
				$gp_name_dtls = $this->db->get()->row_array();
				
				$temp_arr[] = array("district_name"=>$district_name, "block_name"=>$block_name_dtls["block_names"], "gp_name"=>$gp_name_dtls["gp_names"], "usr_dtls"=>$gp_row);
			}
		}								
		return $temp_arr;
    }
	
	public function get_rpt_sub_divisions_NIU($rpt_for, $condition_arr)
    {
        $this->db->select("blocks.id, blocks.name as block_name, districts.name as district_name, (select '') as usr_dtls");
		$this->db->from('blocks');
		$this->db->join('districts',"districts.id = blocks.district_id");
		$this->db->where(array("blocks.status"=>CV_STATUS_ACTIVE));
		$this->db->where($condition_arr);
		$this->db->order_by('blocks.name','asc');
		$data = $this->db->get()->result_array();
		
		$temp_arr = array();
		foreach($data as $row)
		{
			$this->db->select("id")->from('sub_divisions')->where(array("status"=>CV_STATUS_ACTIVE));
			$sd_dtls = $this->db->where("FIND_IN_SET(".$row["id"].", mapped_block_ids)")->get()->result_array();
			if($sd_dtls)
			{
				$sd_str = "";
				foreach($sd_dtls as $sd_row)//Sub Divisions loop (sd_row = Sub Divisions Row)
				{
					$sd_str .= "FIND_IN_SET(".$sd_row["id"].", sub_division_ids) OR ";
				}
				
				if($sd_str)
				{
					$this->db->select("id, name, email_id, username, mobile_no")->from('users')->where(array("status"=>CV_STATUS_ACTIVE, "designation_id"=>$rpt_for));
					$row["usr_dtls"] = $this->db->where("(".rtrim($sd_str," OR ").")")->get()->row_array();
				}
			}
			$temp_arr[] = $row;
		}
		return $temp_arr;
		//echo "<pre>"; print_r($temp_arr); die;	
    }
	
	public function get_rpt_blocks_NIU($rpt_for, $condition_arr)
    {
        $this->db->select("blocks.id, blocks.name as block_name, districts.name as district_name, (select '') as usr_dtls");
		$this->db->from('blocks');
		$this->db->join('districts',"districts.id = blocks.district_id");
		$this->db->where(array("blocks.status"=>CV_STATUS_ACTIVE));
		$this->db->where($condition_arr);
		$this->db->order_by('blocks.name','asc');
		$data = $this->db->get()->result_array();
		
		$temp_arr = array();
		foreach($data as $row)
		{
			$this->db->select("id, name, email_id, username, mobile_no")->from('users')->where(array("status"=>CV_STATUS_ACTIVE, "designation_id"=>$rpt_for));
			$row["usr_dtls"] = $this->db->where("FIND_IN_SET(".$row["id"].", block_ids)")->get()->row_array();
			$temp_arr[] = $row;
		}
		return $temp_arr;	
    }
	
	public function get_rpt_panchayats_NIU($rpt_for, $condition_arr)
    {
        $this->db->select("gram_panchayats.id, gram_panchayats.name as gp_name, blocks.name as block_name, districts.name as district_name, (select '') as usr_dtls");
		$this->db->from('blocks');
		$this->db->join('districts',"districts.id = blocks.district_id");
		$this->db->join('gram_panchayats',"gram_panchayats.block_id = blocks.id");
		$this->db->where(array("blocks.status"=>CV_STATUS_ACTIVE, "gram_panchayats.status"=>CV_STATUS_ACTIVE));
		$this->db->where($condition_arr);
		$this->db->order_by('blocks.name','asc');
		$this->db->order_by('gram_panchayats.name','asc');
		$data = $this->db->get()->result_array();
		
		$temp_arr = array();
		foreach($data as $row)
		{
			$this->db->select("id, name, email_id, username, mobile_no")->from('users')->where(array("status"=>CV_STATUS_ACTIVE, "designation_id"=>$rpt_for));
			$row["usr_dtls"] = $this->db->where("FIND_IN_SET(".$row["id"].", panchayat_ids)")->get()->row_array();
			$temp_arr[] = $row;
		}
		return $temp_arr;	
    }

}