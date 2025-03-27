<?php
include('../includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$class_index=$tlca_do->load('class_cpanel');
$param_url = parse_url($_SERVER['REQUEST_URI']);
parse_str($param_url['query'], $url_query);
$page=addslashes($url_query['page']);
$skin=$tlca_do->load('class_skin_cpanel');
if(intval($page)<1){
	$page=1;
}else{
	$page=intval($page);
}
if(isset($_REQUEST['action'])){
	$action=addslashes($_REQUEST['action']);
}else{
	$action='dashboard';
}
if(!isset($_COOKIE['emin_id'])){
	$thongbao="Bạn chưa đăng nhập.<br>Đang chuyển hướng tới trang đăng nhập...";
	$replace=array(
		'title'=>'Bạn chưa đăng nhập...',
		'description'=>$index_setting['description'],
		'thongbao'=>$thongbao,
		'link_chuyen'=>'/admincp/login'
	);
	echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
	exit();
}
$class_e_member=$tlca_do->load('class_e_member');
$tach_token = json_decode($check->token_login_decode($_COOKIE['emin_id']), true);
$emin_id = $tach_token['user_id'];
$emin_info = $class_e_member->user_info($conn, $emin_id);
$setting=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']]=$r_s['value'];
}
$thaythe=array(
	'header'=>$skin->skin_normal('skin_cpanel/header'),
	'box_menu'=>$skin->skin_normal('skin_cpanel/box_menu'),
	'footer'=>$skin->skin_normal('skin_cpanel/footer'),
	'box_script_footer'=>$skin->skin_normal('skin_cpanel/box_script_footer'),
	'description'=>$index_setting['description'],
	'site_name'=>$index_setting['site_name'],
	//'phantrang'=>$class_index->phantrang($page,$total_page,'/'),
	'phantrang'=>'',
	'fullname'=>$emin_info['name'],
	'email'=>$emin_info['email'],
	'point'=>$emin_info['user_money'],
	'name'=>$name,
	'avatar'=>$emin_info['avatar']
);
if($action=='profile'){
	$thaythe['title']='Profile';
	$thaythe['title_action']='Profile';
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/profile',$emin_info);
}else if($action=='change_password'){
	$thaythe['title']='Change Password';
	$thaythe['title_action']='Change Password';
	$bien=array(
		'phantrang'=>$class_index->phantrang($page,$total,10,'/admincp/list-nhac')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/change_password',$bien);
}else if($action=='list_phim' OR $action=='dashboard'){
	$thaythe['title']='Danh sách phim';
	$thaythe['title_action']='Danh sách phim';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM phim");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_phim'=>$class_index->list_phim($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-phim')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_phim',$bien);
}else if($action=='edit_setting'){
	$thaythe['title']='Chỉnh sửa cài đặt';
	$thaythe['title_action']='Chỉnh sửa cài đặt';
	$id=preg_replace('/[^0-9a-zA-Z_-]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM index_setting WHERE name='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Mục cài đặt không tồn tại...";
		$replace=array(
			'title'=>'Mục cài đặt không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-setting'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_setting',$r_tt);
}else if($action=='list_theloai'){
	$thaythe['title']='Danh sách thể loại';
	$thaythe['title_action']='Danh sách thể loại';
	$limit=50;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM category");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_theloai'=>$class_index->list_category($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-theloai')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_theloai',$bien);
}else if($action=='add_theloai'){
	$thaythe['title']='Thêm thể loại';
	$thaythe['title_action']='Thêm thể loại';
	$r_tt['option_main']=$class_index->list_option_main($conn,'');
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_theloai',$r_tt);
}else if($action=='edit_theloai'){
	$thaythe['title']='Chỉnh sửa thể loại';
	$thaythe['title_action']='Chỉnh sửa thể loại';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM category WHERE cat_id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Thể loại không tồn tại...";
		$replace=array(
			'title'=>'Thể loại không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-theloai'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$r_tt['option_main']=$class_index->list_option_main($conn,$r_tt['cat_main']);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_theloai',$r_tt);
}else if($action=='list_thanhvien'){
	$thaythe['title']='Danh sách thành viên';
	$thaythe['title_action']='Danh sách thành viên';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM user_info");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_thanhvien'=>$class_index->list_thanhvien($conn,'all',$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-thanhvien')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_thanhvien',$bien);
}else if($action=='list_thanhvien-khoa'){
	$thaythe['title']='Thành viên tạm khóa';
	$thaythe['title_action']='Thành viên tạm khóa';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM user_info WHERE active='2'");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_thanhvien'=>$class_index->list_thanhvien($conn,'2',$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-thanhvien-khoa')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_thanhvien_khoa',$bien);
}else if($action=='list_thanhvien-premium'){
	$thaythe['title']='Thành viên premium';
	$thaythe['title_action']='Thành viên premium';
	$limit=100;
	$hientai=time();
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM user_info WHERE date_vip>='$hientai'");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_thanhvien'=>$class_index->list_thanhvien_premium($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-thanhvien-premium')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_thanhvien_premium',$bien);
}else if($action=='list_thanhvien-khoa-vinhvien'){
	$thaythe['title']='Thành viên khóa vĩnh viễn';
	$thaythe['title_action']='Thành viên khóa vĩnh viễn';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM user_info WHERE active='3'");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_thanhvien'=>$class_index->list_thanhvien($conn,'3',$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-thanhvien-khoa-vinhvien')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_thanhvien_khoa_vinhvien',$bien);
}else if($action=='edit_thanhvien'){
	$thaythe['title']='Thông tin thành viên';
	$thaythe['title_action']='Thông tin thành viên';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM user_info WHERE user_id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Thành viên này không tồn tại...";
		$replace=array(
			'title'=>'Thành viên không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-thanhvien'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_thanhvien',$r_tt);
}else if($action=='edit_report'){
	$thaythe['title']='Chỉnh sửa báo lỗi';
	$thaythe['title_action']='Chỉnh sửa báo lỗi';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT baoloi.*, count(*) AS total,user_info.username,truyen.tieu_de FROM baoloi LEFT JOIN user_info ON user_info.user_id=baoloi.user_id LEFT JOIN truyen ON truyen.id=baoloi.truyen WHERE baoloi.id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Báo lỗi này không tồn tại...";
		$replace=array(
			'title'=>'Báo lỗi này không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-report'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$r_tt['date_post']=date('H:i:s d/m/Y',$r_tt['date_post']);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_report',$r_tt);
}else if($action=='add_coin'){
	$thaythe['title']='Thêm coin cho thành viên';
	$thaythe['title_action']='Thêm coin cho thành viên';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM user_info WHERE user_id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Thành viên này không tồn tại...";
		$replace=array(
			'title'=>'Thành viên không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-thanhvien'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$r_tt['user_money']=number_format($r_tt['user_money']);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_coin',$r_tt);
}else if($action=='add_block'){
	$thaythe['title']='Chặn ip mới';
	$thaythe['title_action']='Chặn ip mới';
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_block',$r_tt);
}else if($action=='add_napcoin'){
	$thaythe['title']='Thêm coin cho thành viên';
	$thaythe['title_action']='Thêm coin cho thành viên';
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_napcoin',$r_tt);
}else if($action=='edit_napcoin'){
	$thaythe['title']='Chỉnh sửa nạp coin';
	$thaythe['title_action']='Chỉnh sửa nạp coin';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM nap LEFT JOIN user_info ON nap.user_id=user_info.user_id WHERE id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Giao dịch không tồn tại...";
		$replace=array(
			'title'=>'Giao dịch không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-napcoin'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_napcoin',$r_tt);
}else if($action=='list_block'){
	$thaythe['title']='Danh sách chặn';
	$thaythe['title_action']='Danh sách chặn';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM block_ip");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_block'=>$class_index->list_block($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-block')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_block',$bien);
}else if($action=='list_chat'){
	$thaythe['title']='Danh sách chat';
	$thaythe['title_action']='Danh sách chat';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM chat");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_chat'=>$class_index->list_chat($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-chat')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_chat',$bien);
}else if($action=='list_comment'){
	$thaythe['title']='Danh sách bình luận';
	$thaythe['title_action']='Danh sách bình luận';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM comment");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_comment'=>$class_index->list_comment($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-commnet')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_comment',$bien);
}else if($action=='list_napcoin'){
	$thaythe['title']='Danh sách nạp coin';
	$thaythe['title_action']='Danh sách nạp coin';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM nap");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_napcoin'=>$class_index->list_napcoin($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-napcoin')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_napcoin',$bien);
}else if($action=='list_donate'){
	$thaythe['title']='Danh sách donate';
	$thaythe['title_action']='Danh sách donate';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM donate");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_donate'=>$class_index->list_donate($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-donate')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_donate',$bien);
}else if($action=='list_muachap'){
	$thaythe['title']='Danh sách mua chap';
	$thaythe['title_action']='Danh sách mua chap';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM muachap");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_muachap'=>$class_index->list_muachap($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-muachap')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_muachap',$bien);
}else if($action=='list_report'){
	$thaythe['title']='Danh sách báo lỗi';
	$thaythe['title_action']='Danh sách báo lỗi';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM baoloi");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_report'=>$class_index->list_report($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-report')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_report',$bien);
}else if($action=='list_history'){
	$thaythe['title']='Lịch sử đọc truyện';
	$thaythe['title_action']='Lịch sử đọc truyện';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM history");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_history'=>$class_index->list_history($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-history')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_history',$bien);
}else if($action=='list_menu'){
	$thaythe['title']='Danh sách menu';
	$thaythe['title_action']='Danh sách menu';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM menu");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_menu'=>$class_index->list_menu($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-menu')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_menu',$bien);
}else if($action=='add_menu'){
	$thaythe['title']='Thêm menu mới';
	$thaythe['title_action']='Thêm menu mới';
	$r_tt['option_category']=$class_index->list_option_category($conn,'');
	$r_tt['option_post']=$class_index->list_option_post($conn,'');
	$r_tt['option_main']=$class_index->list_option_main_menu($conn,'');

	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_menu',$r_tt);
}else if($action=='edit_menu'){
	$thaythe['title']='Chỉnh sửa menu';
	$thaythe['title_action']='Chỉnh sửa menu';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM menu WHERE menu_id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Menu này không tồn tại...";
		$replace=array(
			'title'=>'Menu không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-menu'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$r_tt['option_category']=$class_index->list_option_category($conn,'');
	$r_tt['option_post']=$class_index->list_option_post($conn,$r_tt['menu_link']);
	$r_tt['option_main']=$class_index->list_option_main_menu($conn,$r_tt['menu_main']);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_menu',$r_tt);
}else if($action=='list_lich'){
	$thaythe['title']='Danh sách lịch chiếu';
	$thaythe['title_action']='Danh sách lịch chiếu';
	$limit=50;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM lich_chieu");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_lich'=>$class_index->list_lich($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-lich')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_lichchieu',$bien);
}else if($action=='add_lichchieu'){
	$thaythe['title']='Thêm lịch chiếu mới';
	$thaythe['title_action']='Thêm lịch chiếu mới';
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_lichchieu',$r_tt);
}else if($action=='edit_lichchieu'){
	$thaythe['title']='Chỉnh sửa lịch chiếu';
	$thaythe['title_action']='Chỉnh sửa lịch chiếu';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM lich_chieu WHERE id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Dữ liệu không tồn tại...";
		$replace=array(
			'title'=>'Tác giả không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-lich'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$thongtin_phim=mysqli_query($conn,"SELECT * FROM phim WHERE id='{$r_tt['phim']}'");
	$r_p=mysqli_fetch_assoc($thongtin_phim);
	$tach_thu=explode(',', $r_tt['thu']);
	for ($i=2; $i <=8 ; $i++) { 
		if(in_array($i, $tach_thu)==true){
			if($i==8){
				$list_thu.='<div class="li_input" id="input_'.$i.'"><input type="checkbox" name="thu[]" value="'.$i.'" checked> <span>Chủ nhật</span></div>';
			}else{
				$list_thu.='<div class="li_input" id="input_'.$i.'"><input type="checkbox" name="thu[]" value="'.$i.'" checked> <span>Thứ '.$i.'</span></div>';
			}
		}else{
			if($i==8){
				$list_thu.='<div class="li_input" id="input_'.$i.'"><input type="checkbox" name="thu[]" value="'.$i.'"> <span>Chủ nhật</span></div>';
			}else{
				$list_thu.='<div class="li_input" id="input_'.$i.'"><input type="checkbox" name="thu[]" value="'.$i.'"> <span>Thứ '.$i.'</span></div>';
			}
		}
	}
	$r_tt['list_thu']=$list_thu;
	$r_tt['list_phim']='<div class="li_phim" phim="'.$r_p['id'].'"><span><i class="fa fa-close"></i></span><span>'.$r_p['tieu_de'].'</span></div>';
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_lichchieu',$r_tt);
}else if($action=='list_premium'){
	$thaythe['title']='Danh sách gói premium';
	$thaythe['title_action']='Danh sách gói premium';
	$bien=array(
		'list_premium'=>$class_index->list_premium($conn)
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_premium',$bien);
}else if($action=='add_premium'){
	$thaythe['title']='Thêm gói premium';
	$thaythe['title_action']='Thêm gói premium';
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_premium',$r_tt);
}else if($action=='edit_premium'){
	$thaythe['title']='Chỉnh sửa gói premium';
	$thaythe['title_action']='Chỉnh sửa gói premium';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM premium_price WHERE id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Dữ liệu không tồn tại...";
		$replace=array(
			'title'=>'Dữ liệu không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-premium'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_premium',$r_tt);
}else if($action=='list_search'){
	$thaythe['title']='Danh sách tìm kiếm';
	$thaythe['title_action']='Danh sách tìm kiếm';
	$limit=10;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM timkiem");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_timkiem'=>$class_index->list_timkiem($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-search')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_search',$bien);
}else if($action=='list_post'){
	$thaythe['title']='Danh sách bài viết';
	$thaythe['title_action']='Danh sách bài viết';
	$limit=10;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM post");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_baiviet'=>$class_index->list_baiviet($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-search')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_post',$bien);
}else if($action=='add_post'){
	$thaythe['title']='Thêm bài viết mới';
	$thaythe['title_action']='Thêm bài viết mới';
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_post',$r_tt);
}else if($action=='edit_post'){
	$thaythe['title']='Chỉnh sửa bài viết';
	$thaythe['title_action']='Chỉnh sửa bài viết';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM post WHERE id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Bài viết không tồn tại...";
		$replace=array(
			'title'=>'Bài viết không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-post'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_post',$r_tt);
}else if($action=='list_click-quangcao'){
	$thaythe['title']='Danh sách click quảng cáo';
	$thaythe['title_action']='Danh sách click quảng cáo';
	$limit=10;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM click_quangcao");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_click_quangcao'=>$class_index->list_click_quangcao($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-click-quangcao')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_click_quangcao',$bien);
}else if($action=='list_vitri-quangcao'){
	$thaythe['title']='Danh sách quảng cáo';
	$thaythe['title_action']='Danh sách quảng cáo';
	$limit=10;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM vitri_ads");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_vitri'=>$class_index->list_vitri_quangcao($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-vitri-quangcao')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_vitri_quangcao',$bien);
}else if($action=='add_vitri-quangcao'){
	$thaythe['title']='Thêm vị trí quảng cáo mới';
	$thaythe['title_action']='Thêm vị trí quảng cáo mới';
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_vitri_quangcao',$r_tt);
}else if($action=='edit_vitri-quangcao'){
	$thaythe['title']='Chỉnh sửa vị trí quảng cáo';
	$thaythe['title_action']='Chỉnh sửa vị trí quảng cáo';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM vitri_ads WHERE id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Dữ liệu không tồn tại...";
		$replace=array(
			'title'=>'Dữ liệu không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-vitri-quangcao'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_vitri_quangcao',$r_tt);
}else if($action=='list_slide'){
	$thaythe['title']='Danh sách slide';
	$thaythe['title_action']='Danh sách slide';
	$limit=10;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM slide");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_slide'=>$class_index->list_slide($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-slide')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_slide',$bien);
}else if($action=='add_slide'){
	$thaythe['title']='Thêm slide mới';
	$thaythe['title_action']='Thêm slide mới';
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_slide',$r_tt);
}else if($action=='edit_slide'){
	$thaythe['title']='Chỉnh sửa slide';
	$thaythe['title_action']='Chỉnh sửa slide';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM slide WHERE id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Dữ liệu không tồn tại...";
		$replace=array(
			'title'=>'Dữ liệu không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-slide'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_slide',$r_tt);
}else if($action=='add_phim'){
	$thaythe['title']='Thêm phim mới';
	$thaythe['title_action']='Thêm phim mới';
	$r_tt['option_category']=$class_index->list_div_category($conn,'');
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_phim',$r_tt);
}else if($action=='edit_phim'){
	$thaythe['title']='Chỉnh sửa phim';
	$thaythe['title_action']='Chỉnh sửa phim';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM phim WHERE id='$id'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Phim không tồn tại...";
		$replace=array(
			'title'=>'Phim không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-phim'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$r_tt['option_category']=$class_index->list_div_category($conn,$r_tt['category']);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_phim',$r_tt);
}else if($action=='list_tap'){
	$thaythe['title']='Danh sách tập';
	$thaythe['title_action']='Danh sách tập';
	$phim=preg_replace('/[^0-9]/', '', $url_query['phim']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM phim WHERE id='$phim' ORDER BY id DESC LIMIT 1");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Phim không tồn tại...";
		$replace=array(
			'title'=>'Phim không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-phim'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM list_tap WHERE phim='$phim'");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'tieu_de'=>$r_tt['tieu_de'],
		'phim'=>$phim,
		'list_tap'=>$class_index->list_tap($conn,$phim,$page,$limit),
		'phantrang'=>$class_index->phantrang_timkiem($page,$total_page,'/admincp/list-tap?phim='.$phim)
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_tap',$bien);
}else if($action=='add_chap-auto'){
	$thaythe['title']='Thêm chap mới auto';
	$thaythe['title_action']='Thêm chap mới auto';
	$truyen=preg_replace('/[^0-9]/', '', $url_query['truyen']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM truyen WHERE id='$truyen'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Video không tồn tại...";
		$replace=array(
			'title'=>'Video không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-truyen'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_chap_auto',$r_tt);
}else if($action=='add_tap'){
	$thaythe['title']='Thêm tập mới';
	$thaythe['title_action']='Thêm tập mới';
	$phim=preg_replace('/[^0-9]/', '', $url_query['phim']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM phim WHERE id='$phim'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Phim không tồn tại...";
		$replace=array(
			'title'=>'Phim không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-phim'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_tap',$r_tt);
}else if($action=='add_tap-nhanh'){
	$thaythe['title']='Thêm nhanh tập mới';
	$thaythe['title_action']='Thêm nhanh tập mới';
	$phim=preg_replace('/[^0-9]/', '', $url_query['phim']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM phim WHERE id='$phim'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Phim không tồn tại...";
		$replace=array(
			'title'=>'Phim không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-phim'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/add_tap_nhanh',$r_tt);
}else if($action=='edit_tap'){
	$thaythe['title']='Chỉnh sửa tập';
	$thaythe['title_action']='Chỉnh sửa tập';
	$phim=preg_replace('/[^0-9]/', '', $url_query['phim']);
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM phim WHERE id='$phim'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Phim không tồn tại...";
		$replace=array(
			'title'=>'Phim không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-phim'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$thongtin_tap=mysqli_query($conn,"SELECT * FROM list_tap WHERE id='$id' ORDER BY id DESC LIMIT 1");
	$r_c=mysqli_fetch_assoc($thongtin_tap);
	$r_c['ten_phim']=$r_tt['tieu_de'];
	$tach_server=json_decode("[".$r_c['server']."]",true);
	foreach ($tach_server as $key => $value) {
		$tt['server']=$value['server'];
		$tt['nguon']=$value['nguon'];
		$list.=$skin->skin_replace('skin_cpanel/box_action/li_server',$tt);
	}
	$r_c['list_server']=$list;
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/edit_tap',$r_c);
}else if($action=='contact_detail'){
	$thaythe['title']='Chi tiết liên hệ';
	$thaythe['title_action']='Chi tiết liên hệ';
	$id=preg_replace('/[^0-9]/', '', $url_query['id']);
	$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM contact WHERE id='$id' ORDER BY id DESC LIMIT 1");
	$r_tt=mysqli_fetch_assoc($thongtin);
	if($r_tt['total']==0){
		$thongbao="Liên hệ không tồn tại...";
		$replace=array(
			'title'=>'Liên hệ không tồn tại...',
			'description'=>$index_setting['description'],
			'thongbao'=>$thongbao,
			'link_chuyen'=>'/admincp/list-contact'
		);
		echo $skin->skin_replace('skin_cpanel/chuyenhuong',$replace);
		exit();
	}
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/contact_detail',$r_tt);
}else if($action=='list_setting'){
	$thaythe['title']='Danh sách cài đặt';
	$thaythe['title_action']='Danh sách cài đặt';
	$limit=100;
	$thongke=mysqli_query($conn,"SELECT count(*) AS total FROM index_setting");
	$r_tk=mysqli_fetch_assoc($thongke);
	$total_page=ceil($r_tk['total']/$limit);
	$bien=array(
		'list_setting'=>$class_index->list_setting($conn,$page,$limit),
		'phantrang'=>$class_index->phantrang($page,$total_page,'/admincp/list-setting')
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_setting',$bien);
}else if($action=='list_icon-1'){
	$thaythe['title']='Danh sách icon 1';
	$thaythe['title_action']='Danh sách icon 1';
	$x=file_get_contents('../skin_cpanel/css/font-awesome.min.css');
	preg_match_all('/\.fa-(.*?):before/', $x, $tach_icon);
	foreach ($tach_icon[1] as $key => $value) {
		$r_tt['icon']='fa fa-'.$value;
		$list.=$skin->skin_replace('skin_cpanel/box_action/li_icon',$r_tt);
	}
	$bien=array(
		'tieu_de'=>'Danh sách icon 1',
		'list_icon'=>$list
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_icon',$bien);
}else if($action=='list_icon-2'){
	$thaythe['title']='Danh sách icon 2';
	$thaythe['title_action']='Danh sách icon 2';
	$x=file_get_contents('../skin_cpanel/css/icomoon.min.css');
	preg_match_all('/\.icon-(.*?):before/', $x, $tach_icon);
	foreach ($tach_icon[1] as $key => $value) {
		$r_tt['icon']='icon icon-'.$value;
		$list.=$skin->skin_replace('skin_cpanel/box_action/li_icon',$r_tt);
	}
	$bien=array(
		'tieu_de'=>'Danh sách icon 2',
		'list_icon'=>$list
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_icon',$bien);
}else if($action=='list_icon-3'){
	$thaythe['title']='Danh sách icon 3';
	$thaythe['title_action']='Danh sách icon 3';
	$x=file_get_contents('../fonts/icofont/icofont/icofont.min.css');
	preg_match_all('/\.icofont-(.*?):before/', $x, $tach_icon);
	foreach ($tach_icon[1] as $key => $value) {
		$r_tt['icon']='icofont-'.$value;
		$list.=$skin->skin_replace('skin_cpanel/box_action/li_icon',$r_tt);
	}
	$bien=array(
		'tieu_de'=>'Danh sách icon 3',
		'list_icon'=>$list
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_icon',$bien);
}else if($action=='list_icon-4'){
	$thaythe['title']='Danh sách icon 4';
	$thaythe['title_action']='Danh sách icon 4';
	$x=file_get_contents('../skin_cpanel/css/font-glyphicon.css');
	preg_match_all('/\.glyphicon-(.*?):before/', $x, $tach_icon);
	foreach ($tach_icon[1] as $key => $value) {
		$r_tt['icon']='glyphicon glyphicon-'.$value;
		$list.=$skin->skin_replace('skin_cpanel/box_action/li_icon',$r_tt);
	}
	$bien=array(
		'tieu_de'=>'Danh sách icon 4',
		'list_icon'=>$list
	);
	$thaythe['box_right']=$skin->skin_replace('skin_cpanel/box_action/list_icon',$bien);
}else{

}
echo $skin->skin_replace('skin_cpanel/index',$thaythe);
?>