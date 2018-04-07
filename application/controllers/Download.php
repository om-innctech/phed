<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Download extends CI_Controller 
{
    public function __construct()
	{
        parent::__construct();
		$this->load->model("report_model");
		$this->load->library('excel');
		date_default_timezone_set(CV_TIME_ZONE_NAME);
    }
	
	public function download_districts_rpt()
	{		
		$cnd_arr = "districts.id in (".$this->session->userdata(CV_SES_USER_DISTRICTIDS).")";
		$rpt_data = $this->report_model->get_rpt_districts($cnd_arr);
		
		$excel_name = "Districts-Report";		
		$rpt_header[] = array("name"=>"District Name", "block_cnts"=>"No of Blocks", "gp_cnts"=>"No of Panchayats", "ae_cnts"=>"No of AE", "se_cnts"=>"No of SE", "sarpanch_cnts"=>"No of Sarpanchs", "sachiv_cnts"=>"No of Sachivs");
		foreach($rpt_data as $key => $row)
		{
			unset($rpt_data[$key]["id"], $rpt_data[$key]["block_ids"]);
			//array($row["name"], $row["block_cnts"], $row["gp_cnts"], $row["ae_cnts"], $row["se_cnts"], $row["sarpanch_cnts"], $row["sachiv_cnts"]);
		}
		$exceldata = array_merge($rpt_header, $rpt_data);
		//echo "<pre>";print_r($exceldata);die;
		$this->downlaod_excel($exceldata, $excel_name);
	}
	
	public function download_sub_divisions_rpt($district_id)
	{	
		help_is_valid_district_come_for_rpt($district_id);
		$data['rpt_for'] = 8;// AE Designation Id
		$data = $this->report_model->get_rpt_sub_divisions($data['rpt_for'], array("blocks.district_id"=>$district_id));
		$excel_name = "Sub-Divisions-Report";
		
		$rpt_header[] = array("district_name"=>"District Name", "sub_division_name"=>"Sub Division Name", "user_name"=>"AE Name", "user_mobile_no"=>"Mobile No", "user_email"=>"Email Id", "user_created_id"=>"ID Created");
		$rpt_data = array();
		foreach($data as $key => $row)
		{
			$rpt_data[] = array("district_name"=>$row["district_name"], "sub_division_name"=>$row["sub_division_name"], "user_name"=>$row['usr_dtls']['name'], "user_mobile_no"=>$row['usr_dtls']['mobile_no'], "user_email"=>$row['usr_dtls']['email_id'], "user_created_id"=>$row['usr_dtls']['username']);
		}
		$exceldata = array_merge($rpt_header, $rpt_data);
		$this->downlaod_excel($exceldata, $excel_name);
	}
	
	public function download_blocks_rpt($district_id)
	{	
		help_is_valid_district_come_for_rpt($district_id);
		$data['rpt_for'] = 9;//Sub Engg.  Designation Id
		$data = $this->report_model->get_rpt_blocks($data['rpt_for'], array("districts.id"=>$district_id));
		$excel_name = "Blocks-Report";
		
		$rpt_header[] = array("district_name"=>"District Name", "block_name"=>"Block Name", "user_name"=>"Sub Engg Name", "user_mobile_no"=>"Mobile No", "user_email"=>"Email Id", "user_created_id"=>"ID Created");
		$rpt_data = array();
		foreach($data as $key => $row)
		{
			$rpt_data[] = array("district_name"=>$row["district_name"], "block_name"=>$row["block_name"], "user_name"=>$row['usr_dtls']['name'], "user_mobile_no"=>$row['usr_dtls']['mobile_no'], "user_email"=>$row['usr_dtls']['email_id'], "user_created_id"=>$row['usr_dtls']['username']);
		}
		$exceldata = array_merge($rpt_header, $rpt_data);
		$this->downlaod_excel($exceldata, $excel_name);
	}
	
	public function download_sarpanchs_rpt($district_id)
	{	
		help_is_valid_district_come_for_rpt($district_id);
		$data['rpt_for'] = 10;//Sarpanch Designation Id
		$data = $this->report_model->get_rpt_panchayats($data['rpt_for'], array("districts.id"=>$district_id));
		$excel_name = "Sarpanchs-Report";
		
		$rpt_header[] = array("district_name"=>"District Name", "block_name"=>"Block Name", "gp_name"=>"Panchayat Name", "user_name"=>"Sarpanch Name", "user_mobile_no"=>"Mobile No", "user_email"=>"Email Id", "user_created_id"=>"ID Created");
		$rpt_data = array();
		foreach($data as $key => $row)
		{
			$rpt_data[] = array("district_name"=>$row["district_name"], "block_name"=>$row["block_name"], "gp_name"=>$row["gp_name"], "user_name"=>$row['usr_dtls']['name'], "user_mobile_no"=>$row['usr_dtls']['mobile_no'], "user_email"=>$row['usr_dtls']['email_id'], "user_created_id"=>$row['usr_dtls']['username']);
		}
		$exceldata = array_merge($rpt_header, $rpt_data);
		$this->downlaod_excel($exceldata, $excel_name);
	}
	
	public function download_sachivs_rpt($district_id)
	{	
		help_is_valid_district_come_for_rpt($district_id);
		$data['rpt_for'] = 11;//Sachiv Designation Id
		$data = $this->report_model->get_rpt_panchayats($data['rpt_for'], array("districts.id"=>$district_id));
		$excel_name = "Sachivs-Report";
		
		$rpt_header[] = array("district_name"=>"District Name", "block_name"=>"Block Name", "gp_name"=>"Panchayat Name", "user_name"=>"Sachiv Name", "user_mobile_no"=>"Mobile No", "user_email"=>"Email Id", "user_created_id"=>"ID Created");
		$rpt_data = array();
		foreach($data as $key => $row)
		{
			$rpt_data[] = array("district_name"=>$row["district_name"], "block_name"=>$row["block_name"], "gp_name"=>$row["gp_name"], "user_name"=>$row['usr_dtls']['name'], "user_mobile_no"=>$row['usr_dtls']['mobile_no'], "user_email"=>$row['usr_dtls']['email_id'], "user_created_id"=>$row['usr_dtls']['username']);
		}
		$exceldata = array_merge($rpt_header, $rpt_data);
		$this->downlaod_excel($exceldata, $excel_name);
	}
	
	private function downlaod_excel($exceldata, $excel_name="report")
	{	
		/*$this->excel->setActiveSheetIndex(0);
        //name the worksheet
		$this->excel->getActiveSheet()->setTitle('Student');
        //set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', 'Excel Sheet Generated! Happy to help!!');

		$this->excel->getActiveSheet()->setCellValue('A2', 'Name');
		$this->excel->getActiveSheet()->setCellValue('B2', 'Address');
		$this->excel->getActiveSheet()->setCellValue('C2', 'Gender');
		$this->excel->getActiveSheet()->setCellValue('D2', 'Year of Passing');

        //merge cell A1 until C1
		$this->excel->getActiveSheet()->mergeCells('A1:D1');
        //set aligment to center for that merged cell (A1 to C1)
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

		for($col = ord('A'); $col <= ord('D'); $col++){
                //set column dimension
			$this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
         //change the font size
			$this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);

			$this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}

		//Fill data 
		$this->excel->getActiveSheet()->fromArray($exceldata, null, 'A3');
		
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/
		
		
		//Fill data 
		$this->excel->getActiveSheet()->fromArray($exceldata, null, 'A1');
		// $filename='Student_List-'.date('d/m/y').'.xls'; //save our workbook as this file name
		$filename=$excel_name.'.xlsx';//'Student_List-'.date('d/m/y').'.xlsx'; //save our workbook as this file name
		// header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		// $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007'); 
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		//die;
	}
	
} // End of the controller