<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 工资表字段 管理
 */

class Wages_management extends M_Controller {

	public function __construct()
	{
	    parent::__construct();
		$this->load->model('home_model');
	}
	public function index(){
		$id= $this->uri->segment(3)?$this->uri->segment(3):'-1';
		$user_id = $this->session->userdata('user_id');
		//获取表字段`
		$sql="SHOW  full COLUMNS FROM ab22_gongzibiao";
		$data['cols'] = $this->home_model->sqlQueryArray($sql);
		$data['row_user']=$this->home_model->get_one('user_record',array('user_id'=>$user_id));
		$this->load->view('wages_choose',$data);
	}

	public function edit(){
		$user_id = $this->session->userdata('user_id');
		if($this->input->post()){
			$post =implode(",",$this->input->post('checkbox',TRUE)).',';
			$res = $this->home_model->update('user_record',array('mubanxuanze'=>$post),array('user_id'=>$user_id));

		}else{
			showmsg('请选择参数',"/wages_choose/index",0,2000);exit;
		}
		if($res){
			showmsg('修改成功',"/wages_choose/index",0,2000);exit;
		}else{
			showmsg('修改失败','/wages_choose/index');
		}
	}
	/**
	 * 工资模板导出
	 */
	public function export(){
		$user_id = $this->session->userdata('user_id');
		if($this->input->get('status')=='1'){
			$data['filename'] = "data-".date("Y-m-d H:i:s").".xls";
			$data['flag'] = $this->input->get('flag',TRUE);
			$data['row_user']=$this->home_model->get_one('user_record',array('user_id'=>$user_id));
			$sql = "SHOW  full COLUMNS FROM ab22_gongzibiao";
			$data['rescolumns'] = $this->home_model->sqlQueryArray($sql);

			$this->load->view('excel_muban_gongzi',$data);
		}else{
			$this->load->view('wages_choose');
		}
	}

}
