<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class System_notice extends M_controller{
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
	//读取公告列表
	public function index(){
		//用户信息
		$data['user_info']=$this->data['user_info'];
		//调用model
        $news = $this->home_model->notice();
        //分页
        $data['rows'] = $news['count'];
        $url_format = '/news-%d/' . str_replace('%', '%%', urldecode($_SERVER['QUERY_STRING']));
        $data['page'] = page($this->cur_page, ceil($data['rows'] / $this->per_page), $url_format, 5, FALSE, FALSE,$data['rows']);
        $data['news'] = $news['news'];
		$this->load->view('system_notice',$data);
	}
	/**
	 * [add_user 增加公告]
	 * @AuthorHTL
	 * @DateTime  2016-02-17T16:03:05+0800
	 */
	public function add(){
		//用户信息
		$data['user_info']=$this->data['user_info'];
		if($this->input->post()!=''){
			$time=time();
			$res=array(
				'cat_id'=>$this->input->post('cat_id'),
				'title' =>$this->input->post('title'),
				'content'=>$this->input->post('content'),
				'add_time'=>$time
				);
			$res=$this->home_model->insert('news',$res);
			if($res){
				showmsg('添加公告成功！2秒后转向列表页','/system_notice',0,2000);exit();
			}
		}
		$this->load->view('system_notice',$data);
	}
	/**
	 * [edit_user 编辑公告]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-29T09:29:36+0800
	 * @return    [type]                   [description]
	 */
	public function edit(){
		//用户信息
		$data['user_info']=$this->data['user_info'];
		$news_id=$this->uri->segment(3)?$this->uri->segment(3):'-1';
		//根据id查询公告信息
		$data['news']=$this->home_model->noticeList($news_id);
		if($this->input->post()!=''){
			$where=array('news_id'=>$news_id);
			$res=$this->home_model->update('news',$this->input->post(),$where);
			if($res){
				showmsg('编辑成功！2秒后返回',"/system_notice/edit/$news_id",0,2000);exit();
			}
		}
		$this->load->view('system_notice',$data);
	}
	public function del(){
		$news_id=$this->uri->segment(3)?$this->uri->segment(3):'-1';
		$result=$this->home_model->delete('news',array('news_id'=>$news_id));
		if($result){
			showmsg('删除成功！2秒后返回',"/system_notice",0,2000);exit();
		}
	}
	public function view(){
		//用户信息
		$data['user_info']=$this->data['user_info'];
		$news_id=$this->uri->segment(3)?$this->uri->segment(3):'-1';
		$data['news_view']=$this->home_model->noticeList($news_id);
		$this->load->view('system_notice',$data);
	}
}