<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 工资表字段 管理
 */

class Wages_management extends M_Controller {

	public function __construct()
	{
	    parent::__construct();
		$this->load->model('home_model');
	}
	public function index(){
		$id= $this->uri->segment(3)?$this->uri->segment(3):'-1';
		$user_id = $this->session->userdata('user_id');
		//获取表字段`
		$sql="SHOW  full COLUMNS FROM ab22_gongzibiao";
		$data['cols'] = $this->home_model->sqlQueryArray($sql);
		//$data['row_user']=$this->home_model->get_one('user_record',array('user_id'=>$user_id));
        $dyn_column =$this->home_model->get_all('dyn_column',array('parent_table'=>'gongzibiao'));
        //$str = '';
        //foreach($dyn_column as $key=>$item){
        //    $str .= ','.$item['column_name'].',';
        //}
        $data['dyn_column'] = $dyn_column;
		$this->load->view('wages_choose',$data);
	}

	public function edit(){
		$user_id = $this->session->userdata('user_id');
		if($this->input->post()){
            // 先把所有的都标0
            $this->db->where(array('parent_table'=>'gongzibiao','column_name !='=>'gongzileixing'));
            $this->db->where(array('column_name !='=>'nianyue'));
            $this->db->update('dyn_column',array('template'=>0));
            $this->db->affected_rows();
            $post = $this->input->post('checkbox',TRUE);
            $this->db->where(array('parent_table'=>'gongzibiao'));
            $this->db->where_in('id',$post);
            $res = $this->db->update('dyn_column',array('template'=>1));
            //echo $this->db->last_query();exit;
		}else{
			showmsg('请选择参数',"/wages_management/index",0,2000);exit;
		}
		if($res){
			showmsg('修改成功',"/wages_management/index",0,2000);exit;
		}else{
			showmsg('修改失败','/wages_management/index');
		}
	}
	/**
	 * 工资模板导出
	 */
	public function export(){
		$user_id = $this->session->userdata('user_id');
		if($this->input->get('status')=='1'){
			$data['filename'] = "date-".date("Y-m-d").'.xls';
			$data['flag'] = $this->input->get('flag',TRUE);
			//查询工资表设置的导出模版设置
			$str = '';
			$row_user=$this->home_model->get_all('dyn_column',array('parent_table'=>'gongzibiao','template'=>'1'));
			//$row_user=$this->home_model->get_one('ab22_user_record',array('user_id'=>$user_id));
            //$row_user_chose = $row_user['mubanxuanze'];
			foreach ($row_user as $key => $value) {
				$str .= ','.$value['column_name'].',';
			}
			$sql = "SHOW  full COLUMNS FROM ab22_gongzibiao";
			$rescolumns = $this->home_model->sqlQueryArray($sql);
			
			$filename = "工资表模板-".date("Y-m-d");
			//使用phpexcel插件导出。
			require_once(FR_ROOT.'/application/helpers/PHPExcel.php');
			require_once(FR_ROOT.'/application/helpers/PHPExcel/Writer/Excel2007.php');
			$objPHPExcel = new PHPExcel();
		
		    //直接输出到浏览器
		    $objPHPExcel->getProperties()->setCreator("RCCMS");
		    $objPHPExcel->setActiveSheetIndex(0);
		    //设置sheet的name
		    $objPHPExcel->getActiveSheet()->setTitle(gbktoutf8("工资表"));
		    //设置单元格的值
	     	$aaa = '';
	     	$m =1;
	     	//调用excel字符串数组
	     	$arr = excel_symbol();
			foreach ($rescolumns as $kk => $val) {
				$aaa=','.$val['Field'].",";
		    	$objPHPExcel->getActiveSheet()->setCellValue('A1', gbktoutf8('姓名'));
		 		$objPHPExcel->getActiveSheet()->setCellValue('B1', gbktoutf8('部门名称'));
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
		//$this->load->view('excel_muban_gongzi',$data);
		}else{
			$this->load->view('wages_choose');
		}
	}
	/**
	 * 工资模板导入
	 */
	public function import(){
		header("Content-Type: text/html; charset=utf-8");
		if(!empty($_POST)){



			$file = pathinfo($_FILES['MyFile']['name']);
			if($file['extension']!='xls'&&$file['extension']!='xlsx') echo "<script>alert('选择的文件不是excel格式');</script>";//判断是不是excel格式
			$save_path = $_SERVER['DOCUMENT_ROOT'].'/upload/'; 
			$fname = $save_path. time().'.'.$file['extension'];
			$do = copy($_FILES['MyFile']['tmp_name'],$fname);
			if(!$do){
				showmsg('导入错误',"/wages_management/import",0,10000);exit;
			}
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('UTF-8');
			$data->read($fname);
			error_reporting(E_ALL ^ E_NOTICE);
            //事物开启
            $this->db->trans_begin();
            try{
                //sheet1
                if($data->sheets[0]['numRows']){
                    $a1="";
                    $a2="";
                    $b1="";
                    $col_n = '';
                    for($j=1;$j<=$data->sheets[0]['numCols'];$j++){
                        if(empty($data->sheets[0]['cells'][1][$j])){
                             showmsg('模板不正确',"/wages_management/import",0,10000);exit;
                        }
                        //获取表字段
                        $sql="SHOW  full COLUMNS FROM ab22_gongzibiao";
                        $res = $this->home_model->sqlQueryArray($sql);
                        $flag= 1;
                        foreach ($res as $key => $row) {
                            if(!empty($row['Comment']==$data->sheets[0]['cells'][1][$j]) && !empty($data->sheets[0]['cells'][1][$j])){
                                $flag= 2;
                                $a1.=$row['Field'].",";
                                $b1.=$row['Field']."='".trim($j)."*****',";
                                //if($data->sheets[0]['cells'][1][$j]=="职员姓名"){ $col_n=$j;}
                            }
                        }
                        if($data->sheets[0]['cells'][1][$j] == '姓名' || $data->sheets[0]['cells'][1][$j] == '职员姓名' || $data->sheets[0]['cells'][1][$j] == '部门名字'){
                            $flag = 2;
                        }
                        if($flag== 1){
                            showmsg("模版中存在错误的字段(".$data->sheets[0]['cells'][1][$j].")!","/wages_management/import",1,15000);exit;
                        }

                    }
                $col_name=1;
                $col_bumen_name=2;
                $a1=substr($a1,0,-1);
                $b1=substr($b1,0,-1);
                $flag=1;
                for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++){
                    if(empty($data->sheets[0][cells][$i][$col_name])) continue;
                    $name=$data->sheets[0][cells][$i][$col_name];
                    $bumen = $data->sheets[0][cells][$i][$col_bumen_name];
                    $r_user = $this->home_model->get_one('user_record',array('name'=>$name));

                    //$r_bumen = $this->home_model->get_one('bumen',array('bumen_id'=>$r_user['bumen_id']));
                    if(empty($r_user)){
                        showmsg('不存的用户('.$name,")/wages_management/import",0,15000);exit;
                    }
                    if(!empty($name) && empty($r_user)){
                        $flag=2;
                        if($name){
                            $msg.=",".$name;
                        }

                    }

                }
                if($flag==2){
                    $msg="拒绝导入，还缺少(".$msg.")的数据";
                    showmsg("$msg","/wages_management/import",0,15000);exit;
                }
                for ($ii = 2; $ii <= $data->sheets[0]['numRows']; $ii++){//下面有备份
                    $name=$data->sheets[0][cells][$ii][$col_name];
                    $r_panduan = $this->home_model->get_one('user_record',array('user_name'=>$name));
                    if($r_panduan=='') {continue;}
                    $bumen_name=$data->sheets[0][cells][$ii][$col_bumen_name];
                    //$r_user=$db->get_row("select * from ab22_user_record where name='$name' and bumen_id='$bumen_id'");//匹配部门
                    $r_user = $this->home_model->get_one('user_record',array('user_name'=>$name));//不匹配部门
                    $user_id=$r_user['user_id'];
                        $s="";
                        if(!empty($user_id)){
                            $s1="";
                            $k="";
                            $s2=$b1;
                            for($jj=3;$jj<=$data->sheets[0]['numCols'];$jj++){
                                if(empty($data->sheets[0]['cells'][1][$jj])) continue;
                                 if($data->sheets[0]['cells'][1][$jj]=='工资年月'){
                                     if(strpos($data->sheets[0]['cells'][$ii][$jj],"/")){
                                         $s1.="'".date("Y-m",strtotime(str_replace("/","-",trim($data->sheets[0]['cells'][$ii][$jj]))))."',";
                                     }elseif(strpos($data->sheets[0]['cells'][$ii][$jj],"-")){
                                         $s1.="'".date("Y-m",strtotime(trim($data->sheets[0]['cells'][$ii][$jj])))."',";
                                     }else{
                                         $s1.="'".date("Y-m",strtotime(str_replace("年","-",trim($data->sheets[0]['cells'][$ii][$jj]))))."',";
                                     }
                                 }else{
                                    $s1.="'".trim($data->sheets[0]['cells'][$ii][$jj])."',";
                                 }
                                $m="'".$jj."*****";
                                if($data->sheets[0]['cells'][$ii][$jj]){//update数据表，替换$j*****
                                    //if($data->sheets[0]['cells'][1][$jj]=='工资年月') {
                                    //    if (strpos($data->sheets[0]['cells'][$ii][$jj], "/")) {
                                    //        $s2= $data->sheets[0]['cells'][$ii][$jj] = str_replace("/", "-", $data->sheets[0]['cells'][$ii][$jj]);
                                    //    } else {
                                    //        $s2= $data->sheets[0]['cells'][$ii][$jj] = str_replace("年", "-", $data->sheets[0]['cells'][$ii][$jj]);
                                    //    }
                                    //}else{
                                        $s2=str_replace($m,"'".$data->sheets[0]['cells'][$ii][$jj],$s2);
                                    //}
                                }else{
                                    $s2=str_replace($m,"'",$s2);
                                }

                            }
                            //echo $s1;exit;
                            //echo "<br>";
                            //echo $s2;exit;
                            $add_time = time();
                            if($data->sheets[0][cells][$ii][$col_name]!=NUll){
                                $s1=substr($s1,0,-1);
                                if(strpos($a1,"user_id")===false){
                                    $sql1="insert into ab22_gongzibiao(".$a1.",user_id,add_time) values(".$s1.",$user_id,$add_time)";
                                }else{
                                    $sql1="insert into ab22_gongzibiao(".$a1.",add_time) values(".$s1.",$add_time)";
                                }
                                $this->home_model->sqlQuery($sql1);
                            }else{
                                //$sql2="update ab22_gongzibiao set ".$s2.",bumen_id='$bumen_id' where user_name='$user_name'";
                                //$this->home_model->sqlQuery($sql2);
                            }
                        }


                }
                    $this->db->trans_commit();
                    showmsg('导入成功','/wages_management/import',0,2000);exit();
                }else{
                    showmsg('模版格式有误,请按照导出模版的格式导入数据。','/wages_manasgement/import',0,5000);exit();
                }
            }catch (Exception $e){
                //失败回滚
                $this->db->trans_rollback();
                showmsg('导入失败','/wages_manasgement/import',0,2000);exit();
            }
		}
		$this->load->view('wages_import');
	}
}
