<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 用户表字段 管理
 */

class User_management extends M_Controller {

	public function __construct()
	{
	    parent::__construct();
		$this->load->model('home_model');
	}
	public function index(){
		$id= $this->uri->segment(3)?$this->uri->segment(3):'-1';
		$user_id = $this->session->userdata('user_id');
		//获取表字段`
		$sql="SHOW  full COLUMNS FROM ab22_user_record";
		$data['cols'] = $this->home_model->sqlQueryArray($sql);
		$data['row_user']=$this->home_model->get_one('user_record',array('user_id'=>$user_id));
		$this->load->view('wages_choose',$data);
	}

	public function edit(){
		$user_id = $this->session->userdata('user_id');
		if($this->input->post()){
			$post =','.implode(",",$this->input->post('checkbox',TRUE)).',';
			$res = $this->home_model->update('user_record',array('mubanxuanze1'=>$post),array('user_id'=>$user_id));

		}else{
			showmsg('请选择参数',"/user_management/index",0,2000);exit;
		}
		if($res){
			showmsg('修改成功',"/user_management/index",0,2000);exit;
		}else{
			showmsg('修改失败','/user_management/index');
		}
	}
	/**
	 * 用户模板导出
	 */
	public function export(){
		$user_id = $this->session->userdata('user_id');
		if($this->input->get('status')=='1'){
			$data['filename'] = "user-".date("Y-m-d").'.xls';
			$data['flag'] = $this->input->get('flag',TRUE);
			$str = '';
			//$row_user=$this->home_model->get_all('dyn_column',array('parent_table'=>'user_record','template'=>'1'));
			$row_user=$this->home_model->get_one('user_record',array('user_id'=>$user_id));
			foreach ($row_user as $key => $value) {
				$str .= ','.$value['column_name'].',';
			}
			$sql = "SHOW  full COLUMNS FROM ab22_user_record";
			$rescolumns = $this->home_model->sqlQueryArray($sql);

			$filename = "用户表模板-".date("Y-m-d");
			//使用phpexcel插件导出。
			require_once(FR_ROOT.'/application/helpers/PHPExcel.php');
			require_once(FR_ROOT.'/application/helpers/PHPExcel/Writer/Excel2007.php');
			$objPHPExcel = new PHPExcel();
		
		    //直接输出到浏览器
		    $objPHPExcel->getProperties()->setCreator("RCCMS");
		    $objPHPExcel->setActiveSheetIndex(0);
		    //设置sheet的name
		    $objPHPExcel->getActiveSheet()->setTitle(gbktoutf8("用户表"));
		    //设置单元格的值
	     	$aaa = '';
	     	$m =1;
	     	//调用excel字符串数组
	     	$arr = excel_symbol();
			foreach ($rescolumns as $kk => $val) {
				$aaa=','.$val['Field'].",";
		    	$objPHPExcel->getActiveSheet()->setCellValue('A1', gbktoutf8('姓名'));
		 		$objPHPExcel->getActiveSheet()->setCellValue('B1', gbktoutf8('部门名字'));
		 		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
				
		    	
		    	if(strpos($str,$aaa)!==false){
		    		$ss = $arr[$m+1];
				    $objPHPExcel->getActiveSheet()->setCellValue("$ss".'1', gbktoutf8("{$val['Comment']}"));
				    $objPHPExcel->getActiveSheet()->getColumnDimension($ss)->setWidth(20);
				    for ($i=2; $i <100 ; $i++) { 
				        $objPHPExcel->getActiveSheet()->setCellValue("$ss".$i, ' ');
			        	
			        }
		    		$m++;
		    	}else{
		    		continue;
		    	}
		    	
	        }
	       
		    $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

		    header("Pragma: public");
		    header("Expires: 0");
		    header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
		    header("Content-Type:application/force-download");
		    header("Content-Type:application/vnd.ms-execl");
		    header("Content-Type:application/octet-stream");
		    header("Content-Type:application/download");;
		    header('Content-Disposition:attachment;filename="'.$filename.'.xls"');
		    header("Content-Transfer-Encoding:binary");
		    //渲染导出xls
	    	$objWriter->save('php://output');
			//$this->load->view('excel_muban_yonghu',$data);
		}else{
			$this->load->view('wages_choose');
		}
	}
	/**
	 * 用户模板导入
	 */
	public function import(){
		if($this->input->post()){
			showmsg('正在开发中','/user_management/import');exit;
		}
		$this->load->view('wages_import');
	}
}
