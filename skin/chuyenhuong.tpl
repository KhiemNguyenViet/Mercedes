<!DOCTYPE html>
<html lang="vi">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# book: http://ogp.me/ns/book# profile: http://ogp.me/ns/profile#">
    <meta charset="UTF-8">
    <title>{title}</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/skin/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="/skin/css/styles.css?t=<?php echo time();?>">
    <!-- <script type="text/javascript" src="/js/jquery-1.11.1.min.js"></script> -->
    <script type="text/javascript" src="/js/jquery-3.2.1.min.js?t=<?php echo time();?>"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-N97MPN3K2F"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-N97MPN3K2F');
</script>
</head>
<body>
    <div class="loadpage" id="load_chuyenhuong">
        <div class="content_loadpage">
            <div class="logox">
                <img src="/skin/css/images/logo.png" alt="">
            </div>
            <div class="loadx"></div>
            <div class="center" style="margin-top: 10px;color: red;">{thongbao}</div>
        </div>
    </div>
    {script_footer}
	<script type="text/javascript">
		$(document).ready(function(){
			setTimeout(function(){
				window.location.href="{link}";
			},2900);
		});
	</script>
</body>
</html>