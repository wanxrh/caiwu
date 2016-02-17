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
}
