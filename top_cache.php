<?php
$url = $_SERVER["REQUEST_URI"];
$cachefile = 'cache/data/'.intval($_REQUEST['id']).'-'.addslashes($_REQUEST['chuong']).'.txt';
$cachetime = 1800;
// Serve from the cache if it is younger than $cachetime
/*if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
    include($cachefile);
    exit;
}*/
if (file_exists($cachefile)) {
	$xxx=file_get_contents($cachefile);
	$xn=preg_match('/<div class="chapter-c">(.*?)<\/div>/is', $xxx,$tach_nd);
	if(strlen($tach_nd[1])>10){
	    include($cachefile);
	    exit;
	}else{

	}
}
ob_start(); // Start the output buffer
?>