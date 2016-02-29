<?php

/**
 * 生成分页html
 *
 * @param $page          当前页
 * @param $pages         总页数
 * @param $url_format    链接格式，配合sprintf函数
 * @param $show_page     显示页码数，默认为5
 * @param $show_pages    显示总页数，默认true
 * @param $show_goto     显示页面跳转，默认为true
 * @param $total         显示条数，默认为NULL,表示不显示，若为其它则显示。
 *
 *
 */
function page($page, $pages, $url_format = '%d.html', $show_page = 5, $show_pages = TRUE, $show_goto = TRUE, $total = NULL) {
    if ($page > $pages) {
        $page = $pages;
    }

    if ($pages < 2)
        return '';
    $html = array();
    $html [] = '<div class="pagin">';
    $html [] = '<div class="message">共<i class="blue">' . $total . '</i>条记录，当前显示第&nbsp;<i class="blue">'.$page.'&nbsp;</i>页</div>';
    $html [] = '<ul class="paginList">';
    if ($page > 1) {
        $html [] = '<li class="paginItem"><a href="' . sprintf($url_format, $page - 1) . '"><span class="pagepre"></span></a></li>';
    }

    $page_start = $page - intval($show_page / 2);
    if ($page_start < 1)
        $page_start = 1;

    if ($page_start > 1) {
        $html [] = '<li class="paginItem"><a href="' . sprintf($url_format, 1) . '">1</a></li>';
        if ($page_start > 2) {
            $html [] = '<li class="paginItem more"><a href="javascript:;">...</a></li>';
        }
    }


    for ($i = 0; $i < $show_page; $i ++) {
        $cur = $page_start + $i;
        if ($cur > $pages)
            break;

        if ($cur == $page) {
            $html [] = '<li class="paginItem current"><a href="javascript:;">' . $cur . '</a></li>';
        } else {
            $html [] = '<li class="paginItem"><a href="' . sprintf($url_format, $cur) . '">' . $cur . '</a></li>';
        }
    }
    if ($cur < $pages) {
        if ($cur + 1 < $pages) {
            $html [] = '<li class="paginItem more"><a href="javascript:;">...</a></li>';
        }
        $html [] = '<li class="paginItem"><a href="' . sprintf($url_format, $pages) . '">'.$pages.'</a></li>';
    }

    if ($page < $pages) {
        $html [] = '<li class="paginItem"><a href="' . sprintf($url_format, $page + 1) . '"><span class="pagenxt"></span></a></li>';
    }

    if ($show_pages) {
        $html [] = '<span class="u-go-page"><em>共 ' . $pages . ' 页</em></span>';
    }

    /*if ($total !== NULL) {
        $html [] = '<span class="u-go-page"><em>共 ' . $total . ' 条</em></span>';
    }*/

    if ($show_goto) {
        $next_page = $pages < 2 ? $page : ($page >= $pages ? $page - 1 : $page + 1);

        $str = explode('%d', $url_format);
        $html [] = '<form onsubmit="var p;location.href=\'' . $str [0] . '\'+((p=parseInt(this.getElementsByTagName(\'input\')[0].value))>0?p:1)+\'' . $str [1] . '\';return false;">到第
                       <span><input class="ipt-txt" type="text" size="1" name="page" value="' . $next_page . '"></span> 页
                       <input type="submit" value="确定">
                    </form>';
    }
    $html [] = '</ul>';
    $html [] = '</div>';

    return implode($html);
}

//当前页/最后页
function total_page($page, $pages, $url_format = '%d.html', $show_page = 1) {

    if ($page > $pages) {
        $page = $pages;
    }
    if ($pages < 2){
        $html [] = ' 1';
    }
        //return '';
    $html = array();
    if($pages>0){
    $html [] = '<div class="m-min-page">';
    }
    if ($page == 1) {
        $html [] = '<a  href="javascript:;"><i class="iconfont icon-xiala u-rotate-90"></i></a>';
    }elseif($page > 1){
        $html [] = '<a  href="' . sprintf($url_format, $page - 1) . '"><i class="iconfont icon-xiala u-rotate-90"></i></a>';
    }

    $page_start = $page - intval($show_page / 2);
    if ($page_start < 1)
        $page_start = 1;
    for ($i = 0; $i < 2; $i ++) {
        $cur = $page_start + $i;
        if ($cur > $pages)
            break;

        if ($cur == $page) {/*
            echo $cur;
            echo "<br>";
            echo $page;exit;*/

            $html [] = '<em class="curr">' . $cur . '</em>/';
        }/* else {
            $html [] = '<a title="查看第' . $cur . '页" href="' . sprintf($url_format, $cur) . '">' . $cur . '</a>';
        }*/
    }
   /* if ($cur < $pages) {
        $html [] = '<a title="查看第' . $pages . '页" href="' . sprintf($url_format, $pages) . '">' . $pages . '</a>';
    }*/

    if ($page <= $pages&&$page>0) {
        $html [] = '<em class="sum">' . $pages . '</em>';
    }elseif($pages==1){
       $html [] = '<em class="sum">1</em>';
    }else{
        $html [] = '';
    }

    if ($page < $pages) {
        $html [] = '<a  href="' . sprintf($url_format, $page + 1) . '"><i class="iconfont icon-xiala u-rotate-270"></i></a>';
    }elseif($page==$pages&&$page>0){
        $html [] = '<a  href="' . sprintf($url_format, $page) . '"><i class="iconfont icon-xiala u-rotate-270"></i></a>';
    }

    $html [] = '</div>';

    return implode($html);
}
