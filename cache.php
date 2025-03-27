<?php
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$thongtin=mysqli_query($conn,"SELECT count(*) as total,chap_truyen,chap_num,chap_id FROM chap WHERE cache='0' ORDER BY chap_id ASC LIMIT 1");
$r_tt=mysqli_fetch_assoc($thongtin);
mysqli_free_result($thongtin);
$link_web='https://docthaudem.com';
if($r_tt['total']>0){
	$cachefile='cache/data/'.$r_tt['chap_truyen'].'-'.$r_tt['chap_num'].'.txt';
	if(file_exists($cachefile)){
		$xxx=file_get_contents($cachefile);
		$xn=preg_match('/<div class="chapter-c">(.*?)<\/div>/is', $xxx,$tach_nd);
		if(strlen($tach_nd[1])>10){
		}else{
			$check->curl($link_web.'/read.php?id='.$r_tt['chap_truyen'].'&chuong='.$r_tt['chap_num']);
		}
	}else{
		$check->curl($link_web.'/read.php?id='.$r_tt['chap_truyen'].'&chuong='.$r_tt['chap_num']);
	}
	mysqli_query($conn,"UPDATE chap SET cache='1' WHERE chap_id='{$r_tt['chap_id']}'");
	echo 'tao cache thanh cong';
}else{
	echo 'End';
}


?>