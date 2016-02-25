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
		//部门
		$bumen=	empty($this->input->get('bumen', TRUE)) ? '' : $this->input->get('bumen', TRUE);
		//关键字
        $name = empty($this->input->get('name', TRUE)) ? '' : $this->input->get('name', TRUE);
		//查询部门表
		$department=$this->home_model->get_all('bumen',array(),'bumen_name,bumen_id');
		$data['department']=$department;
		//调用model
        $user = $this->home_model->user_list($bumen,$name);
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
		//查询用户类别
		$type=$this->home_model->user_type();
		$data['type']=$type;
		//查询部门
		$department=$this->home_model->get_all('bumen',array(),'*');
		$data['department']=$department;
		//查询用户表字段属性
		$rescolumns=$this->home_model->user_field();
		$data['rescolumns']=$rescolumns;
		if($this->input->post()!=''){
			$res=$this->home_model->insert('user_record',$this->input->post());
			if($res){
				showmsg('添加用户成功！2秒后转向列表页','/user',0,2000);exit();
			}
		}
		$this->load->view('user',$data);
	}
}