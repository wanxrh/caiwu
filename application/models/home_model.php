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
}
