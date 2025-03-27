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
if(isset($_COOKIE['user_id'])){
	$navbar=$skin->skin_normal('skin/navbar_login');
}else{
	$navbar=$skin->skin_normal('skin/navbar');
}
$list_phim=$class_index->list_phim_index($conn,$page,$limit);
$list_tag_footer=$class_index->list_tag_footer($conn,10);
$replace=array(
	'header'=>$skin->skin_normal('skin/header'),
	'navbar'=>$navbar,
	'box_top'=>$skin->skin_normal('skin/box_top'),
	'footer'=>$skin->skin_normal('skin/footer'),
	'title'=>'Đăng ký tài khoản - '.$index_setting['title'],
	'description'=>$index_setting['description'],
	'site_name'=>$index_setting['site_name'],
	'h1'=>$index_setting['h1'],
	'list_theloai'=>$class_index->list_theloai($conn),
	'list_nam'=>$class_index->list_nam($conn),
	'limit'=>$limit,
	'list_phim'=>$list_phim,
	'list_tag_footer'=>$list_tag_footer,
	'link_domain'=>$index_setting['link_domain'],
	);
echo $skin->skin_replace('skin/register',$replace);
?>