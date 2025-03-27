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
$id=intval($_REQUEST['id']);
$thongtin=mysqli_query($conn,"SELECT * FROM phim WHERE id='$id'");
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
$k=0;
while($r_t=mysqli_fetch_assoc($thongtin_tap)){
	$k++;
	if($k==1){
		$tap_moi=$r_t['id'];
	}
	$r_t['link']=$r_tt['link'];
	$r_t['active']='';
	$list_tap.=$skin->skin_replace('skin/box_li/li_tap',$r_t);
}
$category=$r_tt['category'];
$thongtin_cat=mysqli_query($conn,"SELECT * FROM category WHERE cat_id IN ($category) ORDER BY cat_thutu ASC");
while($r_c=mysqli_fetch_assoc($thongtin_cat)){
	$list_cat.=$skin->skin_replace('skin/box_li/li_cat',$r_c);
}
$list_tag_footer=$class_index->list_tag_footer($conn,10);
$thongtin_follow=mysqli_query($conn,"SELECT * FROM follow WHERE phim='$id' AND user_id='{$user_info['user_id']}'");
$total_follow=mysqli_num_rows($thongtin_follow);
if($total_follow>0){
	$button_follow='<a href="javascript:;" id="toggle_follow" class="bg-green padding-5-15 button-default fw-500 flex flex-hozi-center" title="Theo dõi phim này" style="background-color: rgb(125, 72, 72);">
                            <span class="material-icons-round">bookmark_remove</span>
                        </a>';
}else{
	$button_follow='<a href="javascript:;" id="toggle_follow" class="bg-green padding-5-15 button-default fw-500 flex flex-hozi-center" title="Theo dõi phim này">
                            <span class="material-icons-round">bookmark_add</span>
                        </a>';
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
$list_desc.='Phim '.$r_tt['tieu_de'].' HD, ';
$list_desc.='Phim '.$r_tt['tieu_de'].' Thuyet minh, ';
$list_desc.='Phim '.$r_tt['tieu_de'].' Thuyết minh, ';
$list_desc.='Phim '.$r_tt['tieu_de'].' vietsub, ';
$list_desc.='Phim '.$r_tt['tieu_de'].' hd vietsub, ';
$list_desc.='Phim '.$r_tt['tieu_de'].', ';
$list_desc.=$r_tt['tieu_de'].' HD, ';
$list_desc.=$r_tt['tieu_de'].' Thuyet minh, ';
$list_desc.=$r_tt['tieu_de'].' Thuyết minh, ';
$list_desc.=$r_tt['tieu_de'].' vietsub, ';
$list_desc.=$r_tt['tieu_de'].' hd vietsub, ';
$list_desc.=$r_tt['tieu_de'];
if($r_tt['title']==''){
	$title='Phim '.$r_tt['tieu_de'].' HD Vietsub Thuyết minh';
}else{
	$title=$r_tt['title'];
}
$replace=array(
	'header'=>$skin->skin_normal('skin/header'),
	'navbar'=>$navbar,
	'box_top'=>$skin->skin_normal('skin/box_top'),
	'footer'=>$skin->skin_normal('skin/footer'),
	'box_comment'=>$box_comment,
	'title'=>$title.' - '.$index_setting['title'],
	'description'=>$list_desc.', '.$r_tt['description'],
	'site_name'=>$index_setting['site_name'],
	'h1'=>$r_tt['tieu_de'],
	'list_theloai'=>$class_index->list_theloai($conn),
	'list_nam'=>$class_index->list_nam($conn),
	'limit'=>$limit,
	'link_domain'=>$index_setting['link_domain'],
	'tieu_de'=>$r_tt['tieu_de'],
	'ten_khac'=>$r_tt['ten_khac'],
	'rate'=>$r_tt['rate'],
	'rate_number'=>$r_tt['rate_number'],
	'nam'=>$r_tt['nam'],
	'thoi_luong'=>$r_tt['thoi_luong'],
	'status'=>$status,
	'minh_hoa'=>$minh_hoa,
	'view'=>number_format($r_tt['luot_xem']),
	'content'=>$r_tt['content'],
	'list_tap'=>$list_tap,
	'link'=>$r_tt['link'],
	'tap_moi'=>$tap_moi,
	'phim'=>$id,
	'list_cat'=>$list_cat,
	'list_tags'=>$list_tags,
	'list_tag_footer'=>$list_tag_footer,
	'link_xem'=>$index_setting['link_domain'].'/thong-tin-phim/'.$r_tt['link'].'-'.$r_tt['id'].'.html',
	'name'=>$user_info['name'],
	'avatar'=>$user_info['avatar'],
	'button_follow'=>$button_follow,
	);
echo $skin->skin_replace('skin/view',$replace);
?>