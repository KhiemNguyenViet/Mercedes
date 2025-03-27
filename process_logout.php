<?php
setcookie("user_id",$_COOKIE['user_id'],time() - 3600,'/');
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$skin=$tlca_do->load('class_skin');
$class_index=$tlca_do->load('class_index');
$setting=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']]=$r_s['value'];
}
$thongbao="Đăng xuất thành công.";
$replace=array(
	'header'=>$skin->skin_normal('skin/header'),
	'script_footer'=>$skin->skin_normal('skin/script_footer'),
	'logo'=>$index_setting['logo'],
	'title'=>'Đăng xuất thành công',
	'thongbao'=>$thongbao,
	'link'=>'/dang-nhap.html'
);
echo $skin->skin_replace('skin/chuyenhuong',$replace);
?>