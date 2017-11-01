<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 用户表管理
 */

class User_information extends M_Controller {

	public function __construct()
	{
	    parent::__construct();
		$this->load->model('home_model');
	}
	public function index(){
		//获取表字段
		$sql="SHOW  full COLUMNS FROM ab22_user_record";
		$data['cols'] = $this->home_model->sqlQueryArray($sql);
		$this->load->view('user_information',$data);
	}
	public function addView(){
		$data['type'] = $this->input->post('type',TRUE);
		$data['field_name'] = $this->input->post('field_name',TRUE);
		$this->load->view('user_information_add',$data);
	}
	public function add(){
		//print_r($_POST);exit;
		$params = $_POST;
		$type = $params['type'];
		$field_name = $params['field_name'];
		unset( $params['type'],$params['field_name'] );
		$str = '';
		$dyn_str = '';
		for ($i=1;$i<=11;$i++){
			if( $params['ziduanming'.$i] ){
				if($params['leixing'.$i] == 'float'){
					$len = 20;
				}else{
					$len = 50;
				} 
				$str .= 'add `'.$params['ziduanming'.$i].'` '.$params['leixing'.$i].'('.$len.') NULL COMMENT "'.$params['beizhu'.$i].'" ';
				switch ($type) {
					case 1:
						$location = ',';
					break;
					case 2:
						$location = ' FIRST,';
					break;
					case 3:
						$location = ' AFTER `'.$field_name.'` ,';
					break;
					default:
						$location = ',';
					break;
				}
				$str .= $location;
				$muban = isset($params['muban'.$i])?1:0;
				
				$dyn_str .="(`parent_table`,`column_name`,`options`,`template`,`view`,`normal_query`,`admin_query`)VALUES('user_record','".trim( $params['ziduanming'.$i] )."','','".$muban."','','',''),";
				
			}			
		}
		$str = "ALTER TABLE  `ab22_user_record` ".substr($str, 0,-1);
		$dyn_str = "INSERT INTO `ab22_dyn_column` ".substr($dyn_str, 0,-1);
		$this->home_model->sqlQuery($str);
		$this->home_model->sqlQuery($dyn_str);
		showmsg('添加成功','/user_information/index');
	}
	public function info(){
		$data['field_name'] = $this->input->get('field_name',TRUE);
		$sql="SELECT COLUMN_NAME, DATA_TYPE, COLUMN_COMMENT from INFORMATION_SCHEMA. COLUMNS Where table_name = 'ab22_user_record' AND column_name like '".$data['field_name']."'";
		$data['row'] = $this->home_model->sqlQueryRow($sql);
		$data['dyn'] = $this->home_model->get_one('dyn_column', array('column_name'=>$data['field_name']));
		$this->load->view('user_information_info',$data);
	}
	public function edit(){
		$field_name = $this->input->post('field_name',TRUE);
		$new_field_name = $this->input->post('ziduanming',TRUE);
		$leixing = $this->input->post('leixing',TRUE);
		$beizhu = $this->input->post('beizhu',TRUE);
		
		if($leixing == 'float'){
			$len = 20;
		}else{
			$len = 50;
		}
		$sql="ALTER TABLE  `ab22_user_record` CHANGE  `".$field_name."`  `".$new_field_name."` ".$leixing."( ".$len." ) NULL DEFAULT NULL COMMENT  '".$beizhu."'";
		$this->home_model->sqlQuery($sql);
		
		showmsg('修改成功','/user_information/index');
	}
	public function del(){
		$field_name = $this->input->get('field_name',TRUE);
		$sql = "alter table ab22_user_record drop `".$field_name."`";
		$this->home_model->sqlQuery($sql);
		showmsg('删除成功','/user_information/index');
	}
}
