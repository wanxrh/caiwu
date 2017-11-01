<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 工资列表模板
 */

class Salary_template extends M_Controller {

	public function __construct()
	{
	    parent::__construct();
		$this->load->model('home_model');
	}
	public function index(){
		$id= $this->uri->segment(3)?$this->uri->segment(3):'-1';
		//获取表字段
		$sql="SHOW  full COLUMNS FROM ab22_gongzibiao";
		$data['cols'] = $this->home_model->sqlQueryArray($sql);
		$data['type'] = $this->home_model->get_one('gongzileixing',array('gongzileixing_id'=>$id));
		$this->load->view('salary_template',$data);
	}

	public function edit(){
		$id = $this->input->post('gongzileixing_id',TRUE);
		$post =implode(",",$this->input->post('checkbox',TRUE)).',';
		$res = $this->home_model->update('gongzileixing',array('ziduan_list'=>$post),array('gongzileixing_id'=>$id));
		if($res){
			showmsg('修改成功',"/salary_template/index/$id",0,2000);exit;
		}else{
			showmsg('修改失败','/salary_template/index');
		}
	}

}
