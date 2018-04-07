<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();		
    }	
		
	public function get_members_list($condition_arr="", $limit=0, $start=0)
    {
        $this->db->select("users.*, designations.name as designation_name");
		$this->db->from('users');
		$this->db->join('designations', "designations.id=users.designation_id");		
		if($condition_arr)
		{
			$this->db->where($condition_arr);	
		}
		$this->db->order_by('users.name','asc');
		$this->db->limit($limit, $start);
		if($limit)
		{
			$temp_data = array();
			$data = $this->db->get()->result_array();
			if($data)
			{
				foreach($data as $row)
				{
					$zone_names="";
					if($row["zone_ids"])
					{
						$condition_in_arr = "id in (".$row["zone_ids"].")";
						$this->db->select("name");
						$this->db->from('zones');
						$this->db->where($condition_in_arr);
						$zones = $this->db->get()->result_array();
						if($zones)
						{
							$zone_arr = $this->array_value_recursive("name", $zones);
							if(count($zone_arr)>1)
							{
								$zone_names = implode(", ", $zone_arr);
							}
							else
							{
								$zone_names = $zone_arr;
							}							
						}						
					}
					$row["zone_names"] = $zone_names;
					
					$circle_names="";
					if($row["circle_ids"])
					{
						$condition_in_arr = "id in (".$row["circle_ids"].")";
						$this->db->select("name");
						$this->db->from('circles');
						$this->db->where($condition_in_arr);
						$circles = $this->db->get()->result_array();
						if($circles)
						{
							$circle_arr = $this->array_value_recursive("name", $circles);
							if(count($circle_arr)>1)
							{
								$circle_names = implode(", ", $circle_arr);
							}
							else
							{
								$circle_names = $circle_arr;
							}							
						}						
					}
					$row["circle_names"] = $circle_names;
					
					$division_names="";
					if($row["division_ids"])
					{
						$condition_in_arr = "id in (".$row["division_ids"].")";
						$this->db->select("name");
						$this->db->from('divisions');
						$this->db->where($condition_in_arr);
						$divisions = $this->db->get()->result_array();
						if($divisions)
						{
							$division_arr = $this->array_value_recursive("name", $divisions);
							if(count($division_arr)>1)
							{
								$division_names = implode(", ", $division_arr);
							}
							else
							{
								$division_names = $division_arr;
							}							
						}						
					}
					$row["division_names"] = $division_names;
					
					$sub_division_names="";
					if($row["sub_division_ids"])
					{
						$condition_in_arr = "id in (".$row["sub_division_ids"].")";
						$this->db->select("name");
						$this->db->from('sub_divisions');
						$this->db->where($condition_in_arr);
						$sub_divisions = $this->db->get()->result_array();
						if($sub_divisions)
						{
							$sub_division_arr = $this->array_value_recursive("name", $sub_divisions);
							if(count($sub_division_arr)>1)
							{
								$sub_division_names = implode(", ", $sub_division_arr);
							}
							else
							{
								$sub_division_names = $sub_division_arr;
							}							
						}						
					}
					$row["sub_division_names"] = $sub_division_names;
					
					$block_names="";
					if($row["block_ids"])
					{
						$condition_in_arr = "id in (".$row["block_ids"].")";
						$this->db->select("name");
						$this->db->from('blocks');
						$this->db->where($condition_in_arr);
						$blocks = $this->db->get()->result_array();
						if($blocks)
						{
							$block_arr = $this->array_value_recursive("name", $blocks);
							if(count($block_arr)>1)
							{
								$block_names = implode(", ", $block_arr);
							}
							else
							{
								$block_names = $block_arr;
							}							
						}						
					}		
					$row["block_names"] = $block_names;
					
					$panchayat_names="";
					if($row["panchayat_ids"])
					{
						$condition_in_arr = "id in (".$row["panchayat_ids"].")";
						$this->db->select("name");
						$this->db->from('gram_panchayats');
						$this->db->where($condition_in_arr);
						$panchayats = $this->db->get()->result_array();
						if($panchayats)
						{
							$panchayat_arr = $this->array_value_recursive("name", $panchayats);
							if(count($panchayat_arr)>1)
							{
								$panchayat_names = implode(", ", $panchayat_arr);
							}
							else
							{
								$panchayat_names = $panchayat_arr;
							}							
						}						
					}		
					$row["panchayat_names"] = $panchayat_names;
					
					$temp_data[] = $row;
				}
			}
			return $temp_data;
		}
		else
		{
			return $this->db->count_all_results();
		}		
    }
	
	public function array_value_recursive($key, array $arr)
	{
		$val = array();
		array_walk_recursive($arr, function($v, $k) use($key, &$val)
		{
			if($k == $key) array_push($val, $v);
		});
		return count($val) > 1 ? $val : array_pop($val);
	}

}