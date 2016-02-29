<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Department extends M_controller{
	/**
	 * [__construct 构造函数]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-15T14:07:28+0800
	 */
	public function __construct()
	{
	    parent::__construct();
		$this->load->model('home_model');
		$this->per_page = 100;
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
	//读取部门列表
	public function index(){
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
	/**
	 * [edit_user 编辑用户]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-29T09:29:36+0800
	 * @return    [type]                   [description]
	 */
	public function edit_user(){
		$data['user_info']=$this->data['user_info'];
		$user_id=$this->uri->segment(3)?$this->uri->segment(3):'-1';
		//查询用户类别
		$data['type']=$this->home_model->user_type();
		//根据id查询用户信息
		$data['user']=$this->home_model->userList($user_id);

		//查询用户表字段属性
		$rescolumns=$this->home_model->user_field();
		$data['rescolumns']=$rescolumns;
		//查询部门
		$department=$this->home_model->get_all('bumen',array(),'*');
		$data['department']=$department;

		if($this->input->post()!=''){
			$where=array('user_id'=>$user_id);
			$res=$this->home_model->update('user_record',$this->input->post(),$where);
			if($res){
				showmsg('编辑成功！2秒后返回',"/user/edit_user/$user_id",0,2000);exit();
			}
		}
		$this->load->view('user',$data);
	}
	public function remove_user(){
		$user_id=$this->uri->segment(3)?$this->uri->segment(3):'-1';
		$result=$this->home_model->delete('user_record',array('user_id'=>$user_id));
		if($result){
			showmsg('删除成功！2秒后返回',"/user",0,2000);exit();
		}
	}
}