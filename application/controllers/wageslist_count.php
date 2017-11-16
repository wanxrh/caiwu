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
		$this->per_page = 10000;
		//当前页
	 	$this->cur_page = intval($this->uri->segment(3));
        if ($this->cur_page < 1) {
            $this->cur_page = 1;
        }
		//当前页从第几条数据开始
		$this->offset = ($this->cur_page - 1) * $this->per_page;
	}
	public function index(){
		
		//$zhiyuandaima=$this->data['user_info']['zhiyuandaima'];
		$data['level'] = $this->session->userdata('cat_id');
		$sql = "SELECT COLUMN_NAME,COLUMN_COMMENT,DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_NAME='".$this->_pre.$this->_table."'";
		$columns =  $this->home_model->sqlQueryArray($sql);
		$data['columns'] = array_column($columns,'COLUMN_COMMENT','COLUMN_NAME');
		unset($data['columns']['id'],$data['columns']['user_id'],$data['columns']['nianyue'],$data['columns']['add_time']);
		$dyn = $this->home_model->get_all('dyn_column', array('parent_table'=>$this->_table,'view'=>1));
		$data['dyn'] = array();
		foreach ($dyn as $v){
			$data['dyn'][$v['column_name']] = $v;
            $data['dyn2'][] = $v['column_name'];
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
        $bumen_name = trim( $this->input->get('bumen_name',TRUE) );
		$data['gongzileixing'] = $gongzileixing;
		$data['name'] = $name;
        $data['bumen_name'] = $bumen_name;

		$select = $this->input->get('select',TRUE);
		$input = $this->input->get('input',TRUE);
		$data['select'] = $select;
		$data['input'] = $input;

		$result = $this->home_model->wagesCount($columns,$data['dyn2'],$data['start'],$data['end'],$gongzileixing,$name,$select,$input,$bumen_name);
		$data['list'] = $result['list'];
		$data['rows'] = $result['count'];	
		$url_format = '/WagesList_count/index/%d?' . str_replace('%', '%%', urldecode($_SERVER['QUERY_STRING']));
		$data['page'] = page($this->cur_page, ceil($data['rows'] / $this->per_page), $url_format, 5, FALSE, FALSE,$data['rows']);
				
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
		//$zhiyuandaima=$this->data['user_info']['zhiyuandaima'];
		$data['level'] = $this->session->userdata('cat_id');
		$sql = "SELECT COLUMN_NAME,COLUMN_COMMENT,DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_NAME='".$this->_pre.$this->_table."'";
		$columns =  $this->home_model->sqlQueryArray($sql);
		$data['columns'] = array_column($columns,'COLUMN_COMMENT','COLUMN_NAME');
		unset($data['columns']['id'],$data['columns']['user_id'],$data['columns']['nianyue'],$data['columns']['add_time']);
		$dyn = $this->home_model->get_all('dyn_column', array('parent_table'=>$this->_table));
		$data['dyn'] = array();
		foreach ($dyn as $v){
			$data['dyn'][$v['column_name']] = $v;
            $data['dyn2'][] = $v['column_name'];
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
        $bumen_name = trim( $this->input->get('bumen_name',TRUE) );
		$data['gongzileixing'] = $gongzileixing;
		$data['name'] = $name;
		$data['bumen_name'] = $bumen_name;
		$select = $this->input->get('select',TRUE);
		$input = $this->input->get('input',TRUE);
		$data['select'] = $select;
		$data['input'] = $input;

		$result = $this->home_model->wagesCount($columns,$data['dyn2'],$data['start'],$data['end'],$gongzileixing,$name,$select,$input,$bumen_name);
		$list = $result['list'];
		//统计相同用户的合计
		/*$item=array();
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
		}*/
		if(!empty($list)){
			//查询工资表设置的前台可查看设置
			$str = '';
			$row_user=$this->home_model->get_all('dyn_column',array('parent_table'=>'gongzibiao','view'=>'1'));
			foreach ($row_user as $key => $value) {
				$str .= ','.$value['column_name'].',';
			}
			$sql = "SHOW  full COLUMNS FROM ab22_gongzibiao";
			$rescolumns = $this->home_model->sqlQueryArray($sql);
			
			$filename = "工资列表合计-".date("Y-m-d");
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
		 		//$objPHPExcel->getActiveSheet()->setCellValue('B1', gbktoutf8('部门名字'));
		 		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
				
		    	if($val['Field']!='zhiyuanCode'&&$val['Field']!='zhiyuanleibie'&&$val['Field']!='zhiyuanleibie'&&$val['Field']!='bumenCode'&&$val['Field']!='zhiyuanzhuangtaig'&&$val['Field']!='shenfenCard'&&$val['Field']!='personalCard'){
		    	if(strpos($str,$aaa)!==false){
		    		$ss = $arr[$m];
		    		$c_key =0;
		    		//赋值标题
		    		
				    $objPHPExcel->getActiveSheet()->setCellValue("$ss".'1', gbktoutf8("{$val['Comment']}".'(总)'));
				    $objPHPExcel->getActiveSheet()->getColumnDimension($ss)->setWidth(20);
				
				    //循环每列
				    foreach ($list as $item_key => $em) {
				    	
				        $objPHPExcel->getActiveSheet()->setCellValue("A".($c_key + 2), gbktoutf8("{$em['user_name']}"));
				        //$objPHPExcel->getActiveSheet()->setCellValue("B".($c_key + 2), gbktoutf8("{$em['bumen_name']}"));
				        $objPHPExcel->getActiveSheet()->setCellValue("$ss".($c_key + 2), gbktoutf8($em[$val['Field']]));
				        $c_key++;
				    	
				    }
		    		$m++;
		    	}else{
		    		continue;
		    	}
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
