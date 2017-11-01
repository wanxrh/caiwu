<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_category extends M_controller{
	/**
	 * [__construct 构造函数]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-15T14:07:28+0800
	 */
	public function __construct()
	{
	    parent::__construct();
		$this->load->model('home_model');
		$this->per_page = 20;
        //当前页
	 	$this->cur_page = intval($this->uri->segment(3));
        if ($this->cur_page < 1) {
            $this->cur_page = 1;
        }
		//当前页从第几条数据开始
		$this->offset = ($this->cur_page - 1) * $this->per_page;
	}
	//读取列表
	public function index(){
		//查询用户类别表
        $user = $this->home_model->category();
        //分页
        $data['rows'] = $user['count'];
        $url_format = '/user_category/index/%d' . str_replace('%', '%%', urldecode($_SERVER['QUERY_STRING']));
        $data['page'] = page($this->cur_page, ceil($data['rows'] / $this->per_page), $url_format, 5, FALSE, FALSE,$data['rows']);
        $data['user_category'] = $user['user_category'];
		$this->load->view('user_category',$data);
	}
	/**
	 * [add 添加用户类别]
	 * @AuthorHTL
	 * @DateTime  2016-02-17T16:03:05+0800
	 */
	public function add(){
		if($this->input->post()!=''){
			$res=$this->home_model->insert('user_cat',$this->input->post());
			if($res){
				showmsg('添加用户类别成功！2秒后转向列表页','/user_category',0,2000);exit();
			}
		}
		$this->load->view('user_category');
	}
	/**
	 * [edit 编辑]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-29T09:29:36+0800
	 * @return    [type]                   [description]
	 */
	public function edit(){
		$cat_id=$this->uri->segment(3)?$this->uri->segment(3):'-1';
		$data['one'] = $this->home_model->get_one('user_cat',array('cat_id'=>$cat_id),'*');
		if($this->input->post()!=''){
			$where=array('cat_id'=>$cat_id);
			$res=$this->home_model->update('user_cat',$this->input->post(),$where);
			if($res){
				showmsg('编辑成功！2秒后返回',"/user_category/edit/$cat_id",0,2000);exit();
			}
		}
		$this->load->view('user_category',$data);
	}
	public function del(){
		$cat_id=$this->uri->segment(3)?$this->uri->segment(3):'-1';
		$result=$this->home_model->delete('user_cat',array('cat_id'=>$cat_id));
		if($result){
			showmsg('删除成功！2秒后返回',"/user_category",0,2000);exit();
		}
	}
}