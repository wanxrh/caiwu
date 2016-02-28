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
	 	$this->cur_page = intval($this->uri->segment(3));
        if ($this->cur_page < 1) {
            $this->cur_page = 1;
        }
		//当前页从第几条数据开始
		$this->offset = ($this->cur_page - 1) * $this->per_page;
	}
	public function index(){
		$data['level'] = $this->session->userdata('cat_id');
		$data['dyn'] = $this->home_model->get_all('dyn_column',array('parent_table'=>$this->_table));
		$sql = "SELECT COLUMN_NAME,COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_NAME='".$this->_pre.$this->_table."'";
		$columns =  $this->home_model->sqlQueryArray($sql);
		$data['columns'] = array_column($columns,'COLUMN_COMMENT','COLUMN_NAME');
		unset($data['columns']['id'],$data['columns']['user_id'],$data['columns']['nianyue'],$data['columns']['add_time']);
		$dyn = $this->home_model->get_all('dyn_column', array('parent_table'=>$this->_table));
		$data['dyn'] = array();
		foreach ($dyn as $v){
			$data['dyn'][$v['column_name']] = $v;
		}
		
		$start = strtotime( $this->input->get('time_from',TRUE) );
		$end = strtotime( $this->input->get('time_to',TRUE) );
		if($end){
			$end = $end+86399;
		}
		$select = $this->input->get('select',TRUE);
		$input = $this->input->get('input',TRUE);
		$result = $this->home_model->wagesList($start,$end,$select,$input);
		$data['list'] = $result['list'];
		$data['rows'] = $result['count'];
		$url_format = '/wageslist/index/%d?' . str_replace('%', '%%', urldecode($_SERVER['QUERY_STRING']));
		$data['page'] = page($this->cur_page, ceil($data['rows'] / $this->per_page), $url_format, 5, FALSE, FALSE,$data['rows']);
		$this->load->view('wages_list',$data);
	}
	
}
