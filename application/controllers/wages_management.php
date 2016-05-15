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
		$data['row_user']=$this->home_model->get_one('user_record',array('user_id'=>$user_id));
		$this->load->view('wages_choose',$data);
	}

	public function edit(){
		$user_id = $this->session->userdata('user_id');
		if($this->input->post()){
			$post =','.implode(",",$this->input->post('checkbox',TRUE)).',';
			$res = $this->home_model->update('user_record',array('mubanxuanze'=>$post),array('user_id'=>$user_id));

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
			$data['row_user']=$this->home_model->get_one('user_record',array('user_id'=>$user_id));
			$sql = "SHOW  full COLUMNS FROM ab22_gongzibiao";
			$data['rescolumns'] = $this->home_model->sqlQueryArray($sql);

			$this->load->view('excel_muban_gongzi',$data);
		}else{
			$this->load->view('wages_choose');
		}
	}
	/**
	 * 工资模板导入
	 */
	public function import(){
		//xls 的编码是gbk32
		header("Content-Type: text/html; charset=utf-8");
		if($this->input->post()){
			$file = pathinfo($_FILES['MyFile']['name']);
			if($file['extension']!='xls'&&$file['extension']!='xlsx') echo "<script>alert('选择的文件不是excel格式');</script>";//判断是不是excel格式
			$save_path = $_SERVER['DOCUMENT_ROOT'].'/upload/'; 
			$fname = $save_path. time().'.'.$file['extension'];
			$do = copy($_FILES['MyFile']['tmp_name'],$fname);
			if(!$do){
				showmsg('导入错误',"/wages_management/import",0,1000);exit;
			}
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('UTF-8');
			$data->read($fname);
			error_reporting(E_ALL ^ E_NOTICE);

			//sheet1
			if($data->sheets[0]['numRows']){
				$a1="";
				$a2="";
				$b1="";
				$col_nianyue = '';
			for($j=1;$j<=$data->sheets[0]['numCols'];$j++){
				if(!$data->sheets[0]['cells'][1][$j]) showmsg('模板不正确',"/wages_management/import",0,1000);
				//获取表字段
				$sql="SHOW  full COLUMNS FROM ab22_gongzibiao";
				$res = $this->home_model->sqlQueryArray($sql);
				foreach ($res as $key => $row) {
					if($row['Comment']==$data->sheets[0]['cells'][1][$j]&&$data->sheets[0]['cells'][1][$j]){
						$a1.=$row['Field'].",";
						$b1.=$row['Field']."='".$j."*****',";
						if($data->sheets[0]['cells'][1][$j]=="工资年月"){ $col_nianyue=$j;}
					}
				}

			}
			if(!$col_nianyue) showmsg('模板不正确',"/wages_management/import",0,1000);
			$col_name=1;
			$col_bumen_name=2;
			$a1=substr($a1,0,-1);
			$b1=substr($b1,0,-1);
			$flag=1;
			for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++){
				$name=$data->sheets[0][cells][$i][$col_name];
				//$r_panduan=$db->get_row("select * from ab22_user_record where name='$name'");
				//if(!$r_panduan) continue;
				//$r_user=$db->get_row("select * from ab22_user_record where name='$name' and bumen_id='$bumen_id'");//匹配部门
				$r_user = $this->home_model->get_one('user_record',array('name'=>$name));
				//$r_user=$db->get_row("select * from ab22_user_record where name='$name'");//不匹配部门
				
				if($name&&!$r_user){
					$flag=2;
					if($name){
						$msg.=",".$name;
					}
					
				}

			}
			if($flag==2){
				$msg="拒绝导入，还缺少".$msg."的数据";
				showmsg("$msg","/wages_management/import",0,1000);
			}

			for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++){//下面有备份
				$name=$data->sheets[0][cells][$i][$col_name];
				$r_panduan = $this->home_model->get_one('user_record',array('name'=>$name));
				if(!$r_panduan) continue;
				$bumen_name=$data->sheets[0][cells][$i][$col_bumen_name];
				//$r_user=$db->get_row("select * from ab22_user_record where name='$name' and bumen_id='$bumen_id'");//匹配部门
				$r_user = $this->home_model->get_one('user_record',array('name'=>$name));//不匹配部门
				$user_id=$r_user['user_id'];
					
					$s="";
					if($i==1){
						for($j=1;$j<=$data->sheets[0]['numCols'];$j++){
							$flag='1';
							//获取表字段
							$sql="SHOW  full COLUMNS FROM ab22_gongzibiao";
							$res = $this->home_model->sqlQueryArray($sql);
							foreach ($res as $key => $row) {
								if($row['Comment']=$data->sheets[0]['cells'][$i][$j]){
									$flag='2';
								}
							}
							if($flag=='1') showmsg("模版中存在错误的字段".$data->sheets[0]['cells'][$i][$j]."!","/wages_management/import",0,1000);
						}
					}else if($user_id){
						$s1="";
						$k="";
						$s2=$b1;
						for($j=3;$j<=$data->sheets[0]['numCols'];$j++){
							if($j==$col_nianyue){
								//$s1.="'".str_replace("/","-",$data->sheets[0]['cells'][$i][$j])."',";
								//$s1.="'".strtotime(str_replace("年","-",$data->sheets[0]['cells'][$i][$j]))."',";
								$s1.="'".$data->sheets[0]['cells'][$i][$j]."',";
							}else{
								$s1.="'".$data->sheets[0]['cells'][$i][$j]."',";
							}
							$m="'".$j."*****";
							if($data->sheets[0]['cells'][$i][$j]){//update数据表，替换$j*****
								
								$s2=str_replace($m,"'".$data->sheets[0]['cells'][$i][$j],$s2);
							}else{
								$s2=str_replace($m,"'",$s2);
							}
							
							//$sql2="update ab22_gongzibiao set ".$s2." where user_name='$id'";
							//$row=$db->get_row("select * from ab22_gongzibiao where user_name='$user_name'");
							
						}
						/*echo $s1;
						echo "<br>";
						echo $s2;exit;*/
						
						if(1){
							$s1=substr($s1,0,-1);
							if(strpos($a1,"user_id")===false){
								$sql1="insert into ab22_gongzibiao(".$a1.",user_id) values(".$s1.",$user_id)";
							}else{
							 	$sql1="insert into ab22_gongzibiao(".$a1.") values(".$s1.")";
							}
							$this->home_model->sqlQuery($sql1);
						}else{
							
							$sql2="update ab22_gongzibiao set ".$s2.",bumen_id='$bumen_id' where user_name='$user_name'";
							$this->home_model->sqlQuery($sql2);
						}
					}
					//$s=substr($s,2);
					//$db->query("insert into ab17_shujv(cat_id,content,add_time) values('$id','$s','$add_time')");

					
			}
			}
			showmsg('导入成功','/wages_management/import',0,2000);exit();
		}
		$this->load->view('wages_import');
	}
}
