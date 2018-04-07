<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Api extends CI_Controller 
{
    public function __construct()
	{
        parent::__construct();
		$this->load->model("common_model");
		date_default_timezone_set(CV_TIME_ZONE_NAME);
    }	
	
	public function get_new_samples_list()
	{		
		$url ="http://indiawater.gov.in/mRWSRestService/RestServiceImpl.svc/GetWQM_WaterQualityTestingSamplesJson/9786EBFA177516D33FEB0BCC93A68403/2BEC053BBCC327528D869F8078CC13B6/017/0229/2016-2017/06042017/07042017";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);	
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Length: 0"));
		$res = curl_exec($ch);
		curl_close($ch);		
		$response = json_decode($res, true);
		if(count($response)>0)
		{
			foreach($response as $key => $row)
			{
				$sample_param_dtls = $response[$key]["Sampleparameteres"];
				unset($response[$key]["apiKey"], $response[$key]["Sampleparameteres"]);
				//echo "<pre>"; print_r($sample_param_dtls);
				//echo "<pre>"; print_r($response[$key]); die;
				$db_sample_ins_arr = $response[$key];
				$db_sample_ins_arr["created_on"] = date("Y-m-d H:i:s");
				$this->common_model->insert_data("sample_details", $db_sample_ins_arr);
				$sample_id = $this->db->insert_id();
				$db_sample_param_ins_arr = array();
				if(count($sample_param_dtls)>0)
				{
					foreach($sample_param_dtls as $param_row)
					{
						$param_row["sample_dtls_id"] = $sample_id;
						$db_sample_param_ins_arr[] = $param_row;
					}
					$this->db->insert_batch("sample_param_dtls", $db_sample_param_ins_arr);
				}
			}
			
		}
		echo "<pre>"; print_r($res); die;
	}
	
	public function post_sample_details_NIU()
	{
		$json = file_get_contents("php://input");
        $post_arr = json_decode($json, true);

		$err_arr = array();
		$err_counts = 1;

		if(isset($post_arr['apiKey']) && $post_arr['apiKey']=="r5vi827ccb0eea8a706c4c34a16891f84e7b")
		{
			/*if(!trim($post_arr["stateId"]))
			{
				$err_arr[] = "State Id is required.";
				$err_counts++;
			}
			if(!trim($post_arr["stateName"]))
			{
				$err_arr[] = "State Name is required.";
				$err_counts++;
			}*/
			if(!isset($post_arr["districtId"]) or !trim($post_arr["districtId"]))
			{
				$err_arr[] = "District Id is required.";
				$err_counts++;
			}
			if(!isset($post_arr["districtName"]) or !trim($post_arr["districtName"]))
			{
				$err_arr[] = "District Name is required.";
				$err_counts++;
			}
			if(!isset($post_arr["blockId"]) or !trim($post_arr["blockId"]))
			{
				$err_arr[] = "Block Id is required.";
				$err_counts++;
			}
			if(!isset($post_arr["blockName"]) or !trim($post_arr["blockName"]))
			{
				$err_arr[] = "Block Name is required.";
				$err_counts++;
			}
			if(!isset($post_arr["panchayatId"]) or !trim($post_arr["panchayatId"]))
			{
				$err_arr[] = "Panchayat Id is required.";
				$err_counts++;
			}
			if(!isset($post_arr["panchayatName"]) or !trim($post_arr["panchayatName"]))
			{
				$err_arr[] = "Panchayat Name is required.";
				$err_counts++;
			}
			if(!isset($post_arr["villageId"]) or !trim($post_arr["villageId"]))
			{
				$err_arr[] = "Village Id is required.";
				$err_counts++;
			}
			if(!isset($post_arr["villageName"]) or !trim($post_arr["villageName"]))
			{
				$err_arr[] = "Village Name is required.";
				$err_counts++;
			}
			if(!isset($post_arr["habitationId"]) or !trim($post_arr["habitationId"]))
			{
				$err_arr[] = "Habitation Id is required.";
				$err_counts++;
			}
			if(!isset($post_arr["habitationName"]) or !trim($post_arr["habitationName"]))
			{
				$err_arr[] = "Habitation Name is required.";
				$err_counts++;
			}
			if(!isset($post_arr["sourceId"]) or !trim($post_arr["sourceId"]))
			{
				$err_arr[] = "Source Id is required.";
				$err_counts++;
			}
			if(!isset($post_arr["sourceName"]) or !trim($post_arr["sourceName"]))
			{
				$err_arr[] = "Source Name is required.";
				$err_counts++;
			}
			if(!isset($post_arr["sourceLocation"]) or !trim($post_arr["sourceLocation"]))
			{
				$err_arr[] = "Source Location is required.";
				$err_counts++;
			}
			if(!isset($post_arr["labId"]) or !trim($post_arr["labId"]))
			{
				$err_arr[] = "Lab Id is required.";
				$err_counts++;
			}
			if(!isset($post_arr["labType"]) or !trim($post_arr["labType"]))
			{
				$err_arr[] = "Lab Type is required.";
				$err_counts++;
			}
			if(!isset($post_arr["labLocation"]) or !trim($post_arr["labLocation"]))
			{
				$err_arr[] = "Lab Location is required.";
				$err_counts++;
			}
			if(!isset($post_arr["labAddress"]) or !trim($post_arr["labAddress"]))
			{
				$err_arr[] = "Lab Address is required.";
				$err_counts++;
			}
			if(!isset($post_arr["subDivisionName"]) or !trim($post_arr["subDivisionName"]))
			{
				$err_arr[] = "Sub Division Name is required.";
				$err_counts++;
			}
			if(!isset($post_arr["contactPersonName"]) or !trim($post_arr["contactPersonName"]))
			{
				$err_arr[] = "Contact Person Name is required.";
				$err_counts++;
			}
			if(!isset($post_arr["testId"]) or !trim($post_arr["testId"]))
			{
				$err_arr[] = "Test Id is required.";
				$err_counts++;
			}
			if(!isset($post_arr["sampleNo"]) or !trim($post_arr["sampleNo"]))
			{
				$err_arr[] = "Sample No is required.";
				$err_counts++;
			}
			if(!isset($post_arr["testingDate"]) or !trim($post_arr["testingDate"]))
			{
				$err_arr[] = "Testing Date is required.";
				$err_counts++;
			}
			/*if(!isset($post_arr["sampleParameteres"]) or !trim($post_arr["sampleParameteres"]))
			{
				$err_arr[] = "Sample Parametere is required.";
				$err_counts++;
			}*/
			if(!isset($post_arr["verifierName"]) or !trim($post_arr["verifierName"]))
			{
				$err_arr[] = "Verifier Name is required.";
				$err_counts++;
			}
			if(!isset($post_arr["verifierEmail"]) or !trim($post_arr["verifierEmail"]))
			{
				$err_arr[] = "Verifier Email is required.";
				$err_counts++;
			}
			if(!isset($post_arr["verifierMobile"]) or !trim($post_arr["verifierMobile"]))
			{
				$err_arr[] = "Verifier Mobile No is required.";
				$err_counts++;
			}

			if($err_counts==1)
			{
				$this->common_model->insert_data("sample_details", array("sample_json_data" => $json));
				$response_arr["status"] = true;
				$response_arr["statusCode"] = 200;
				$response_arr["message"] = "Sample details saved successfully.";
			}
			else
			{
				$response_arr["status"] = false;
				$response_arr["statusCode"] = 400;
				$response_arr["errors"] = $err_arr;
			}
		}
		else
		{
			$err_arr[] = "Authentication is invalid.";
			$response_arr["status"] = false;
			$response_arr["statusCode"] = 400;
			$response_arr["errors"] = $err_arr;				
		}
        echo json_encode($response_arr);

	}
	
} // End of the controller