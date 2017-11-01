<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Database extends M_controller{
	
	public function __construct()
	{
	    parent::__construct();
		$this->load->model('home_model');
	}
	
	public function index(){
		if( strtoupper($_SERVER['REQUEST_METHOD']) == 'POST' ){
			$path = $this->config->item('db_backup');
			$lock = $path.'backup.lock';
			if(!file_exists($path)){
				mkdir($path, 0755, true);
			}
			if( !is_writeable($path) ){
				showmsg('备份目录不存在或不可写，请检查后重试！',base_url().'database',0,2000);
				return;
			}
			if(is_file($lock)){
				showmsg('检测到有一个备份任务正在执行，请稍后再试！',base_url().'database',0,5000);
				return;
			} else {
				//创建锁文件
				file_put_contents($lock, time());
			}
			$this->load->dbutil();
			$backup = $this->dbutil->backup();
			$this->load->helper('file');
			write_file( $path.date('Ymd-His', time()).'.sql.gz', $backup);
			unlink($lock);
			showmsg('备份成功！',base_url().'database/restore',0,2000);
			return;
		}
		$data['list'] = $this->home_model->getTable();
		$this->load->view('database',$data);
	}
	public function restore(){
		$path = $this->config->item('db_backup');
		$flag = FilesystemIterator::KEY_AS_FILENAME;
		$glob = new FilesystemIterator($path,  $flag);
		
		$data['list'] = array();
		foreach ($glob as $name => $file) {
			if(preg_match('/^\d{8,8}-\d{6,6}\.sql(?:\.gz)?$/', $name)){
				$name = sscanf($name, '%4s%2s%2s-%2s%2s%2s-%d');
		
				$date = "{$name[0]}-{$name[1]}-{$name[2]}";
				$time = "{$name[3]}:{$name[4]}:{$name[5]}";
				$part = $name[6];
		
				if(isset($list["{$date} {$time}"])){
					$info = $list["{$date} {$time}"];
					$info['part'] = max($info['part'], $part);
					$info['size'] = $info['size'] + $file->getSize();
				} else {
					$info['part'] = $part;
					$info['size'] = $file->getSize();
				}
				$extension        = strtoupper(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
				$info['compress'] = ($extension === 'SQL') ? '-' : $extension;
				$info['time']     = strtotime("{$date} {$time}");
		
				$data['list']["{$date} {$time}"] = $info;
			}
		}
		$this->load->view('database_restore',$data);
	}
	public function del($time = 0){
		if($time){
			$name  = date('Ymd-His', $time) . '.sql*';
			$path  = $this->config->item('db_backup'). $name;
			array_map("unlink", glob($path));
			if(count(glob($path))){
				showmsg('备份文件删除失败，请检查权限！',base_url().'database/restore',0,2000);
				return;
			} else {
				showmsg('备份文件删除成功！',base_url().'database/restore',0,2000);
				return;
			}
		} else {
			showmsg('参数错误！',base_url().'database/restore',0,2000);
			return;
		}
	}
	public function import($time = 0){
		if($time){
			$name  = date('Ymd-His', $time) . '.sql.gz';
			$path  = $this->config->item('db_backup');		
			$lock = $path.'import.lock';
			if(is_file($lock)){
				showmsg('检测到有一个备份任务正在执行，请稍后再试！',base_url().'database/restore',0,2000);
				return;
			} else {
				//创建锁文件
				file_put_contents($lock, time());
			}	
			$gz   = gzopen($path.$name, 'r');
			$sql  = '';
			$start = 0;
			while (!gzeof($gz)) {
				$sql .= gzgets($gz/* , 4096 */);
				if(preg_match('/.*;$/', trim($sql))){
				 	$this->db->query($sql);
				 	$sql = '';
				}
			}
			unlink($lock);
			showmsg('还原完成！',base_url().'database/restore',0,2000);
		}
	}
}