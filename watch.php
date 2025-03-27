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
	$box_comment=$skin->skin_normal('skin/box_comment_login');
}else{
	$navbar=$skin->skin_normal('skin/navbar');
	$box_comment=$skin->skin_normal('skin/box_comment');
}
$link=addslashes($_REQUEST['phim']);
$tap=intval($_REQUEST['tap']);
$thongtin=mysqli_query($conn,"SELECT * FROM phim WHERE link='$link'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['full']==0){
	$status='Đang cập nhật';
}else{
	$status='Hoàn thành';
}
if(strpos($r_tt['minh_hoa'], 'http')!==false){
	$minh_hoa=$r_tt['minh_hoa'];
}else{
	$minh_hoa=$index_setting['link_domain'].''.$r_tt['minh_hoa'];
}
$thongtin_tap=mysqli_query($conn,"SELECT * FROM list_tap WHERE phim='{$r_tt['id']}' ORDER BY thu_tu DESC");
while($r_t=mysqli_fetch_assoc($thongtin_tap)){
	$r_t['link']=$link;
	if($r_t['id']==$tap){
		$ten_tap=$r_t['tieu_de'];
		$tach_server=json_decode('['.$r_t['server'].']',true);
		$r_t['active']='active';
		$i=0;
		foreach ($tach_server as $key => $value) {
			$i++;
			if($i==1){
				$list_server.='<a href="javascript:void(0)" class="button-default bg-green load_server" tap="'.$r_t['id'].'">'.$value['server'].'</a>';
			}else{
				$list_server.='<a href="javascript:void(0)" class="button-default load_server" tap="'.$r_t['id'].'">'.$value['server'].'</a>';
			}
		}
	}else{
		$r_t['active']='';

	}
	$list_tap.=$skin->skin_replace('skin/box_li/li_tap',$r_t);
}
$category=$r_tt['category'];
$thongtin_cat=mysqli_query($conn,"SELECT * FROM category WHERE cat_id IN ($category) ORDER BY cat_thutu ASC");
while($r_c=mysqli_fetch_assoc($thongtin_cat)){
	$list_cat.=$skin->skin_replace('skin/box_li/li_cat',$r_c);
}
if($r_tt['tags']==''){
	$list_tags='';
}else{
	$tach_tags=explode(',', $r_tt['tags']);
	foreach ($tach_tags as $key => $value) {
		$value=trim($value);
		if($value!=''){
			$list_tags.='<a href="/tags/'.urlencode($value).'.html">'.$value.'</a>';
		}
	}
}
$list_tag_footer=$class_index->list_tag_footer($conn,10);
$list_h.='<h3>Phim '.$r_tt['tieu_de'].' '.$ten_tap.' HD</h3>';
$list_h.='<h3>Phim '.$r_tt['tieu_de'].' '.$ten_tap.' Thuyet minh</h3>';
$list_h.='<h3>Phim '.$r_tt['tieu_de'].' '.$ten_tap.' Thuyết minh</h3>';
$list_h.='<h3>Phim '.$r_tt['tieu_de'].' '.$ten_tap.' vietsub</h3>';
$list_h.='<h3>Phim '.$r_tt['tieu_de'].' '.$ten_tap.' hd vietsub</h3>';
$list_h.='<h3>Phim '.$r_tt['tieu_de'].' '.$ten_tap.'</h3>';
$list_h.='<h3>'.$r_tt['tieu_de'].' '.$ten_tap.' HD</h3>';
$list_h.='<h3>'.$r_tt['tieu_de'].' '.$ten_tap.' Thuyet minh</h3>';
$list_h.='<h3>'.$r_tt['tieu_de'].' '.$ten_tap.' Thuyết minh</h3>';
$list_h.='<h3>'.$r_tt['tieu_de'].' '.$ten_tap.' vietsub</h3>';
$list_h.='<h3>'.$r_tt['tieu_de'].' '.$ten_tap.' hd vietsub</h3>';
$list_h.='<h3>'.$r_tt['tieu_de'].' '.$ten_tap.'</h3>';
$list_desc.='Phim '.$r_tt['tieu_de'].' '.$ten_tap.' HD, ';
$list_desc.='Phim '.$r_tt['tieu_de'].' '.$ten_tap.' Thuyet minh, ';
$list_desc.='Phim '.$r_tt['tieu_de'].' '.$ten_tap.' Thuyết minh, ';
$list_desc.='Phim '.$r_tt['tieu_de'].' '.$ten_tap.' vietsub, ';
$list_desc.='Phim '.$r_tt['tieu_de'].' '.$ten_tap.' hd vietsub, ';
$list_desc.='Phim '.$r_tt['tieu_de'].' '.$ten_tap.', ';
$list_desc.=$r_tt['tieu_de'].' '.$ten_tap.' HD, ';
$list_desc.=$r_tt['tieu_de'].' '.$ten_tap.' Thuyet minh, ';
$list_desc.=$r_tt['tieu_de'].' '.$ten_tap.' Thuyết minh, ';
$list_desc.=$r_tt['tieu_de'].' '.$ten_tap.' vietsub, ';
$list_desc.=$r_tt['tieu_de'].' '.$ten_tap.' hd vietsub, ';
$list_desc.=$r_tt['tieu_de'].' '.$ten_tap;
$thongtin_lichchieu=mysqli_query($conn,"SELECT * FROM lich_chieu WHERE phim='{$r_tt['id']}'");
$total_lich=mysqli_num_rows($thongtin_lichchieu);
if($total_lich>0){
	$r_lich=mysqli_fetch_assoc($thongtin_lichchieu);
	$tach_lich=explode(',', $r_lich['thu']);
	$list_thu='';
	foreach ($tach_lich as $key => $value) {
		if($value!=''){
			if($value=='8'){
				$list_thu.='Chủ nhật, ';
			}else{
				$list_thu.='Thứ '.$value.', ';
			}
		}
	}
	if($list_thu==''){
		$text_lich='';
	}else{
		$list_thu=substr($list_thu, 0,-2);
		$text_lich='Phim được chiếu vào '.$list_thu.' hàng tuần';
	}

}else{
	$text_lich='';
}
$replace=array(
	'header'=>$skin->skin_normal('skin/header'),
	'navbar'=>$navbar,
	'box_top'=>$skin->skin_normal('skin/box_top'),
	'footer'=>$skin->skin_normal('skin/footer'),
	'box_comment'=>$box_comment,
	'title'=>$r_tt['tieu_de'].' '.$ten_tap.' - '.$index_setting['title'],
	'description'=>$r_tt['tieu_de'].' '.$ten_tap.', '.$list_desc.', '.$r_tt['description'],
	'site_name'=>$index_setting['site_name'],
	'h1'=>$index_setting['h1'],
	'list_theloai'=>$class_index->list_theloai($conn),
	'list_nam'=>$class_index->list_nam($conn),
	'limit'=>$limit,
	'link_domain'=>$index_setting['link_domain'],
	'ten_phim'=>$r_tt['tieu_de'],
	'ten_khac'=>$r_tt['ten_khac'],
	'rate'=>$r_tt['rate'],
	'rate_number'=>$r_tt['rate_number'],
	'nam'=>$r_tt['nam'],
	'thoi_luong'=>$r_tt['thoi_luong'],
	'status'=>$status,
	'minh_hoa'=>$minh_hoa,
	'view'=>number_format($r_tt['view']),
	'content'=>$r_tt['content'],
	'list_tap'=>$list_tap,
	'list_server'=>$list_server,
	'ten_tap'=>$ten_tap,
	'link'=>$r_tt['link'],
	'tap_moi'=>$r_t['id'],
	'phim'=>$r_tt['id'],
	'list_cat'=>$list_cat,
	'list_h'=>$list_h,
	'list_tags'=>$list_tags,
	'text_lich'=>$text_lich,
	'list_tag_footer'=>$list_tag_footer,
	'link_xem'=>$index_setting['link_domain'].'/xem-phim/'.$link.'-episode-id-'.$tap.'.html',
	'name'=>$user_info['name'],
	'avatar'=>$user_info['avatar']
	);

echo $skin->skin_replace('skin/watch',$replace);
?>