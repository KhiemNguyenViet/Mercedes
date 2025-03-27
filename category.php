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
	$class_member=$tlca_do->load('class_member');
	$user_info=$class_member->user_info($conn,$_COOKIE['user_id']);
	$navbar=$skin->skin_normal('skin/navbar_login');
}else{
	$navbar=$skin->skin_normal('skin/navbar');
}
$cat=addslashes(strip_tags($_REQUEST['cat']));
$thongtin=mysqli_query($conn,"SELECT * FROM category WHERE cat_blank='$cat'");
$total=mysqli_num_rows($thongtin);
if($total==0){
	$thongbao="Dữ liệu không tồn tại.";
	$replace=array(
		'header'=>$skin->skin_normal('skin/header'),
		'script_footer'=>$skin->skin_normal('skin/script_footer'),
		'logo'=>$index_setting['logo'],
		'title'=>'Dữ liệu không tồn tại',
		'thongbao'=>$thongbao,
		'link'=>'/'
	);
	echo $skin->skin_replace('skin/chuyenhuong',$replace);
	exit();	
}
$r_tt=mysqli_fetch_assoc($thongtin);
$nam=addslashes(strip_tags($url_query['nam']));
$loai=addslashes(strip_tags($url_query['loai']));
$full=addslashes(strip_tags($url_query['full']));
if($nam==''){
	$where_nam="";
	$link_nam="";
}else if($nam=='all'){
	$where_nam="";
	$link_nam="?nam=all";
}else{
	$where_nam="AND nam='$nam'";
	$link_nam="?nam='$nam'";
}
if($full==''){
	$where_full="";
	$link_full="";
}else if($full=='all'){
	$where_full="";
	if($link_nam==''){
		$link_full="?full=all";
	}else{
		$link_full="&full=all";
	}
}else{
	$where_full="AND full='$full'";
	if($link_nam==''){
		$link_full="?full=".$full;
	}else{
		$link_full="&full=".$full;
	}
}
if($loai==''){
	$where_loai="";
	$link_loai="";
}else if($loai=='all'){
	$where_loai="";
	if($link_nam=='' AND $link_full==''){
		$link_loai="?loai=all";
	}else{
		$link_loai="&loai=all";
	}
}else{
	$where_loai="AND loai_hinh='$loai'";
	if($link_nam=='' AND $link_full==''){
		$link_loai="?loai=".$loai;
	}else{
		$link_loai="&loai=".$loai;
	}
}
$link='/the-loai/'.$r_tt['cat_blank'].'.html'.$link_nam.''.$link_full.''.$link_loai;
$cat_id=$r_tt['cat_id'];
if(($nam=='' OR $nam=='all') AND ($full=='' OR $full=='all') AND ($loai=='' OR $loai=='all')){
	$thongke = mysqli_query($conn, "SELECT * FROM phim WHERE FIND_IN_SET('$cat_id',category)>0 ORDER BY id ASC");
	$total_phim=mysqli_num_rows($thongke);
	$total_page=ceil($total_phim/$limit);
	if($nam=='' AND $full=='' AND $loai==''){
		$phantrang=$class_index->phantrang($page,$total_page,$link);
	}else{
		$phantrang=$class_index->phantrang_timkiem($page,$total_page,$link);
	}
}else{
	$thongke = mysqli_query($conn, "SELECT * FROM phim WHERE FIND_IN_SET('$cat_id',category)>0 $where_nam $where_full $where_loai ORDER BY id ASC");
	$total_phim=mysqli_num_rows($thongke);
	$total_page=ceil($total_phim/$limit);
	$phantrang=$class_index->phantrang_timkiem($page,$total_page,$link);
}
$list_phim=$class_index->list_phim_category($conn,$r_tt['cat_id'],$nam,$full,$loai,$page,$limit);
$list_tag_footer=$class_index->list_tag_footer($conn,10);
$replace=array(
	'header'=>$skin->skin_normal('skin/header'),
	'navbar'=>$navbar,
	'box_top'=>$skin->skin_normal('skin/box_top'),
	'footer'=>$skin->skin_normal('skin/footer'),
	'title'=>$r_tt['cat_tieude'].' - '.$index_setting['title'].''.$title_page,
	'description'=>$r_tt['cat_tieude'].' - '.$index_setting['description'],
	'site_name'=>$index_setting['site_name'],
	'h1'=>$index_setting['h1'],
	'list_theloai'=>$class_index->list_theloai($conn),
	'list_nam'=>$class_index->list_nam($conn),
	'option_nam'=>$class_index->list_option_nam($conn,''),
	'minh_hoa'=>'',
	'limit'=>$limit,
	'list_phim'=>$list_phim,
	'phantrang'=>$phantrang,
	'list_tag_footer'=>$list_tag_footer,
	'link_domain'=>$index_setting['link_domain'],
	'name'=>$user_info['name'],
	'avatar'=>$user_info['avatar'],
	'cat_tieude'=>$r_tt['cat_tieude'],
	'loai'=>$loai,
	'full'=>$full,
	'nam'=>$nam,
	'link_xem'=>$index_setting['link_domain'].''.$link,
	);
echo $skin->skin_replace('skin/category',$replace);
?>