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
		$zhiyuandaima=$this->data['user_info']['zhiyuandaima'];
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
		$gongzileixing = trim( $this->input->get('gongzileixing',TRUE) );
		$name = trim( $this->input->get('name',TRUE) );
		$bumen_id = trim( $this->input->get('bumen_id',TRUE) );
		$data['gongzileixing'] = $gongzileixing;
		$data['name'] = $name;
		$data['bumen_id'] = $bumen_id;
		$select = $this->input->get('select',TRUE);
		$input = $this->input->get('input',TRUE);
		$data['select'] = $select;
		$data['input'] = $input;
		$result = $this->home_model->wagesList($columns,$data['dyn'],$data['start'],$data['end'],$gongzileixing,$name,$select,$input,$zhiyuandaima,$bumen_id);
		$data['list'] = $result['list'];
		$data['rows'] = $result['count'];
		$url_format = '/wageslist/index/%d?' . str_replace('%', '%%', urldecode($_SERVER['QUERY_STRING']));
		$data['page'] = page($this->cur_page, ceil($data['rows'] / $this->per_page), $url_format, 5, FALSE, FALSE,$data['rows']);
		//统计
		$data['dyn_page'] = $result['dyn_page'];
		$data['dyn_all'] = $result['dyn_all'];

		//职员类型
		$data['gongzi_type'] = $this->home_model->gongziType();
        //查询部门
        $department=$this->home_model->get_all('bumen',array(),'*');
        $data['department']=$department;
		$this->load->view('wages_list',$data);
	}
	public function view(){
		$id = $this->input->get('id',TRUE);
		
		$sql = "SELECT COLUMN_NAME,COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_NAME='".$this->_pre.$this->_table."'";
		$columns =  $this->home_model->sqlQueryArray($sql);
		$data['columns'] = array_column($columns,'COLUMN_COMMENT','COLUMN_NAME');
		unset($data['columns']['id'],$data['columns']['user_id'],$data['columns']['nianyue'],$data['columns']['add_time']);
		$data['dyn'] = $this->home_model->get_all('dyn_column', array('parent_table'=>$this->_table));
		$data['info'] = $this->home_model->wagesView($id);
        foreach ($data['dyn'] as $v){
            $data['dyn2'][] = $v['column_name'];
        }
		$this->load->view('wages_view',$data);
	}
	public function edit(){
		$id = $this->input->get('id',TRUE);
		
		$sql = "SELECT COLUMN_NAME,COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_NAME='".$this->_pre.$this->_table."'";
		$columns =  $this->home_model->sqlQueryArray($sql);
		$data['columns'] = array_column($columns,'COLUMN_COMMENT','COLUMN_NAME');
		unset($data['columns']['id'],$data['columns']['user_id'],$data['columns']['nianyue'],$data['columns']['add_time']);
		$data['dyn'] = $this->home_model->get_all('dyn_column', array('parent_table'=>$this->_table));
		$data['info'] = $this->home_model->wagesView($id);
		$data['gongzi_type'] = $this->home_model->gongziType();
		if( strtoupper($_SERVER['REQUEST_METHOD']) == 'POST' ){
			$parm = $this->input->post(NULL,TRUE);
			$id = $parm['id'];
			unset($parm['id']);
			$row = $this->home_model->update('gongzibiao', $parm, array('id'=>$id));
			if($row) showmsg('更新成功','/wageslist/index');
			return;
		}
		$this->load->view('wages_edit',$data);
	}
	public function del(){
		$id = $this->input->get('id',TRUE);
		if(!$id) return FALSE;
		$row = $this->home_model->delete('gongzibiao', array('id'=>$id));
		if($row) showmsg('删除成功','/wageslist/index');
	}
    //批量删除
    public function delall(){

        $ids = $this->input->post('ids',TRUE);
        if(!$ids) return FALSE;
        $ids = explode(',',$ids);
        $row = $this->home_model->deleteAll('gongzibiao',$ids);
        if($row){
        echo json_encode(array('info'=>'ok','删除成功'));exit;
        }
        //if($row) showmsg('删除成功','/wageslist/index');
    }
	/**
	 * 添加工资记录
	 */
	public function add(){
		if( strtoupper($_SERVER['REQUEST_METHOD']) == 'POST' ){
			$parm = $this->input->post(NULL,TRUE);
            $parm['add_time'] = time();
			$row = $this->home_model->insert('gongzibiao', $parm);
			if($row) showmsg('添加成功','/user');
			return;
		}else{
            $data['user_id'] = $this->input->get('id',TRUE);
            $user = $this->home_model->get_one('user_record',array('user_id'=>$data['user_id']));
            $data['zhiyuandaima'] = $user['zhiyuandaima'];
            $sql = "SELECT COLUMN_NAME,COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_NAME='".$this->_pre.$this->_table."'";
            $columns =  $this->home_model->sqlQueryArray($sql);
            $data['columns'] = array_column($columns,'COLUMN_COMMENT','COLUMN_NAME');
            unset($data['columns']['id'],$data['columns']['user_id'],$data['columns']['nianyue'],$data['columns']['add_time']);
            $data['dyn'] = $this->home_model->get_all('dyn_column', array('parent_table'=>$this->_table));
            $data['gongzi_type'] = $this->home_model->gongziType();
        }
		$this->load->view('wages_add',$data);
	}
	/**
	 * 查看用户工资记录
	 */
	public function viewlist(){
		$user_id=$this->input->get('id','');
		$sql = "SELECT COLUMN_NAME,COLUMN_COMMENT,DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_NAME='".$this->_pre.$this->_table."'";
		$columns =  $this->home_model->sqlQueryArray($sql);
		$data['columns'] = array_column($columns,'COLUMN_COMMENT','COLUMN_NAME');
		unset($data['columns']['id'],$data['columns']['user_id'],$data['columns']['nianyue'],$data['columns']['add_time']);
		$dyn = $this->home_model->get_all('dyn_column', array('parent_table'=>$this->_table));
		$data['dyn'] = array();
		foreach ($dyn as $v){
			$data['dyn'][$v['column_name']] = $v;
		}
		
		$result = $this->home_model->wagesViewList($user_id);
		$data['list'] = $result['list'];
		$data['rows'] = $result['count'];
		$url_format = '/wageslist/viewlist/%d?' . str_replace('%', '%%', urldecode($_SERVER['QUERY_STRING']));
		$data['page'] = page($this->cur_page, ceil($data['rows'] / $this->per_page), $url_format, 5, FALSE, FALSE,$data['rows']);
		//职员类型
		$data['gongzi_type'] = $this->home_model->gongziType();

		$this->load->view('wages_viewlist',$data);
		
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
		$data['start'] = $this->input->get('time_from',TRUE)?$this->input->get('time_from',TRUE):date("Y-m",strtotime("-1 month"));

		$data['end'] = $this->input->get('time_to',TRUE)?$this->input->get('time_to',TRUE):date("Y-m",time());

		if($data['end']){
			$data['end'] = $data['end'];
		}
		$gongzileixing = trim( $this->input->get('gongzileixing',TRUE) );
		$name = trim( $this->input->get('name',TRUE) );
        $bumen_id = trim( $this->input->get('bumen_id',TRUE) );
		$data['gongzileixing'] = $gongzileixing;
		$data['name'] = $name;
		$data['bumen_id'] = $bumen_id;
		$select = $this->input->get('select',TRUE);
		$input = $this->input->get('input',TRUE);
		$data['select'] = $select;
		$data['input'] = $input;
		$result = $this->home_model->wagesList($columns,$data['dyn'],$data['start'],$data['end'],$gongzileixing,$name,$select,$input,$zhiyuandaima,$bumen_id);
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
		    		//赋值标题
				    $objPHPExcel->getActiveSheet()->setCellValue("$ss".'1', gbktoutf8("{$val['Comment']}"));
                    $objPHPExcel->getActiveSheet()->getStyle($ss)->getNumberFormat()
                        ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				    $objPHPExcel->getActiveSheet()->getColumnDimension($ss)->setWidth(20);
				    //循环每列
				    foreach ($list as $item_key => $item) {
                        $res = $item[$val['Field']];
                        if(is_numeric($res)){
                            $res = (string)$res;
                            if(strpos($res,'0')===false){

                            }elseif(strpos($res,'0')=='0' && strpos($res,'.')===false){
                                $res = "'".$res;
                            }
                        }
				        $objPHPExcel->getActiveSheet()->setCellValue("A".($item_key + 2), gbktoutf8("{$item['user_name']}"));
				        $objPHPExcel->getActiveSheet()->setCellValue("B".($item_key + 2), gbktoutf8("{$item['bumen_name']}"));
				        $objPHPExcel->getActiveSheet()->setCellValue("$ss".($item_key + 2), gbktoutf8("{$res}"));
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
