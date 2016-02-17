<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 我的工资模型
 */
class My_index extends M_Controller {
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
	public function index(){
		$this->load->view('my_index');
	}
	/*
     * 顶部
     */

    public function top() {
        $c_arr=array('user_name'=>$this->data['user_info']['user_name']);
        $c_name=$this->home_model->get_information($c_arr);
        $data['cat_name']=$c_name['cat_name'];
        $this->load->view('top',$data);
    }

    /*
     * 左边
     */

    public function left() {
        //$user_id = get_admin();
        //$data = $this->home_model->level_id($user_id);
        $this->load->view('left');
    }

    /*
     * 右边
     */

    public function right() {
       $this->load->view('right');
    }
}
