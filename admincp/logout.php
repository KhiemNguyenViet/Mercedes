<?php
include('../includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_cpanel');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$page=addslashes($url_query['page']);
$class_e_member=$tlca_do->load('class_e_member');
$skin=$tlca_do->load('class_skin_cpanel');
if(isset($_COOKIE['emin_id']) AND intval($_COOKIE['emin_id'])>0){
	$class_e_member->logout();
	$thongbao="Đăng xuất tài khoản thành công.";
	$replace=array(
		'title'=>'Đăng xuất tài khoản...',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link_chuyen'=>'/admincp/login'
	);
	echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
}else{
	$thongbao="Hiện tại bạn chưa đăng nhập.";
	$replace=array(
		'title'=>'Đăng xuất tài khoản...',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link_chuyen'=>'/admincp/login'
	);
	echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
}
?>