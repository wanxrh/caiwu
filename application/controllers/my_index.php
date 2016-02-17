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
        //查询信息
        $c_arr=$this->data['user_info']['user_name'];
        $list=$this->home_model->get_information($c_arr);
        $data['list']=$list;
        $this->load->view('top',$data);
    }

    /*
     * 左边
     */

    public function left() {
        //查询工资类型
        $res=$this->home_model->get_all('gongzileixing');
        $data['leixing']=$res;
        $this->load->view('left',$data);
    }

    /*
     * 右边
     */

    public function right() {
       $this->load->view('right');
    }
}
