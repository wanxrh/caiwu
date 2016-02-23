<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends M_controller{
	/**
	 * [__construct 构造函数]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-15T14:07:28+0800
	 */
	public function __construct()
	{
	    parent::__construct();
		$this->load->model('home_model');
		$this->per_page = 50;
        //当前页
        $this->cur_page = $this->uri->segment(1);
        preg_match('/[0-9]+/', "{$this->cur_page}", $arr);
        if (empty($arr)) {
            $arr = array(1);
        }
        $this->cur_page = $arr[0];
        //当前页从第几条数据开始
        $this->offset = ($this->cur_page - 1) * $this->per_page;
	}
	//读取用户列表
	public function index(){
		//查询部门表
		$department=$this->home_model->get_all('bumen',array(),'bumen_name');
		$data['department']=$department;
		//调用model
        $user = $this->home_model->user_list();
        //分页
        $data['rows'] = $user['count'];
        $url_format = '/user-%d/' . str_replace('%', '%%', urldecode($_SERVER['QUERY_STRING']));
        $data['page'] = page($this->cur_page, ceil($data['rows'] / $this->per_page), $url_format, 5, FALSE, FALSE,$data['rows']);
        $data['user'] = $user['user'];
		$this->load->view('user',$data);
	}
	/**
	 * [add_user 增加用户]
	 * @AuthorHTL
	 * @DateTime  2016-02-17T16:03:05+0800
	 */
	public function add_user(){
		$this->load->view('user');
	}
}