<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {
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
        $user_id = $this->session->userdata('user_id');
        if (!empty($user_id)) {
            echo "<script language='javascript'>window.location.href='/my_index';</script>";
            exit;
        }
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

		if(strtolower($this->input->post('code')) !=$this->input->cookie("verification")){
			get_redirect('验证码错误','/');exit;
		}
		$arr =array('user_name'=>$this->input->post('user_name'),'password'=>$this->input->post('password'));
		$res =$this->home_model->get_one('user_record',$arr,'user_id,cat_id,user_name,name');
		if($res){
			$sess=array(
				'user_id'   =>$res['user_id'],
				'user_name' =>$res['user_name'],
				'name'      =>$res['name'],
				'cat_id'    =>$res['cat_id']
				);
			$this->session->set_userdata($sess);
			showmsg('登录成功，2秒后转向会员中心！',base_url().'my_index',0,2000);exit();
		}else{
			get_redirect('用户名或密码错误','/');exit;
		}
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
		if(strtolower($this->input->post('param'))==$this->input->cookie("verification")){
			exit(json_encode(array('status'=>'y','info'=>'正确！')));
		}else{
			exit(json_encode(array('status'=>'n','info'=>'验证码错误')));
		}

	}
	public function logout(){
		$sess=array(
				'user_id'   =>'',
				'user_name' =>''
				);
		$this->session->unset_userdata($sess);
		showmsg('退出成功，1秒后转向首页！',base_url(),0,1000);exit();
	}
}
