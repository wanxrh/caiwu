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
		// 登录验证处理
		/*$this->load->model('admin/m_index');
		$session = $this->m_index->get_session();
		if($this->uri->uri_string === 'admin/index/login')
		{
			if($session['admin_uid'] && $session['admin_username'])
			{
				redirect('admin/index/index');
			}
		} else {
			if(!$session['admin_uid'] || !$session['admin_username'])
			{

				redirect('admin/index/login');
			}
		}

		$config_site_admin = $this->m_common->get_one('config_site_admin');
		define('SITE_ADMIN_NAME', $config_site_admin['site_admin_name']);
		define('SITE_ADMIN_LOGO', SITE_COMMON_STATIC . '/admin/' . $config_site_admin['site_admin_theme'] . '/' . $config_site_admin['site_admin_logo']);
		define('SITE_ADMIN_THEME', $config_site_admin['site_admin_theme']);

		unset($config_site_admin);

		define('SITE_ADMIN_STATIC', SITE_COMMON_STATIC . '/admin/' . SITE_ADMIN_THEME);
		$this->load->set_admin_template(SITE_ADMIN_THEME);*/
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