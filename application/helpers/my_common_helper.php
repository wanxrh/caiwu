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
/**
 * 操作成功或失败辅助函数
 * @param $url 成功或失败之后跳转的路径
 * @param $word 提示文字
 * 返回字符串
 */
function get_redirect($word, $url) {
	echo '<script>alert("' . $word . '");window.location.href="' . $url . '";</script>';
}
//后台登陆跳转
function showmsg($msg,$gourl,$onlymsg=0,$limittime=0){
    $sitename='电力财务系统';
    $siteurl='www.zhong.com';
    $path='/';
	if(empty($siteurl)) $siteurl = '..';
	$htmlhead  = "<html>\r\n<head>\r\n<title>提示信息_$sitename</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf8}\" />\r\n";
	$htmlhead .= "<base target='_self'/>\r\n<style>";
	$htmlhead .= "*{font-size:12px;color:#a13fd4;}\r\n";
	$htmlhead .= "body{font-family:\"微软雅黑\",\"宋体\", Verdana, Arial, Helvetica, sans-serif;background:#FFFFFF;margin:0;}\r\n";
	$htmlhead .= "a:link,a:visited,a:active {color:#ABBBD6;text-decoration:none;}\r\n";
	$htmlhead .= ".msg{width:400px;text-align:left;margin:auto;border:1px solid #CEDAE6;box-shadow:2px 2px 3px #ccc;}\r\n";
                    $htmlhead .= ".head{letter-spacing:2px;line-height:30px;height:30px;overflow:hidden;font-weight:bold;background:#E8F3F5;}\r\n";
                    $htmlhead .= ".content{padding:10px 20px 5px 20px;line-height:200%;word-break:break-all;}\r\n";
                    $htmlhead .= ".ml{color:#d65665;padding-left:10px;font-weight:bold;}\r\n";
                    $htmlhead .= ".mr{float:right;width:4px;font-size:1px;}\r\n";
                    $htmlhead .= "</style></head>\r\n<body leftmargin='0' topmargin='0'>\r\n<center>\r\n<script>\r\n";
	$htmlfoot  = "</script>\r\n</center>\r\n</body>\r\n</html>\r\n";
	$litime = ($limittime==0 ? 1000 : $limittime);
	$func = '';
	if($gourl=='-1'){
		if($limittime==0) $litime = 5000;
		$gourl = "javascript:history.go(-1);";
	}
	if($gourl=='0'){
		if($limittime==0) $litime = 5000;
		$gourl = "javascript:history.back();";
	}
	if($gourl=='' || $onlymsg==1){
		$msg = "<script>alert(\"".str_replace("\"","“",$msg)."\");</script>";
	}else{
		if(preg_match('/close::/i',$gourl)){
			$tgobj = trim(eregi_replace('close::', '', $gourl));
			$gourl = 'javascript:;';
			$func .= "window.parent.document.getElementById('{$tgobj}').style.display='none';\r\n";
		}

		$func .= "      var pgo=0;
      function JumpUrl(){
        if(pgo==0){ location='$gourl'; pgo=1; }
      }\r\n";
		$rmsg = $func;
		$rmsg .= "document.write(\"<br /><br /><br /><div class='msg'>";
		$rmsg .= "<div class='head'><div class='mr'> </div><div class='ml'>提示信息！</div></div>\");\r\n";
		$rmsg .= "document.write(\"<div class='content'>\");\r\n";
		$rmsg .= "document.write(\"".str_replace("\"","“",$msg)."\");\r\n";
		$rmsg .= "document.write(\"";

		if($onlymsg==0){
			if( $gourl != 'javascript:;' && $gourl != ''){
				$rmsg .= "<br /><a href='{$gourl}'>如果你的浏览器没反应，请点击这里...</a>";
				$rmsg .= "</div>\");\r\n";
				$rmsg .= "setTimeout('JumpUrl()',$litime);";
			}else{
				$rmsg .= "</div>\");\r\n";
			}
		}else{
			$rmsg .= "<br/></div>\");\r\n";
		}
        $msg  = $htmlhead.$rmsg.$htmlfoot;
	}
	echo $msg;
}
/* End of file my_common_helper.php */
/* Location: ./application/helpers/my_common_helper.php */