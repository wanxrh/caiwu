<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 用户表字段 管理
 */

class User_management extends M_Controller {

	public function __construct()
	{
	    parent::__construct();
		$this->load->model('home_model');
	}
	public function index(){
		$id= $this->uri->segment(3)?$this->uri->segment(3):'-1';
		$user_id = $this->session->userdata('user_id');
		//获取表字段`
		$sql="SHOW  full COLUMNS FROM ab22_user_record";
		$data['cols'] = $this->home_model->sqlQueryArray($sql);
		//$data['row_user']=$this->home_model->get_one('user_record',array('user_id'=>$user_id));
        $dyn_column = $this->home_model->get_all('dyn_column',array('parent_table'=>'user_record','template'=>1));
        //$str = '';
        //foreach($dyn_column as $key=>$item){
        //    $str .= $item['column_name'].',';
        //}
        $data['dyn_column'] = $dyn_column;
		$this->load->view('wages_choose',$data);
	}

	public function edit(){
		$user_id = $this->session->userdata('user_id');
		if($this->input->post()){
			$post =','.implode(",",$this->input->post('checkbox',TRUE)).',';
			$res = $this->home_model->update('user_record',array('mubanxuanze1'=>$post),array('user_id'=>$user_id));

		}else{
			showmsg('请选择参数',"/user_management/index",0,2000);exit;
		}
		if($res){
			showmsg('修改成功',"/user_management/index",0,2000);exit;
		}else{
			showmsg('修改失败','/user_management/index');
		}
	}
	/**
	 * 用户模板导出
	 */
	public function export(){
		$user_id = $this->session->userdata('user_id');
		if($this->input->get('status')=='1'){
			$data['filename'] = "user-".date("Y-m-d").'.xls';
			$data['flag'] = $this->input->get('flag',TRUE);
			$str = '';
			$row_user=$this->home_model->get_all('dyn_column',array('parent_table'=>'user_record','template'=>'1'));
			//$row_user=$this->home_model->get_one('user_record',array('user_id'=>$user_id));
            //$str = $row_user['mubanxuanze1'];
			foreach ($row_user as $key => $value) {
				$str .= ','.$value['column_name'].',';
			}
			$sql = "SHOW  full COLUMNS FROM ab22_user_record";
			$rescolumns = $this->home_model->sqlQueryArray($sql);

			$filename = "用户表模板-".date("Y-m-d");
			//使用phpexcel插件导出。
			require_once(FR_ROOT.'/application/helpers/PHPExcel.php');
			require_once(FR_ROOT.'/application/helpers/PHPExcel/Writer/Excel2007.php');
			$objPHPExcel = new PHPExcel();
		
		    //直接输出到浏览器
		    $objPHPExcel->getProperties()->setCreator("RCCMS");
		    $objPHPExcel->setActiveSheetIndex(0);
		    //设置sheet的name
		    $objPHPExcel->getActiveSheet()->setTitle(gbktoutf8("用户表"));
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
				    $objPHPExcel->getActiveSheet()->setCellValue("$ss".'1', gbktoutf8("{$val['Comment']}"));
				    $objPHPExcel->getActiveSheet()->getColumnDimension($ss)->setWidth(20);
				    for ($i=2; $i <20 ; $i++) { 
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
			//$this->load->view('excel_muban_yonghu',$data);
		}else{
			$this->load->view('wages_choose');
		}
	}
	/**
	 * 用户模板导入
	 */
	public function import(){
		if($this->input->post()){
			$file = pathinfo($_FILES['MyFile']['name']);
			if($file['extension']!='xls'&&$file['extension']!='xlsx') echo "<script>alert('选择的文件不是excel格式');</script>";//判断是不是excel格式
			$save_path = $_SERVER['DOCUMENT_ROOT'].'/upload/'; 
			$fname = $save_path. time().'.'.$file['extension'];
			$do = copy($_FILES['MyFile']['tmp_name'],$fname);
			if(!$do){
				showmsg('导入错误',"/user_management/import",0,1000);exit;
			}
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('UTF-8');
			$data->read($fname);
			error_reporting(E_ALL ^ E_NOTICE);
            //事物开启
            $this->db->trans_begin();
            try{
			//sheet1
			    if($data->sheets[0]['numRows']&&$data->sheets[0]['cells']!=''){
				$a1="";
				$a2="";
				$b1="";
				$col_n = '';
                $bumen_s = '';
				for($j=1;$j<=$data->sheets[0]['numCols'];$j++){
					if(empty($data->sheets[0]['cells'][1][$j])){
						 showmsg('模板不正确',"/user_management/import",0,1000);exit;
					}
                    if(trim($data->sheets[0]['cells'][1][$j]) == '部门代码'){
                        //$r_bumen = $this->home_model->get_one('bumen',array('bumen_daima'=>trim($data->sheets[0]['cells'][1][$j])));
                        $bumen_s = $j;
                    }
					//获取表字段
					$sql="SHOW  full COLUMNS FROM ab22_user_record";
					$res = $this->home_model->sqlQueryArray($sql);
					foreach ($res as $key => $row) {
						if(!empty($row['Comment']) && $row['Comment'] == trim($data->sheets[0]['cells'][1][$j]) && !empty($data->sheets[0]['cells'][1][$j])){
							$a1.=$row['Field'].",";
							$b1.=$row['Field']."='".$j."*****',";
						}
					}

				}
			$col_name=1;
			$col_bumen_name=2;
            if(!empty($bumen_s)){
                $a1.= 'bumen_id,';
            }
			$a1=substr($a1,0,-1);
			$b1=substr($b1,0,-1);
			$flag=1;
		
			for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++){//下面有备份
			
					$s="";
					if($i==2){
						for($j=1;$j<=$data->sheets[0]['numCols'];$j++){
							$flag='1';
							//获取表字段
							$sql="SHOW  full COLUMNS FROM ab22_user_record";
							$res = $this->home_model->sqlQueryArray($sql);
							foreach ($res as $key => $row) {
								if($row['Comment']==$data->sheets[1]['cells'][$i][$j]){
									$flag='2';
								}
							}
							if($flag=='1'){
								showmsg("模版中存在错误的字段".$data->sheets[0]['cells'][$i][$j]."!","/user_management/import",0,1000);exit;
							} 
						}
					}//else if(!empty($user_id)){
					$s1="";
					$k="";
					$s2=$b1;
					for($j=1;$j<=$data->sheets[0]['numCols'];$j++){
						$s1.="'".trim($data->sheets[0]['cells'][$i][$j])."',";
						$m="'".$j."*****";
						if($data->sheets[0]['cells'][$i][$j]){//update数据表，替换$j*****
							
							$s2=str_replace($m,"'".$data->sheets[0]['cells'][$i][$j],$s2);
						}else{
							$s2=str_replace($m,"'",$s2);
						}
                        if(!empty($bumen_s)){
                            $bumen_code= $data->sheets[0]['cells'][$i][$bumen_s];
                            $r_bumen = $this->home_model->get_one('bumen',array('bumen_daima'=>$bumen_code));
                            if(empty($r_bumen)){
                                showmsg("部门代码".$data->sheets[0]['cells'][$i][$j]."不存在","/user_management/import",0,1000);exit;
                            }
                        }
					}

					/*echo $s1;
					echo "<br>";
					echo $s2;exit;*/
					if($data->sheets[0][cells][$i][$col_name]!=NUll){
                        if(!empty($r_bumen)){
                            $s1.= "'".$r_bumen['bumen_id']."',";
                        }
						$s1=substr($s1,0,-1);
					 	$sql1="insert into ab22_user_record(".$a1.",cat_id2) values(".$s1.",'9')";

						$this->home_model->sqlQuery($sql1);
					}
					
			}
			}
                $this->db->trans_commit();
            }catch (Exception $e){
                //失败回滚
                $this->db->trans_rollback();
            }
			showmsg('导入成功','/user_management/import',0,2000);exit();
		}
		$this->load->view('wages_import');
	}
}
