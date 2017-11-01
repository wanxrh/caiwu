<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Get_password extends M_controller{
	/**
	 * [__construct 构造函数]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-15T14:07:28+0800
	 */
	public function __construct()
	{
	    parent::__construct();
		$this->load->model('home_model');
	}
	//修改密码列表
	public function index(){
		$this->load->view('get_password');
	}
	/**
	 * [edit_password 编辑密码]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-29T09:29:36+0800
	 * @return    [type]                   [description]
	 */
	public function edit_password(){
		$data['user_name']=$this->data['user_info']['user_name'];
		if($this->input->post()){
			$password=$this->input->post('password1');
			$password2=$this->input->post('password2');
			$result=$this->home_model->get_one('user_record',array('user_name'=>$data['user_name'],'password'=>$password));
			if($result){
				$res=$this->home_model->update('user_record',array('password'=>$password2),array('user_name'=>$data['user_name'],'password'=>$password));
				if($res){
					showmsg('修改密码成功！2秒后转向列表页','/get_password',0,2000);exit();
				}
			}
		}
	}
}