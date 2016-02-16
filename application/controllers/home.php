<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends M_Controller {
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
	/**
	 * [index 登录页]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-15T14:08:52+0800
	 */
	public function index()
	{
		//每访问一次+1访问量
		$this->home_model->update_access();
		//查询总访问量
		$number=$this->home_model->get_one('dianji',array('id'=>1),'number');
		$data['number']=$number['number'];
		$this->load->view('home',$data);
	}
	/**
	 * [login 登录]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-15T16:25:54+0800
	 * @return    [type]                   [description]
	 */
	public function login(){

	}
	/**
	 * [code 验证码]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-15T14:08:13+0800
	 */
	public function code(){
		$this->load->library('Vcode');
		$this->vcode->str_code();
	}
	/**
	 * AJAX校验验证码
	 */
	public function Validcode(){
		if($this->input->post('param')==$this->input->cookie("verification")){
			exit(json_encode(array('status'=>'y','info'=>'正确！')));
		}else{
			exit(json_encode(array('status'=>'n','info'=>'验证码错误')));
		}
		
	}
}
