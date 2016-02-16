<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 公共函数
 * @author      lensic [mhy]
 * @link        http://www.lensic.cn/
 * @copyright   Copyright (c) 2013 - , lensic [mhy].
 */

/**
 * 加载全局文件 css，jquery，js
 *
 * @access   public
 * @return   string   html 代码字符串
 */
function load_common()
{
	$load = '';
	$load .= '<link type="text/css" rel="stylesheet" href="' . SITE_COMMON_STATIC . '/common.css" />' . "\n";
	$load .= '<link type="text/css" rel="stylesheet" href="' . SITE_RESOURCES . '/jquery-ui.css" />' . "\n";
	$load .= '<script type="text/javascript" src="' . SITE_RESOURCES . '/jquery.js"></script>' . "\n";
	$load .= '<script type="text/javascript" src="' . SITE_RESOURCES . '/jquery-ui.js"></script>' . "\n";
	$load .= '<script type="text/javascript" src="' . SITE_COMMON_STATIC . '/common.js"></script>' . "\n";
	return $load;
}

/**
 * start: 打印数据
 * @param $value 所有类型数据
 * @param bool $exit 是否终止程序，TRUE = 是，FALSE = 否，默认为 TRUE;
 */
function printR($value, $exit = TRUE)
{
    echo '<pre>';
    print_r($value);
    echo '</pre>';
    $exit && exit;
}
// end: 打印数据
function code(){

}
/* End of file my_common_helper.php */
/* Location: ./application/helpers/my_common_helper.php */