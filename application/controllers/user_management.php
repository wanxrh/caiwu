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
			$data['row_user']=$this->home_model->get_one('user_record',array('user_id'=>$user_id));
			$sql = "SHOW  full COLUMNS FROM ab22_user_record";
			$data['rescolumns'] = $this->home_model->sqlQueryArray($sql);

			$this->load->view('excel_muban_yonghu',$data);
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
