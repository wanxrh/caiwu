<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 工资表计算合计
 */
class WagesList_count extends M_Controller {
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
		$zhiyuandaima=$this->data['user_info']['zhiyuandaima'];
		$data['level'] = $this->session->userdata('cat_id');
		$sql = "SELECT COLUMN_NAME,COLUMN_COMMENT,DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_NAME='".$this->_pre.$this->_table."'";
		$columns =  $this->home_model->sqlQueryArray($sql);
		$data['columns'] = array_column($columns,'COLUMN_COMMENT','COLUMN_NAME');
		unset($data['columns']['id'],$data['columns']['user_id'],$data['columns']['nianyue'],$data['columns']['add_time']);
		$dyn = $this->home_model->get_all('dyn_column', array('parent_table'=>$this->_table));
		$data['dyn'] = array();
		foreach ($dyn as $v){
			$data['dyn'][$v['column_name']] = $v;
		}
		$data['start'] = $this->input->get('time_from',TRUE)?$this->input->get('time_from',TRUE):date("Y-m",strtotime("-1 month"));

		$data['end'] = $this->input->get('time_to',TRUE)?$this->input->get('time_to',TRUE):date("Y-m",time());

		if($data['end']){
			$data['end'] = $data['end'];
		}
		$columns_count = array();
		foreach ($columns as $key => $val) {
			$columns_count[$val['COLUMN_NAME']] = $val;
		}
		$gongzileixing = trim( $this->input->get('gongzileixing',TRUE) );
		$name = trim( $this->input->get('name',TRUE) );
		$data['gongzileixing'] = $gongzileixing;
		$data['name'] = $name;
		$select = $this->input->get('select',TRUE);
		$input = $this->input->get('input',TRUE);
		$data['select'] = $select;
		$data['input'] = $input;
		$result = $this->home_model->wagesList($data['start'],$data['end'],$gongzileixing,$name,$select,$input,$zhiyuandaima);
		$list = $result['list'];
		//统计相同用户的合计
		$item=array();
		foreach($list as $k=>$v){
		    if(!isset($item[$v['user_id']])){
		        $item[$v['user_id']]=$v;
		    }else{
		    	foreach ($data['dyn'] as $key => $vv) {
		    		if($vv['view']=='1'&& ($columns_count[$vv['column_name']]['DATA_TYPE'] == 'int' || $columns_count[$vv['column_name']]['DATA_TYPE'] == 'float')){
		    			$item[$v['user_id']][$vv['column_name']]+=$v[$vv['column_name']];
		    		}else{
		    			$item[$v['user_id']][$vv['column_name']]=$v[$vv['column_name']];
		    		}
		    	}
			    
			}
		}
		$data['list']=$item;
		$data['rows'] = $result['count'];
		$url_format = '/WagesList_count/index/%d?' . str_replace('%', '%%', urldecode($_SERVER['QUERY_STRING']));
		$data['page'] = page($this->cur_page, ceil($data['rows'] / $this->per_page), $url_format, 5, FALSE, FALSE,$data['rows']);
		//统计
		/*$stat = $this->home_model->dynstat($columns,$data['dyn']);
		$data['dyn_page'] = $stat['dyn_page'];
		$data['dyn_all'] = $stat['dyn_all'];*/

