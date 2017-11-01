<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 工资表管理
 */

class WagesManage extends M_Controller {

	public function __construct()
	{
	    parent::__construct();
		$this->load->model('home_model');
	}
	public function index(){
		//获取表字段
		$sql="SHOW  full COLUMNS FROM ab22_gongzibiao";
		$data['cols'] = $this->home_model->sqlQueryArray($sql);
		$this->load->view('wages_manage',$data);
	}
	public function addView(){
		$data['type'] = $this->input->post('type',TRUE);
		$data['field_name'] = $this->input->post('field_name',TRUE);
	
		$this->load->view('wages_addview',$data);
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
					$len = '20,2';
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
				$chakan = isset($params['chakan'.$i])?1:0;
				$qianchaxun = isset($params['qianchaxun'.$i])?1:0;
				$houchaxun = isset($params['houchaxun'.$i])?1:0;
				$summary = isset($params['summary'.$i])?1:0;
				$dyn_str .="(`parent_table`,`column_name`,`options`,`template`,`view`,`normal_query`,`admin_query`,`summary`)VALUES('gongzibiao','".trim( $params['ziduanming'.$i] )."','".$params['xuanxiang'.$i]."','".$muban."','".$chakan."','".$qianchaxun."','".$houchaxun."','".$summary."'),";
				
			}			
		}
		$str = "ALTER TABLE  `ab22_gongzibiao` ".substr($str, 0,-1);
		$dyn_str = "INSERT INTO `ab22_dyn_column` ".substr($dyn_str, 0,-1);
		$this->home_model->sqlQuery($str);
		$this->home_model->sqlQuery($dyn_str);
		showmsg('添加成功','/wagesmanage/index');
	}
	public function info(){
		$data['field_name'] = $this->input->get('field_name',TRUE);
		//错误
		$sql="Select COLUMN_NAME , DATA_TYPE , COLUMN_COMMENT from INFORMATION_SCHEMA. COLUMNS Where table_name = 'ab22_gongzibiao'  AND column_name LIKE '".$data['field_name']."'";
		//$sql="Select COLUMN_NAME , DATA_TYPE , COLUMN_COMMENT from INFORMATION_SCHEMA.COLUMNS Where table_name = 'ab22_gongzibiao' AND column_name LIKE '".$data['field_name']."'";
		$data['row'] = $this->home_model->sqlQueryRow($sql);
		$data['dyn'] = $this->home_model->get_one('dyn_column', array('column_name'=>$data['field_name']));
		
		$this->load->view('wages_info',$data);
	}
	public function edit(){
		$field_name = $this->input->post('field_name',TRUE);
		$new_field_name = $this->input->post('ziduanming',TRUE);
		$leixing = $this->input->post('leixing',TRUE);
		$beizhu = $this->input->post('beizhu',TRUE);
		$xuanxiang = $this->input->post('xuanxiang',TRUE);
		$muban = $this->input->post('muban',TRUE)?1:0;
		$chakan = $this->input->post('chakan',TRUE)?1:0;
		$qianchaxun = $this->input->post('qianchaxun',TRUE)?1:0;
		$houchaxun = $this->input->post('houchaxun',TRUE)?1:0;
		$summary = $this->input->post('summary',TRUE)?1:0;
		if($leixing == 'float'){
			$len = '20,2';
		}else{
			$len = 50;
		}
		$sql="ALTER TABLE  `ab22_gongzibiao` CHANGE  `".$field_name."`  `".$new_field_name."` ".$leixing."( ".$len." ) NULL DEFAULT NULL COMMENT  '".$beizhu."'";
		$this->home_model->sqlQuery($sql);
		
		$data = array(
			'column_name'=>$new_field_name,
			'options'=>$xuanxiang,
			'template'=>$muban,
			'view'=>$chakan,
			'normal_query'=>$qianchaxun,
			'admin_query'=>$houchaxun,
			'summary' =>$summary
		);
		$this->home_model->update('dyn_column', $data , array('column_name'=>$field_name));
		showmsg('修改成功','/wagesmanage/index');
	}
	public function del(){
		$field_name = $this->input->get('field_name',TRUE);
		$sql = "alter table ab22_gongzibiao drop `".$field_name."`";
		$this->home_model->sqlQuery($sql);
		$this->home_model->delete('dyn_column', array('column_name'=>$field_name));
		showmsg('删除成功','/wagesmanage/index');
	}
}
