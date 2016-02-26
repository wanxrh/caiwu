<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 工资表管理
 */
class WagesList extends M_Controller {
	private $_pre = 'ab22_';
	private $_table = 'gongzibiao';
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
	public function index(){
		$data['dyn'] = $this->home_model->get_all('dyn_column',array('parent_table'=>$this->_table));
		$sql = "SELECT COLUMN_NAME,COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_NAME='".$this->_pre.$this->_table."'";
		$columns =  $this->home_model->sqlQueryArray($sql);
		$data['columns'] = array_column($columns,'COLUMN_COMMENT','COLUMN_NAME');
		unset($data['columns']['id'],$data['columns']['user_id'],$data['columns']['nianyue'],$data['columns']['add_time']);
		$this->load->view('wages_list',$data);
	}
	
}
