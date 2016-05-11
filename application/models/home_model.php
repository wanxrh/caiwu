<?php

/**
 * 首页模型
 * @author lin
 * @version 2016-02
 */
class Home_model extends Common_model {

	/**
	 * 继承父级构造方法
	 * 实例化两个数据库方法
	 */
	public function __construct() {
		parent::__construct();
	}
	/**
	 * [update_access 增加访问量数据]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-15T14:38:08+0800
	 * @return    [type]                   [返回影响行数]
	 */
	public function update_access(){
		$this->db->set('number', 'number+1',FALSE);
		$this->db->where(array('id'=>1))->update('dianji');
		$data=$this->db->affected_rows();
        return $data;
	}
	/**
	 * [get_information 关联表获取用户信息]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-16T16:25:26+0800
	 * @return    [type]                   [description]
	 */
	public function get_information($where){
		$sql="SELECT a.cat_id as g,b.cat_id as y,a.bumen_id as p,cat_name,c.bumen_name FROM `ab22_user_record` a LEFT JOIN `ab22_user_cat` b ON a.cat_id=b.cat_id LEFT JOIN `ab22_bumen` c  ON a.bumen_id=c.bumen_id WHERE `user_name` =  '$where'";
        $result=$this->db->query($sql)->row_array();
        return $result;
	}
	/**
	 * [user_list 用户列表]
	 * @AuthorHTL
	 * @DateTime  2016-02-23T09:10:47+0800
	 * @return    [type]                   [description]
	 */
	public function user_list($bumen_id,$keyword){

		if ($bumen_id !== '') {
            $this->db->where('user_record.bumen_id', $bumen_id);
        }
		//关键字搜索
        if ($keyword !== '') {
            $sql = "(`name` like '%{$keyword}%')";
            $this->db->where($sql);
        }
        $temp = clone $this->db;
		$data['count'] = $this->db->select('user_cat.*,bumen.*,user_id,user_name,password,name')->join('user_cat', 'user_record.cat_id=user_cat.cat_id', 'left')->join('bumen', 'bumen.bumen_id=user_record.bumen_id', 'left')->from('user_record')->count_all_results();
		$this->db = $temp;
        $data['user'] = $this->db->select('user_cat.*,bumen.*,user_id,user_name,password,name')->join('user_cat', 'user_cat.cat_id=user_record.cat_id', 'left')->join('bumen', 'bumen.bumen_id=user_record.bumen_id', 'left')->get('user_record', $this->per_page, $this->offset)->result_array();
        //echo $this->db->last_query();
        return $data;
	}
	public function user_field(){
		$sql="SHOW  full COLUMNS FROM ab22_user_record where Comment!=''";
		$result=$this->db->query($sql)->result_array();
		return $result;
	}
	public function user_type(){
		return $this->db->select('*')->get('user_cat')->result_array();

	}
	public function sqlQuery($sql){
		return $this->db->query($sql);
	}
	public function sqlQueryRow($sql){
		return $this->db->query($sql)->row_array();
		//echo $this->db->last_query();exit;

	}
	public function sqlQueryArray($sql){
		return $this->db->query($sql)->result_array();
	}
	public function dynstat($columns,$dyn){
		$ret = array();
		$unset = array('id','user_id','nianyue','add_time');
		foreach ($columns as $k => $v){
			if(in_array($v['COLUMN_NAME'],$unset)){				
				continue;
			}
			if(isset($dyn[$v['COLUMN_NAME']])){
				if(!$dyn[$v['COLUMN_NAME']]['options'] && $dyn[$v['COLUMN_NAME']]['view'] && ( $v['DATA_TYPE'] == 'int' || $v['DATA_TYPE'] == 'float' ) ){
				
					$nums = $this->db->select($v['COLUMN_NAME'])->get('gongzibiao',$this->per_page, $this->offset)->result_array();
					$ret['dyn_page'][$v['COLUMN_NAME']] = array_sum(array_column($nums,$v['COLUMN_NAME']) );
				
					$alls = $this->db->select_sum($v['COLUMN_NAME'])->get('gongzibiao')->row_array();
					$ret['dyn_all'][$v['COLUMN_NAME']] = $alls[$v['COLUMN_NAME']];
				
				}else{
					$ret['dyn_page'][$v['COLUMN_NAME']] = '';
					$ret['dyn_all'][$v['COLUMN_NAME']] = '';
				}
			}				
		}
		return $ret;
	}
	public function wagesList($start,$end,$gongzileixing,$name,$select,$input){
		if($start && !$end){
			$this->db->where('gongzibiao.nianyue >=',$start);
		}elseif (!$start && $end){
			$this->db->where('gongzibiao.nianyue <=',$end);
		}elseif ($start && $end){
			if($start > $end) $this->db->where('gongzibiao.nianyue >=',$start);
			if($start < $end){echo $start.','.$end;
				$this->db->where('gongzibiao.nianyue >=',$start);
				$this->db->where('gongzibiao.nianyue <=',$end);
			}
		}
		if($gongzileixing){
			$this->db->where('gongzibiao.gongzileixing',$gongzileixing);
		}
		if($name){
			$this->db->where('bumen.bumen_name',$name);
		}
		if($select){
			foreach ($select as $k=>$v){
				if( intval($v) > -1){
					$this->db->where($k,intval($v));
				}
			}
		}
		if($input){
			foreach ($input as $k=>$v){
				if( $v ){
					$this->db->like($k,trim($v));
				}
			}
		}
		$clone = clone( $this->db );
		$this->db->select('user_record.user_name,gongzibiao.*')->join('user_record','user_record.user_id = gongzibiao.user_id','left');
		$this->db->select('bumen.bumen_name')->join('bumen','user_record.bumen_id = bumen.bumen_id','left');
		$data['list'] = $this->db->order_by('gongzibiao.id','desc')->get('gongzibiao', $this->per_page, $this->offset)->result_array();
		$this->db = $clone;
		$data['count'] = $this->db->from('gongzibiao')->count_all_results();
		return $data;
	}
	public function wagesView($id){
		$this->db->where('id',$id);
		return $this->db->get('gongzibiao')->row_array();
	}
	public function userList($user_id){
		if($user_id!=''){
			$this->db->where('user_id', $user_id);
		}
		$data= $this->db->select('*')->get('user_record')->row_array();

        return $data;
	}
	public function bumen(){
		$data['count'] = $this->db->select('*')->from('bumen')->count_all_results();
        $data['department'] = $this->db->select('*')->get('bumen', $this->per_page, $this->offset)->result_array();
        //echo $this->db->last_query();
        return $data;
	}
	public function category(){
		$data['count'] = $this->db->select('*')->from('user_cat')->count_all_results();
        $data['user_category'] = $this->db->select('*')->get('user_cat', $this->per_page, $this->offset)->result_array();
        //echo $this->db->last_query();
        return $data;
	}
	public function gongzileixing(){
		$data['count'] = $this->db->select('*')->from('gongzileixing')->count_all_results();
        $data['gongzileixing'] = $this->db->select('*')->get('gongzileixing', $this->per_page, $this->offset)->result_array();
        //echo $this->db->last_query();
        return $data;
	}
	/**
	 * [user_list 公告列表]
	 * @AuthorHTL lin
	 * @DateTime  2016-02-23T09:10:47+0800
	 * @return    [type]                   [description]
	 */
	public function notice(){
		$data['count'] = $this->db->select('*')->from('news')->count_all_results();
        $data['news'] = $this->db->select('*')->get('news', $this->per_page, $this->offset)->result_array();
        //echo $this->db->last_query();
        return $data;
	}
	/**
	 * 公告
	 */
	public function noticeList($news_id){
		if($news_id!=''){
			$this->db->where('news_id', $news_id);
		}
		$data= $this->db->select('*')->get('news')->row_array();

        return $data;
	}
	/**
	 * 留言列表
	 */
	public function getMessage($where=''){
		if($where!=''){
			$this->db->where('user_id',$where);
		}
		$this->db->order_by('liuyan_id','desc');
		$clone = clone( $this->db );
		$data['count'] = $this->db->select('*')->from('liuyan')->count_all_results();
		$this->db = $clone;
        $data['message'] = $this->db->select('*')->get('liuyan', $this->per_page, $this->offset)->result_array();
        return $data;
	}
	/**
	 * 留言详情
	 */
	public function messageList($liuyan_id){
		if($liuyan_id!=''){
			$this->db->where('user_id', $liuyan_id);
		}
		$data= $this->db->select('*')->get('liuyan')->row_array();

        return $data;
	}
	public function gongziType(){
		return $this->db->get('gongzileixing')->result_array();
	}
}
