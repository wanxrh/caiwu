<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>你所请求的页面找不到了！</title>
<meta name="description" content="Simple and aesthetic template with animated background">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<link rel="stylesheet" type="text/css" href="/static/404/style/reset.css">
<link rel="stylesheet" type="text/css" href="/static/404/style/main.css">

<!--[if lte IE 8]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>

<body>

<div id="container">
	<div id="stage" class="stage">
		<div id="clouds" class="stage" style="background-position: 516.599999999995px 0px;"></div>
	</div>

	<div id="ticket">
		<section id="ticket_left">
			<p class="text1_a">迷失在云端</p>
			<p class="text2_a">未找到航班</p>
			<p class="text3_a">错误404</p>
			<p class="text4_a">对不起!</p>
			<p class="text5_a">从</p>
			<p class="text6_a">地球</p>
			<p class="text7_a">到</p>
			<p class="text8_a">火星</p>
			<p class="text9_a">座</p>
			<p class="text10_a">404</p>
			<p class="text11_a">尝试另一次飞行</p>
			<nav class="text12_a">
				<ul>
					<li><a href="/">网站首页</a></li>
				</ul>
			</nav>
		</section>

		<section id="ticket_right">
			<p class="text1_b">第一类</p>
			<p class="text2_b">迷失在云端</p>
			<p class="text3_b">从</p>
			<p class="text4_b">地球</p>
			<p class="text5_b">到</p>
			<p class="text6_b">火星</p>
			<p class="text7_b">座</p>
			<p class="text8_b">404</p>
			<p class="text9_b">1</p>
			<p class="text10_b">103076498</p>
		</section>
	</div>
</div>

<script src="/static/404/style/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="/static/404/style/jquery.spritely-0.5.js" type="text/javascript"></script>

<script type="text/javascript">
(function($) {
	$(document).ready(function() {
		$('#clouds').pan({fps: 40, speed: 0.7, dir: 'right', depth: 10});
	});
})(jQuery);
</script>

</body>
</html>