<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 扩展 Controller 类
 * @author      lensic [mhy]
 * @link        http://www.lensic.cn/
 * @copyright   Copyright (c) 2013 - , lensic [mhy].
 */

/**
 * 默认控制器类
 *
 * 设置默认编码为 utf-8
 * 设置默认时区为东八区
 * SITE_COMMON_STATIC          （公共、前端、后端）样式、图片、脚本存放文件夹
 * SITE_UPLOADS                公共上传文件夹
 */
class MY_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		header('Content-type:text/html; charset=utf-8');
		date_default_timezone_set('Asia/Shanghai');
		define('SITE_COMMON_STATIC',        base_url().'static');

		$this->load->library('session');
		$user_id = $this->session->userdata('user_id');;
        $this->load->model('common_model');
        $this->data['user_info'] = $this->common_model->get_user($user_id);

	}
}

/**
 * 前端控制器类
 */
class M_Controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$user_id = $this->session->userdata('user_id');
		// 没有登录不能进会员中心
		if($this->uri->uri_string()!=''){
	        if (!$user_id) {
	            echo "<script language='javascript'>window.location.href='/';</script>";
	            exit;
	        }
    	}

	}
}

/**
 * 后端控制器类
 *
 * SITE_ADMIN_NAME     站点后台名称
 * SITE_ADMIN_LOGO     站点后台 LOGO
 * SITE_ADMIN_THEME    站点后台主题
 * SITE_ADMIN_STATIC   后端样式、图片、脚本存放位置
 */
class A_Controller extends MY_Controller
{
	function __construct()
	{
		parent::__construct();


	}

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */