<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 站点公共模型
 * @author      lensic [mhy]
 * @link        http://www.lensic.cn/
 * @copyright   Copyright (c) 2013 - , lensic [mhy].
 */
class Common_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('financial', TRUE);
	}

	public function get_user($user_id) {
        return $this->db->get_where('user_record', array('user_id' => $user_id))->row_array();
    }
	/**
	 * 获取单条数据
	 *
	 * @access   public
	 * @param    string   表名
	 * @param    array    条件数组
	 * @param    string   查询字段
	 * @return   array    一维数据数组
	 */
	function get_one($table, $where = array(), $fields = '*')
	{
		if($where)
		{
			$this->db->where($where);
		}
		return $this->db->select($fields)->from($table)->get()->row_array();
		//echo $this->db->last_query();exit;
	}

	/**
	 * 获取多条数据
	 *
	 * @access   public
	 * @param    string   表名
	 * @param    array    条件数组
	 * @param    string   查询字段
	 * @return   array    多维数据数组
	 */
	function get_all($table, $where = array(), $fields = '*')
	{
		if($where)
		{
			$this->db->where($where);
		}
		return $this->db->select($fields)->from($table)->get()->result_array();
	}

	/*
	 * 添加数据
	 *
	 * @access   public
	 * @param    string   表名
	 * @param    array    数据数组
	 * @return   number   添加的记录 ID
	 */
	function insert($table, $post)
	{
		$this->db->insert($table, $post);
		return $this->db->insert_id();
	}

	/*
	 * 删除数据
	 *
	 * @access   public
	 * @param    string   表名
	 * @param    array    条件数组
	 * @return   number   影响行数
	 */
	function delete($table, $where)
	{
		$this->db->delete($table, $where);
		return $this->db->affected_rows();
	}
    /*
	 * 批量删除数据
	 *
	 * @access   public
	 * @param    string   表名
	 * @param    array    条件数组
	 * @return   number   影响行数
	 */
    function deleteAll($table, $where)
    {
        $this->db->where_in('id',$where);
        $this->db->delete($table);
        return $this->db->affected_rows();
    }

	/*
	 * 更新数据
	 *
	 * @access   public
	 * @param    string   表名
	 * @param    array    数据数组
	 * @param    array    条件数组
	 * @return   number   影响行数
	 */
	function update($table, $post, $where = array())
	{
		if($where)
		{
			$this->db->where($where);
		}
		$this->db->update($table, $post);
		return $this->db->affected_rows();
	}
}

/* End of file m_common.php */
/* Location: ./application/models/m_common.php */