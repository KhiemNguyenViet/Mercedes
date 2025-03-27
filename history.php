<?php
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_index');
$skin=$tlca_do->load('class_skin');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$page=intval($url_query['page']);
if($page<=0){
	$page=1;
}else{
	$page=$page;
}
if($page>1){
	$title_page=' - trang '.$page;
}else{

}
$limit=20;
$setting=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']]=$r_s['value'];
}
if(!isset($_COOKIE['user_id'])){
	$thongbao="Bạn chưa đã đăng nhập.";
	$replace=array(
		'header'=>$skin->skin_normal('skin/header'),
		'script_footer'=>$skin->skin_normal('skin/script_footer'),
		'logo'=>$index_setting['logo'],
		'title'=>'Bạn chưa đăng nhập tài khoản',
		'thongbao'=>$thongbao,
		'link'=>'/dang-nhap.html'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
	exit();
}
if(isset($_COOKIE['user_id'])){
	$class_member=$tlca_do->load('class_member');
	$user_info=$class_member->user_info($conn,$_COOKIE['user_id']);
	$navbar=$skin->skin_normal('skin/navbar_login');
}else{
	$navbar=$skin->skin_normal('skin/navbar');
}
$list_history=$class_index->list_history($conn,$user_info['user_id'],$page,$limit);
$list_tag_footer=$class_index->list_tag_footer($conn,10);
$thongke = mysqli_query($conn, "SELECT history.*,phim.tieu_de,phim.minh_hoa,phim.link,list_tap.tieu_de AS ten_tap FROM history INNER JOIN phim ON history.phim=phim.id LEFT JOIN list_tap ON history.tap=list_tap.id WHERE history.user_id='{$user_info['user_id']}' ORDER BY history.date_end DESC");
$total_phim=mysqli_num_rows($thongke);
$total_page=ceil($total_phim/$limit);
$phantrang=$class_index->phantrang($page,$total_page,'/lich-su.html');
$replace=array(
	'header'=>$skin->skin_normal('skin/header'),
	'box_header'=>$box_header,
	'navbar'=>$navbar,
	'box_top'=>$skin->skin_normal('skin/box_top'),
	'footer'=>$skin->skin_normal('skin/footer'),
	'title'=>$index_setting['title'].''.$title_page,
	'description'=>$index_setting['description'],
	'site_name'=>$index_setting['site_name'],
	'h1'=>$index_setting['h1'],
	'list_theloai'=>$class_index->list_theloai($conn),
	'list_nam'=>$class_index->list_nam($conn),
	'limit'=>$limit,
	'list_history'=>$list_history,
	'phantrang'=>$phantrang,
	'list_tag_footer'=>$list_tag_footer,
	'link_domain'=>$index_setting['link_domain'],
	'name'=>$user_info['name'],
	'avatar'=>$user_info['avatar']
	);
echo $skin->skin_replace('skin/history',$replace);
?>