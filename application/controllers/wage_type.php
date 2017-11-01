<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Wage_type extends M_controller{
	/**
	 * [__construct 构造函数]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-15T14:07:28+0800
	 */
	public function __construct()
	{
	    parent::__construct();
		$this->load->model('home_model');
		$this->per_page = 1;
        //当前页
	 	$this->cur_page = intval($this->uri->segment(3));
        if ($this->cur_page < 1) {
            $this->cur_page = 1;
        }
		//当前页从第几条数据开始
		$this->offset = ($this->cur_page - 1) * $this->per_page;
	}
	//工资类型
	public function index(){
		//查询工资类型表
        $wage = $this->home_model->gongzileixing();
        //分页
        $data['rows'] = $wage['count'];
        $url_format = '/wage_type/index/%d' . str_replace('%', '%%', urldecode($_SERVER['QUERY_STRING']));
        $data['page'] = page($this->cur_page, ceil($data['rows'] / $this->per_page), $url_format, 5, FALSE, FALSE,$data['rows']);
        $data['wage_type'] = $wage['gongzileixing'];
		$this->load->view('wage_type',$data);
	}
	/**
	 * [add 添加工资类别]
	 * @AuthorHTL
	 * @DateTime  2016-02-17T16:03:05+0800
	 */
	public function add(){
		if($this->input->post()!=''){
			$res=$this->home_model->insert('gongzileixing',$this->input->post());
			if($res){ 
				showmsg('添加工资类型成功！2秒后转向列表页','/wage_type',0,2000);exit();
			}
		}
		$this->load->view('wage_type');
	}
	/**
	 * [edit 编辑]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-29T09:29:36+0800
	 * @return    [type]                   [description]
	 */
	public function edit(){
		$gongzileixing_id=$this->uri->segment(3)?$this->uri->segment(3):'-1';
		$data['one'] = $this->home_model->get_one('gongzileixing',array('gongzileixing_id'=>$gongzileixing_id),'*');
		if($this->input->post()!=''){
			$where=array('gongzileixing_id'=>$gongzileixing_id);
			$res=$this->home_model->update('gongzileixing',$this->input->post(),$where);
			if($res){
				showmsg('编辑成功！2秒后返回',"/wage_type/edit/$gongzileixing_id",0,2000);exit();
			}
		}
		$this->load->view('wage_type',$data);
	}
	public function del(){
		$gongzileixing_id=$this->uri->segment(3)?$this->uri->segment(3):'-1';
		$result=$this->home_model->delete('gongzileixing',array('gongzileixing_id'=>$gongzileixing_id));
		if($result){
			showmsg('删除成功！2秒后返回',"/wage_type",0,2000);exit();
		}
	}
}