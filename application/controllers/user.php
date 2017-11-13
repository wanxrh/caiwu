<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends M_controller{
    private $_pre = 'ab22_';
    private $_table = 'user_record';
	/**
	 * [__construct 构造函数]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-15T14:07:28+0800
	 */
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
	//读取用户列表
	public function index(){
		$data['user_info']=$this->data['user_info'];
		//部门
		$bumen=	empty($this->input->get('bumen', TRUE)) ? '' : $this->input->get('bumen', TRUE);
		//关键字
        $name = empty($this->input->get('name', TRUE)) ? '' : $this->input->get('name', TRUE);
		//查询部门表
		$department=$this->home_model->get_all('bumen',array(),'bumen_name,bumen_id');
		$data['department']=$department;
		//调用model
        $user = $this->home_model->user_list($bumen,$name);
        //分页
        $data['rows'] = $user['count'];
        $url_format = '/user-%d/' . str_replace('%', '%%', urldecode($_SERVER['QUERY_STRING']));
        $data['page'] = page($this->cur_page, ceil($data['rows'] / $this->per_page), $url_format, 5, FALSE, FALSE,$data['rows']);
        $data['user'] = $user['user'];
		$this->load->view('user',$data);
	}
	/**
	 * [add_user 增加用户]
	 * @AuthorHTL
	 * @DateTime  2016-02-17T16:03:05+0800
	 */
	public function add_user(){
		//查询用户类别
		$type=$this->home_model->user_type();
		$data['type']=$type;
		//查询部门
		$department=$this->home_model->get_all('bumen',array(),'*');
		$data['department']=$department;
		//查询用户表字段属性
		$rescolumns=$this->home_model->user_field();
		$data['rescolumns']=$rescolumns;
		if($this->input->post()!=''){
			$res=$this->home_model->insert('user_record',$this->input->post());
			if($res){
				showmsg('添加用户成功！2秒后转向列表页','/user',0,2000);exit();
			}
		}
		$this->load->view('user',$data);
	}
	/**
	 * [edit_user 编辑用户]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-29T09:29:36+0800
	 * @return    [type]                   [description]
	 */
	public function edit_user(){
		$data['user_info']=$this->data['user_info'];
		$user_id=$this->uri->segment(3)?$this->uri->segment(3):'-1';
		//查询用户类别
		$data['type']=$this->home_model->user_type();
		//根据id查询用户信息
		$data['user']=$this->home_model->userList($user_id);

		//查询用户表字段属性
		$rescolumns=$this->home_model->user_field();
		$data['rescolumns']=$rescolumns;
		//查询部门
		$department=$this->home_model->get_all('bumen',array(),'*');
		$data['department']=$department;

		if($this->input->post()!=''){
			$where=array('user_id'=>$user_id);
			$res=$this->home_model->update('user_record',$this->input->post(),$where);
			if($res){
				showmsg('编辑成功！2秒后返回',"/user/edit_user/$user_id",0,2000);exit();
			}
		}
		$this->load->view('user',$data);
	}
	public function remove_user(){
		$user_id=$this->uri->segment(3)?$this->uri->segment(3):'-1';
		$result=$this->home_model->delete('user_record',array('user_id'=>$user_id));
		if($result){
			showmsg('删除成功！2秒后返回',"/user",0,2000);exit();
		}
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
        unset($data['columns']['user_id'],$data['columns']['cat_id'],$data['columns']['bumen_id']);
        $dyn = $this->home_model->get_all('dyn_column', array('parent_table'=>$this->_table));
        $data['dyn'] = array();
        foreach ($dyn as $v){
            $data['dyn'][$v['column_name']] = $v;
        }

        $name = trim( $this->input->get('name',TRUE) );
        $data['name'] = $name;
        $select = $this->input->get('bumen',TRUE);
        $data['select'] = $select;
        $result = $this->home_model->uList($columns,$data['dyn'],$name,$select,$zhiyuandaima);
        $list = $result['list'];
        //print_r($list);exit;
        if(!empty($list)){
            //查询用户表设置的前台可查看设置
            $str = '';
            $row_user=$this->home_model->get_all('dyn_column',array('parent_table'=>'user_record','view'=>'1'));
            foreach ($row_user as $key => $value) {
                $str .= ','.$value['column_name'].',';
            }
            $sql = "SHOW  full COLUMNS FROM ab22_user_record";
            $rescolumns = $this->home_model->sqlQueryArray($sql);

            $filename = "用户列表-".date("Y-m-d");
            //使用phpexcel插件导出。
            require_once(FR_ROOT.'/application/helpers/PHPExcel.php');
            require_once(FR_ROOT.'/application/helpers/PHPExcel/Writer/Excel2007.php');
            $objPHPExcel = new PHPExcel();

            //直接输出到浏览器
            $objPHPExcel->getProperties()->setCreator("RCCMS");
            $objPHPExcel->setActiveSheetIndex(0);
            //设置sheet的name
            $objPHPExcel->getActiveSheet()->setTitle(gbktoutf8("用户列表"));
            //设置单元格的值
            $aaa = '';
            $m =1;
            //调用excel字符串数组
            $arr = excel_symbol();
            foreach ($rescolumns as $kk => $val) {
                $aaa=','.$val['Field'].",";
                $objPHPExcel->getActiveSheet()->setCellValue('A1', gbktoutf8('账号'));
                $objPHPExcel->getActiveSheet()->setCellValue('B1', gbktoutf8('密码'));
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);


                if(strpos($str,$aaa)!==false){
                    $ss = $arr[$m+1];
                    //赋值标题
                    $objPHPExcel->getActiveSheet()->setCellValue("$ss".'1', gbktoutf8("{$val['Comment']}"));
                    $objPHPExcel->getActiveSheet()->getStyle($ss)->getNumberFormat()
                        ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                    $objPHPExcel->getActiveSheet()->getColumnDimension($ss)->setWidth(20);;
                    //循环每列
                    foreach ($list as $item_key => $item) {
                        $objPHPExcel->getActiveSheet()->setCellValue("A".($item_key + 2), gbktoutf8("{$item['user_name']}"));
                        $objPHPExcel->getActiveSheet()->setCellValue("B".($item_key + 2), gbktoutf8("{$item['password']}"));
                        if(is_numeric($item[$val['Field']]) && strlen($item[$val['Field']])>15){
                            $item[$val['Field']] = "'".$item[$val['Field']];
                        }
                        $objPHPExcel->getActiveSheet()->setCellValue("$ss".($item_key + 2), gbktoutf8($item[$val['Field']]));
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