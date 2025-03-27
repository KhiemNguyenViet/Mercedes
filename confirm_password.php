<?php
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$skin=$tlca_do->load('class_skin');
$class_index=$tlca_do->load('class_index');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$email=addslashes($url_query['email']);
$token=addslashes($url_query['token']);
$setting=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']]=$r_s['value'];
}
$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM forgot_password WHERE email='$email' AND code_active='$token'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']==0){
	$thongbao="Link không tồn tại hoặc đã được sử dụng...";
	$replace=array(
		'header'=>$skin->skin_normal('skin/header'),
		'script_footer'=>$skin->skin_normal('skin/script_footer'),
		'logo'=>$index_setting['logo'],
		'title'=>'Đang chuyển hướng',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link'=>'/'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
}else{
	$salt=$check->random_string(6);
	$pass=md5($r_tt['password'].''.$salt);
	mysqli_query($conn,"UPDATE user_info SET password='$pass',salt='$salt' WHERE email='$email'");
	mysqli_query($conn,"DELETE FROM forgot_password WHERE email='$email'");
	$thongbao="Thành công! Mật khẩu mới đã được xác nhận...";
	$replace=array(
		'header'=>$skin->skin_normal('skin/header'),
		'script_footer'=>$skin->skin_normal('skin/script_footer'),
		'logo'=>$index_setting['logo'],
		'title'=>'Đang chuyển hướng',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link'=>'/dang-nhap.html'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
}
?>