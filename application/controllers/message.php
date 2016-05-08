<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Message extends M_controller{
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
        $this->cur_page = $this->uri->segment(1);
        preg_match('/[0-9]+/', "{$this->cur_page}", $arr);
        if (empty($arr)) {
            $arr = array(1);
        }
        $this->cur_page = $arr[0];
        //当前页从第几条数据开始
        $this->offset = ($this->cur_page - 1) * $this->per_page;
	}
	//读取留言列表
	public function index(){
		//调用model
        $message = $this->home_model->getMessage();
        //分页
        $data['rows'] = $message['count'];
        $url_format = '/message-%d/' . str_replace('%', '%%', urldecode($_SERVER['QUERY_STRING']));
        $data['page'] = page($this->cur_page, ceil($data['rows'] / $this->per_page), $url_format, 5, FALSE, FALSE,$data['rows']);
        $data['message'] = $message['message'];
		$this->load->view('message',$data);
	}
	/**
	 * [edit_user 编辑留言]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-29T09:29:36+0800
	 * @return    [type]                   [description]
	 */
	public function edit(){
		$user_id=$this->uri->segment(3)?$this->uri->segment(3):'-1';
		//根据id查询公告信息
		$data['liuyan']=$this->home_model->messageList($user_id);
		if($this->input->post()!=''){
			$where=array('user_id'=>$user_id);
			$res=$this->home_model->update('liuyan',$this->input->post(),$where);
			if($res){
				showmsg('编辑成功！2秒后返回',"/message/edit/$user_id",0,2000);exit();
			}
		}
		$this->load->view('message',$data);
	}
	public function del(){
		$user_id=$this->uri->segment(3)?$this->uri->segment(3):'-1';
		$result=$this->home_model->delete('liuyan',array('user_id'=>$user_id));
		if($result){
			showmsg('删除成功！2秒后返回',"/message",0,2000);exit();
		}
	}
	public function view(){
		$liuyan_id=$this->uri->segment(3)?$this->uri->segment(3):'-1';
		$data['message_view']=$this->home_model->messageList($liuyan_id);
		$this->load->view('message',$data);
	}
}