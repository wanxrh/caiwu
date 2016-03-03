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
		$this->per_page = 20;
        //当前页
	 	$this->cur_page = intval($this->uri->segment(3));
        if ($this->cur_page < 1) {
            $this->cur_page = 1;
        }
		//当前页从第几条数据开始
		$this->offset = ($this->cur_page - 1) * $this->per_page;
	}
	//读取部门列表
	public function index(){
		//查询部门表
        $department = $this->home_model->bumen();
        //分页
        $data['rows'] = $department['count'];
        $url_format = '/department/index/%d' . str_replace('%', '%%', urldecode($_SERVER['QUERY_STRING']));
        $data['page'] = page($this->cur_page, ceil($data['rows'] / $this->per_page), $url_format, 5, FALSE, FALSE,$data['rows']);
        $data['department'] = $department['department'];
		$this->load->view('department',$data);
	}
	/**
	 * [add 添加部门]
	 * @AuthorHTL
	 * @DateTime  2016-02-17T16:03:05+0800
	 */
	public function add(){
		if($this->input->post()!=''){
			$res=$this->home_model->insert('bumen',$this->input->post());
			if($res){
				showmsg('添加部门成功！2秒后转向列表页','/department',0,2000);exit();
			}
		}
		$this->load->view('department');
	}
	/**
	 * [edit 编辑]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-29T09:29:36+0800
	 * @return    [type]                   [description]
	 */
	public function edit(){
		$bumen_id=$this->uri->segment(3)?$this->uri->segment(3):'-1';
		$data['one'] = $this->home_model->get_one('bumen',array('bumen_id'=>$bumen_id),'*');
		if($this->input->post()!=''){
			$where=array('bumen_id'=>$bumen_id);
			$res=$this->home_model->update('bumen',$this->input->post(),$where);
			if($res){
				showmsg('编辑成功！2秒后返回',"/department/edit/$bumen_id",0,2000);exit();
			}
		}
		$this->load->view('department',$data);
	}
	public function del(){
		$bumen_id=$this->uri->segment(3)?$this->uri->segment(3):'-1';
		$result=$this->home_model->delete('bumen',array('bumen_id'=>$bumen_id));
		if($result){
			showmsg('删除成功！2秒后返回',"/department",0,2000);exit();
		}
	}
}