		//职员类型
		$data['gongzi_type'] = $this->home_model->gongziType();
		$this->load->view('wages_list_count',$data);
	}
	public function view(){
		$id = $this->input->get('id',TRUE);
		
		$sql = "SELECT COLUMN_NAME,COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_NAME='".$this->_pre.$this->_table."'";
		$columns =  $this->home_model->sqlQueryArray($sql);
		$data['columns'] = array_column($columns,'COLUMN_COMMENT','COLUMN_NAME');
		unset($data['columns']['id'],$data['columns']['user_id'],$data['columns']['nianyue'],$data['columns']['add_time']);
		$data['dyn'] = $this->home_model->get_all('dyn_column', array('parent_table'=>$this->_table));
		$data['info'] = $this->home_model->wagesView($id);
		
		$this->load->view('wages_view',$data);
	}
	
	
	/**
	 * 导出excel记录
	 */
	public function wage_export(){
		$this->per_page = 5000;
		$zhiyuandaima=$this->data['user_info']['zhiyuandaima'];
		$data['level'] = $this->session->userdata('cat_id');
		$sql = "SELECT COLUMN_NAME,COLUMN_COMMENT,DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_NAME='".$this->_pre.$this->_table."'";
		$columns =  $this->home_model->sqlQueryArray($sql);
		$data['columns'] = array_column($columns,'COLUMN_COMMENT','COLUMN_NAME');
		unset($data['columns']['id'],$data['columns']['user_id'],$data['columns']['nianyue'],$data['columns']['add_time']);
		$dyn = $this->home_model->get_all('dyn_column', array('parent_table'=>$this->_table));
		$data['dyn'] = array();
		foreach ($dyn as $v){
			$data['dyn'][$v['column_name']] = $v;
		}
		
		$start = $this->input->get('time_from',TRUE);
		$end = $this->input->get('time_to',TRUE);
		if($end){
			$end = $end;
		}
		$gongzileixing = trim( $this->input->get('gongzileixing',TRUE) );
		$name = trim( $this->input->get('name',TRUE) );
		$data['gongzileixing'] = $gongzileixing;
		$data['name'] = $name;
		$select = $this->input->get('select',TRUE);
		$input = $this->input->get('input',TRUE);
		$data['select'] = $select;
		$data['input'] = $input;
		$result = $this->home_model->wagesList($start,$end,$gongzileixing,$name,$select,$input,$zhiyuandaima);
		$list = $result['list'];
		if(!empty($list)){
			//查询工资表设置的前台可查看设置
			$str = '';
			$row_user=$this->home_model->get_all('dyn_column',array('parent_table'=>'gongzibiao','view'=>'1'));
			foreach ($row_user as $key => $value) {
				$str .= ','.$value['column_name'].',';
			}
			$sql = "SHOW  full COLUMNS FROM ab22_gongzibiao";
			$rescolumns = $this->home_model->sqlQueryArray($sql);
			
			$filename = "工资列表表-".date("Y-m-d");
			//使用phpexcel插件导出。
			require_once(FR_ROOT.'/application/helpers/PHPExcel.php');
			require_once(FR_ROOT.'/application/helpers/PHPExcel/Writer/Excel2007.php');
			$objPHPExcel = new PHPExcel();
		
		    //直接输出到浏览器
		    $objPHPExcel->getProperties()->setCreator("RCCMS");
		    $objPHPExcel->setActiveSheetIndex(0);
		    //设置sheet的name
		    $objPHPExcel->getActiveSheet()->setTitle(gbktoutf8("工资列表"));
		    //设置单元格的值
	     	$aaa = '';
	     	$m =1;
	     	//调用excel字符串数组
	     	$arr = excel_symbol();
			foreach ($rescolumns as $kk => $val) {
				$aaa=','.$val['Field'].",";
		    	$objPHPExcel->getActiveSheet()->setCellValue('A1', gbktoutf8('姓名'));
		 		$objPHPExcel->getActiveSheet()->setCellValue('B1', gbktoutf8('部门名字'));
		 		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
				
		    	
		    	if(strpos($str,$aaa)!==false){
		    		$ss = $arr[$m+1];
				    $objPHPExcel->getActiveSheet()->setCellValue("$ss".'1', gbktoutf8("{$val['Comment']}"));
				    $objPHPExcel->getActiveSheet()->getColumnDimension($ss)->setWidth(20);
				    for ($i=2; $i <100 ; $i++) { 
				        $objPHPExcel->getActiveSheet()->setCellValue("$ss".$i, ' ');
			        	
			        }
		    		$m++;
		    	}else{
		    		continue;
		    	}
		    	
	        }
	       
		    $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

		    header("Pragma: public");
		    header("Expires: 0");
		    header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
		    header("Content-Type:application/force-download");
		    header("Content-Type:application/vnd.ms-execl");
		    header("Content-Type:application/octet-stream");
		    header("Content-Type:application/download");;
		    header('Content-Disposition:attachment;filename="'.$filename.'.xls"');
		    header("Content-Transfer-Encoding:binary");
		    //渲染导出xls
	    	$objWriter->save('php://output');
		}else{
			showmsg('没有数据','/wageslist');
		}
	}
}
