<?php
include './includes/tlca_world.php';
$check = $tlca_do->load('class_check');
$action = addslashes($_REQUEST['action']);
$skin = $tlca_do->load('class_skin');
$class_index = $tlca_do->load('class_index');
$setting = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s = mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']] = $r_s['value'];
}
if(isset($_COOKIE['user_id'])){
	$tach_token = json_decode($check->token_login_decode($_COOKIE['user_id']), true);
	$user_id = $tach_token['user_id'];
	$user_info = $class_member->user_info($conn, $_COOKIE['user_id']);
}
if ($action == 'tinhtrang' AND isset($_COOKIE['emin_id'])) {
	$id = intval($_REQUEST['id']);
	mysqli_query($conn, "UPDATE truyen SET truyen_status='1' WHERE truyen_id='$id'");

}else if($action=='update_view'){
	$phim=intval($_REQUEST['phim']);
	$thongtin_phim=mysqli_query($conn,"SELECT * FROM phim WHERE id='$phim'");
	$r_tt=mysqli_fetch_assoc($thongtin_phim);
	$view_new=$r_tt['luot_xem'] + 1;
	$hom_nay=date('d');
	$thang_nay=date('m');
	$nam_nay=date('Y');
	$date  = mktime(0, 0, 0, $thang_nay, $hom_nay, $nam_nay);
	$week  = (int)date('W', $date);
	if($hom_nay==$index_setting['day']){
		$view_day=$r_tt['view_day'] + 1;
	}else{
		$view_day=1;
		mysqli_query($conn,"UPDATE index_setting SET value='$hom_nay' WHERE name='day'");
		mysqli_query($conn,"UPDATE phim SET view_day='0'");
	}
	if($thang_nay==$index_setting['month']){
		$view_month=$r_tt['view_month'] + 1;
	}else{
		$view_month=1;
		mysqli_query($conn,"UPDATE index_setting SET value='$thang_nay' WHERE name='month'");
		mysqli_query($conn,"UPDATE phim SET view_month='0'");
	}
	if($nam_nay==$index_setting['year']){
		$view_year=$r_tt['view_year'] + 1;
	}else{
		$view_year=1;
		mysqli_query($conn,"UPDATE index_setting SET value='$nam_nay' WHERE name='year'");
		mysqli_query($conn,"UPDATE phim SET view_year='0'");
	}
	if($week==$index_setting['week']){
		$view_week=$r_tt['view_week'] + 1;
	}else{
		$view_week=1;
		mysqli_query($conn,"UPDATE index_setting SET value='$week' WHERE name='week'");
		mysqli_query($conn,"UPDATE phim SET view_week='0'");
	}
	mysqli_query($conn,"UPDATE phim SET luot_xem='$view_new',view_day='$view_day',view_week='$view_week',view_month='$view_month',view_year='$view_year' WHERE id='$phim'");
	$info=array(
		'ok'=>1
	);
	echo json_encode($info);
}else if($action=='load_box_pop'){
	$loai=addslashes($_REQUEST['loai']);
	if($loai=='box_pop_report'){
		$phim=intval($_REQUEST['phim']);
		$tap=intval($_REQUEST['tap']);
		$bien=array(
			'phim'=>$phim,
			'tap'=>$tap
		);
		$html=$skin->skin_replace('skin/box_pop_report',$bien);
		$info=array(
			'html'=>$html
		);
		echo json_encode($info);
	}

}else if($action=='report_error'){
	$phim=intval($_REQUEST['phim']);
	$tap=intval($_REQUEST['tap']);
	$loi=addslashes(strip_tags($_REQUEST['loi']));
	$hientai=time();
	if(intval($user_id)==0){
		$thongtin=mysqli_query("SELECT * FROM baoloi WHERE phim='$phim' AND tap='$tap' AND user_id='0'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			mysqli_query($conn,"INSERT INTO baoloi(user_id,phim,tap,loi,tinh_trang,date_post)VALUES('0','$phim','$tap','$loi','0','$hientai')");
		}else{
			
		}
	}else{
		$thongtin=mysqli_query($conn,"SELECT * FROM baoloi WHERE phim='$phim' AND tap='$tap' AND user_id='$user_id'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			mysqli_query($conn,"INSERT INTO baoloi(user_id,phim,tap,loi,tinh_trang,date_post)VALUES('$user_id','$phim','$tap','$loi','0','$hientai')");
		}
	}
	$info=array(
		'thongbao'=>'Cảm ơn bạn! Gửi báo lỗi thành công!'
	);
	echo json_encode($info);
}else if($action=='add_follow'){
	$phim=intval($_REQUEST['phim']);
	if(isset($_COOKIE['user_id'])){
		$thongtin=mysqli_query($conn,"SELECT * FROM follow WHERE phim='$phim' AND user_id='{$user_info['user_id']}'");
		$total=mysqli_num_rows($thongtin);
		if($total>0){
			$ok=1;
			$them=0;
			mysqli_query($conn,"DELETE FROM follow WHERE phim='$phim' AND user_id='{$user_info['user_id']}'");
			$thongbao='Bỏ theo dõi phim thành công';
		}else{
			$ok=1;
			$them=1;
			$thongbao='Theo dõi phim thành công';
			$hientai=time();
			mysqli_query($conn,"INSERT INTO follow (user_id,phim,date_post)VALUES('{$user_info['user_id']}','$phim','$hientai')");
		}
	}else{
		$ok=0;
		$thongbao='Vui lòng đăng nhập để theo dõi';
	}

	$info=array(
		'thongbao'=>$thongbao,
		'them'=>$them,
		'ok'=>$ok
	);
	echo json_encode($info);
}else if($action=='del_follow'){
	$phim=intval($_REQUEST['phim']);
	$ok=1;
	mysqli_query($conn,"DELETE FROM follow WHERE phim='$phim' AND user_id='{$user_info['user_id']}'");
	$thongbao='Bỏ theo dõi phim thành công';
	$info=array(
		'thongbao'=>$thongbao,
		'ok'=>$ok
	);
	echo json_encode($info);
}else if($action=='add_history'){
	$hientai=time();
	$phim=intval($_REQUEST['phim']);
	$tap=intval($_REQUEST['tap']);
	$ip_address=$_SERVER['REMOTE_ADDR'];
	if(isset($_COOKIE['user_id'])){
		$thongtin=mysqli_query($conn, "SELECT * FROM history WHERE phim='$phim'");
		$r_tt=mysqli_fetch_assoc($thongtin);
		$total=mysqli_num_rows($thongtin);
		if($total>0){
			mysqli_query($conn,"UPDATE history SET date_end='$hientai',tap='$tap' WHERE phim='$phim' AND user_id='$user_id'");
		}else{
			mysqli_query($conn,"INSERT INTO history(user_id,phim,tap,date_post,date_end,ip_address)VALUES('$user_id','$phim','$tap','$hientai','$hientai','$ip_address')");
		}
		$ok=1;
		$thongbao='Cập nhật lịch sử thành công';
	}else{
		$ok=0;
		$thongbao='Bạn chưa đăng nhập';
	}
	$info=array(
		'thongbao'=>$thongbao,
		'ok'=>$ok
	);
	echo json_encode($info);
}else if($action=='load_comment'){
	$hientai=time();
	$phim=intval($_REQUEST['phim']);
	$tap=intval($_REQUEST['tap']);
	$ip_address=$_SERVER['REMOTE_ADDR'];
	$limit=10;
	$page=intval($_REQUEST['page']);
	if($page<1){
		$page=1;
	}
	$thongtin=mysqli_query($conn,"SELECT * FROM comment WHERE phim='$phim' AND an='0'");
	$total_comment=mysqli_num_rows($thongtin);
	if($total_comment>0){
		if(isset($_COOKIE['user_id'])){
			$tach_comment=json_decode($class_index->list_comment($conn,$user_id,$phim,$page,$limit),true);
		}else{
			$tach_comment=json_decode($class_index->list_comment($conn,0,$phim,$page,$limit),true);
		}
		$list=$tach_comment['list'];
		$total=$tach_comment['total'];
	}else{
		$total=0;
		$list='';
	}
	if($total_comment==0){
		$total_comment='';
	}else{
		$total_comment='('.$total_comment.')';
	}
	if($page==1){
		if($total<$limit){
			$button_more='';
		}else{
			$button_more='<div class="flex flex-ver-center fw-700 load-more button-default bg-blue load_more_comment" phim="'.$phim.'" page="'.$page.'"><a href="javascript:;">Tải thêm bình luận</a></div>';
		}
		$list=$list.''.$button_more;
	}
	$info=array(
		'thongbao'=>$thongbao,
		'list'=>$list,
		'total_comment'=>$total_comment,
		'ok'=>$ok
	);
	echo json_encode($info);
}else if($action=='load_more_comment'){
	$hientai=time();
	$phim=intval($_REQUEST['phim']);
	$tap=intval($_REQUEST['tap']);
	$ip_address=$_SERVER['REMOTE_ADDR'];
	$limit=10;
	$page=intval($_REQUEST['page']);
	if($page<1){
		$page=1;
	}
	$thongtin=mysqli_query($conn,"SELECT * FROM comment WHERE phim='$phim' AND an='0'");
	$total_comment=mysqli_num_rows($thongtin);
	if($total_comment>0){
		if(isset($_COOKIE['user_id'])){
			$tach_comment=json_decode($class_index->list_comment($conn,$user_id,$phim,$page,$limit),true);
		}else{
			$tach_comment=json_decode($class_index->list_comment($conn,0,$phim,$page,$limit),true);
		}
		$list=$tach_comment['list'];
		$total=$tach_comment['total'];
	}else{
		$total=0;
		$list='';
	}
	if($total_comment==0){
		$total_comment='';
	}else{
		$total_comment='('.$total_comment.')';
	}
	if($total<$limit){
		$button_more='';
	}else{
		$button_more='<div class="flex flex-ver-center fw-700 load-more button-default bg-blue load_more_comment" phim="'.$phim.'" page="'.$page.'"><a href="javascript:;">Tải thêm bình luận</a></div>';
	}
	$info=array(
		'thongbao'=>$thongbao,
		'list'=>$list,
		'total_comment'=>$total_comment,
		'button_more'=>$button_more,
		'ok'=>$ok
	);
	echo json_encode($info);
}else if($action=='load_more_sub_comment'){
	$hientai=time();
	$phim=intval($_REQUEST['phim']);
	$tap=intval($_REQUEST['tap']);
	$reply=intval($_REQUEST['reply']);
	$ip_address=$_SERVER['REMOTE_ADDR'];
	$limit=3;
	$page=intval($_REQUEST['page']);
	if($page<1){
		$page=1;
	}
	$thongtin=mysqli_query($conn,"SELECT * FROM comment WHERE phim='$phim' AND reply='$reply' AND an='0'");
	$total_comment=mysqli_num_rows($thongtin);
	if($total_comment>0){
		if(isset($_COOKIE['user_id'])){
			$tach_comment=json_decode($class_index->list_reply_comment($conn,$user_id,$phim,$reply,$page,$limit),true);
		}else{
			$tach_comment=json_decode($class_index->list_reply_comment($conn,0,$phim,$reply,$page,$limit),true);
		}
		$list=$tach_comment['list'];
		$total=$tach_comment['total'];
	}else{
		$total=0;
		$list='';
	}
	if($total<$limit){
		$button_more='';
	}else{
		$button_more='<div class="flex flex-ver-center fw-700 load-more button-default bg-blue load_more_sub_comment" reply="'.$reply.'" phim="'.$phim.'" page="'.$page.'"><a href="javascript:;">Tải thêm bình luận</a></div>';
	}
	$info=array(
		'thongbao'=>$thongbao,
		'list'=>$list,
		'button_more'=>$button_more,
		'ok'=>$ok
	);
	echo json_encode($info);
}else if($action=='add_comment'){
	$phim=intval($_REQUEST['phim']);
	$tap=intval($_REQUEST['tap']);
	$noidung=addslashes(strip_tags($_REQUEST['noidung']));
	$hientai=time();
	if(!isset($_COOKIE['user_id'])){
		$ok=0;
		$thongbao='Thất bại! Bạn chưa đăng nhập';
	}else{
		if(strlen($noidung)<10){
			$ok=0;
			$thongbao='Thất bại! Nội dung quá ngắn';
		}else{
			mysqli_query($conn,"INSERT INTO comment(user_id,noidung,phim,tap,reply,an,date_post)VALUES('$user_id','$noidung','$phim','$tap','0','0','$hientai')");
			$ok=1;
			$thongbao='Gửi bình luận thành công';
		}
	}
	$thongtin=mysqli_query($conn,"SELECT * FROM comment WHERE phim='$phim'");
	$total_comment=mysqli_num_rows($thongtin);
	$thongtin_moi=mysqli_query($conn,"SELECT comment.*,user_info.name,user_info.avatar FROM comment INNER JOIN user_info ON comment.user_id=user_info.user_id WHERE comment.phim='$phim' AND comment.user_id='$user_id' AND comment.an='0' ORDER BY comment.id DESC LIMIT 1");
	$r_m=mysqli_fetch_assoc($thongtin_moi);
	$r_m['date_post']=$check->chat_update($r_m['date_post']);
	$r_m['list_sub_comment']='';
	$list=$skin->skin_replace('skin/box_li/li_comment_login_user', $r_m);
	if($total_comment==0){
		$total_comment='';
	}else{
		$total_comment='('.$total_comment.')';
	}
	$info=array(
		'thongbao'=>$thongbao,
		'list'=>$list,
		'total_comment'=>$total_comment,
		'ok'=>$ok
	);
	echo json_encode($info);
}else if($action=='add_sub_comment'){
	$phim=intval($_REQUEST['phim']);
	$tap=intval($_REQUEST['tap']);
	$comment_id=intval($_REQUEST['comment_id']);
	$noidung=addslashes(strip_tags($_REQUEST['noidung']));
	$hientai=time();
	if(!isset($_COOKIE['user_id'])){
		$ok=0;
		$thongbao='Thất bại! Bạn chưa đăng nhập';
	}else{
		if(strlen($noidung)<10){
			$ok=0;
			$thongbao='Thất bại! Nội dung quá ngắn';
		}else{
			mysqli_query($conn,"INSERT INTO comment(user_id,noidung,phim,tap,reply,an,date_post)VALUES('$user_id','$noidung','$phim','$tap','$comment_id','0','$hientai')");
			$ok=1;
			$thongbao='Gửi trả lời thành công';
		}
	}
	$thongtin=mysqli_query($conn,"SELECT * FROM comment WHERE phim='$phim'");
	$total_comment=mysqli_num_rows($thongtin);
	$thongtin_moi=mysqli_query($conn,"SELECT comment.*,user_info.name,user_info.avatar FROM comment INNER JOIN user_info ON comment.user_id=user_info.user_id WHERE comment.phim='$phim' AND comment.user_id='$user_id' AND comment.an='0' ORDER BY comment.id DESC LIMIT 1");
	$r_m=mysqli_fetch_assoc($thongtin_moi);
	$r_m['date_post']=$check->chat_update($r_m['date_post']);
	$r_m['list_sub_comment']='';
	$list=$skin->skin_replace('skin/box_li/li_sub_comment_login_user', $r_m);
	if($total_comment==0){
		$total_comment='';
	}else{
		$total_comment='('.$total_comment.')';
	}
	$info=array(
		'thongbao'=>$thongbao,
		'list'=>$list,
		'total_comment'=>$total_comment,
		'ok'=>$ok
	);
	echo json_encode($info);
}else if($action=='edit_comment'){
	$comment_id=intval($_REQUEST['comment_id']);
	$noidung=addslashes(strip_tags($_REQUEST['noidung']));
	if(isset($_COOKIE['user_id'])){
		$thongtin=mysqli_query($conn,"SELECT * FROM comment WHERE id='$comment_id' AND user_id='$user_id'");
		$total=mysqli_num_rows($thongtin);
		if($total>0){
			$ok=1;
			$thongbao='Lưu thay đổi thành công';
			mysqli_query($conn,"UPDATE comment SET noidung='$noidung' WHERE id='$comment_id' AND user_id='$user_id'");
		}else{
			$ok=0;
			$thongbao='Thật bại! Không thể thực hiện';
		}
	}else{
		$ok=0;
		$thongbao='Thất bại! Bạn chưa đăng nhập';

	}
	$info=array(
		'thongbao'=>$thongbao,
		'ok'=>$ok
	);
	echo json_encode($info);
}else if($action=='load_server'){
	$server=addslashes($_REQUEST['server']);
	$tap=intval($_REQUEST['tap']);
	$thongtin=mysqli_query($conn,"SELECT * FROM list_tap WHERE id='$tap'");
	$r_tt=mysqli_fetch_assoc($thongtin);
	$tach_server=json_decode('['.$r_tt['server'].']',true);
	foreach ($tach_server as $key => $value) {
		if($value['server']==$server){
			if(strpos($value['nguon'], 'youtube')!==false){
				if(strpos($value['nguon'], '/embed/')!==false){
					$link_video=$value['nguon'];
				}else{
					$param_video = parse_url($value['nguon']);
					parse_str($param_video['query'], $video_query);
					$link_video='https://www.youtube.com/embed/'.$video_query['v'];
				}
			} else if (strpos($value['nguon'], 'ok.ru') !== false) {
				$link_video = str_replace('/video/', '/videoembed/', $value['nguon']);
				$link_video=str_replace('/editor/', '/', $link_video);
			} else if (strpos($value['nguon'], 'dailymotion.com') !== false) {
				$link_video = str_replace('/video/', '/embed/video/', $value['nguon']);
			} else if (strpos($value['nguon'], 'https://dai.ly') !== false) {
				$tach_vd=explode('https://dai.ly/', $value['nguon']);
				$link_video = 'https://www.dailymotion.com/embed/video/'.$tach_vd[1];
			} else if (strpos($value['nguon'], 'hydrax') !== false) {
				$link_video = $value['nguon'];
			} else if (strpos($value['nguon'], 'short.ink') !== false) {
					$link_video = $value['nguon'];
			} else if (strpos($value['nguon'], 'facebook') !== false) {
				$link_video = 'https://www.facebook.com/plugins/video.php?href='.$value['nguon'].'&show_text=false&t=0';
			} else if (strpos($value['nguon'], 'obeywish.com') !== false) {
				$link_video = str_replace('obeywish.com/', 'obeywish.com/e/', $value['nguon']);
			} else if (strpos($value['nguon'], 'd0o0d.com') !== false) {
				$link_video = str_replace('d0o0d.com/d/', 'd0o0d.com/e/', $value['nguon']);
			} else if (strpos($value['nguon'], 'd000d.com') !== false) {
				$link_video = str_replace('d000d.com/d/', 'd000d.com/e/', $value['nguon']);
			} else if (strpos($value['nguon'], 'doodstream.com') !== false) {
				$link_video = str_replace('doodstream.com/d/', 'd0o0d.com/e/', $value['nguon']);
			}else if(strpos($value['nguon'], 'yanhh3d') !== false){
				$xxx=$check->getpage($value['nguon'],$value['nguon']);
				preg_match('/checkFbo = \'(.*?)\'/is', $xxx,$tach_link_fb);
				preg_match('/checkFb = "(.*?)"/is', $xxx,$tach_fb);
				preg_match('/checkHyd = "(.*?)"/is', $xxx,$tach_link_hh);
				preg_match('/checkOk = "(.*?)"/is', $xxx,$tach_link_ok);
				$link_fb=$tach_link_fb[1];
				$link_fb2=$tach_fb[1];
				$link_hh=$tach_link_hh[1];
				$link_ok=$tach_link_ok[1];
				if($link_fb!=''){
					$loai='js';
					$link_video=$link_fb;
				}else if($link_fb2!=''){
					$yyy=$check->getpage($link_fb2,'https://yanhh3d.com/');
					preg_match('/cccc = "(.*?)"/is', $yyy,$tach_media);
					$loai='js';
					$link_video=$tach_media[1];
				}else if($link_ok!=''){
					$link_video=$link_ok;
				}else if($link_hh!=''){
					$link_video=$link_hh;
				}else{
					$link_video='';
				}
			}else{
				$link_video=$value['nguon'];
			}
		}
	}
	if(strpos($link_video, 'youtube')!==false){
		$html='<div style="position: relative;padding-bottom: 56.25%"><iframe style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;overflow:hidden;" frameborder="0" src="'.$link_video.'" scrolling="0" allowfullscreen=""></iframe></div>';
	}else if($loai=='js'){
		$data_phim=array(
			'link_video'=>$link_video
		);
		$html=$skin->skin_replace('skin/js_player',$data_phim);
	}else if($link_video!=''){
		$html='<div style="position: relative;padding-bottom: 56.25%"><iframe style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;overflow:hidden;" frameborder="0" src="'.$link_video.'" scrolling="0" allowfullscreen=""></iframe></div>';
	}else{
		$html='<img src="/images/error.jpg">';
	}
	$info=array(
		'html'=>$html,
		'loai'=>$loai,
		'ok'=>1
	);
	echo json_encode($info);
}else if($action=='load_lichchieu'){
	$thu=intval($_REQUEST['thu']);
	$lich_chieu=$class_index->lich_chieu($conn,$thu);
	$info = array(
		'ok' => $ok,
		'list' => $lich_chieu,
	);
	echo json_encode($info);
}else if ($action == 'change_password') {
	$password = addslashes(strip_tags($_REQUEST['password_old']));
	$pass_new = addslashes(strip_tags($_REQUEST['password_new']));
	$confirm_password = addslashes(strip_tags($_REQUEST['re_password_new']));
	if(isset($_COOKIE['user_id'])){
		$pass_old=md5($password.''.$user_info['salt']);
		if($pass_old!=$user_info['password']){
			$ok=0;
			$thongbao='Mật khẩu hiện tại không đúng';
		}else if(strlen($pass_new)<6){
			$ok=0;
			$thongbao='Mật khẩu mới quá ngắn';
		}else if($pass_new!=$confirm_password){
			$ok=0;
			$thongbao='Nhập lại mật khẩu mới không khớp';
		}else{
			$pass=md5($pass_new.''.$user_info['salt']);
			mysqli_query($conn,"UPDATE user_info SET password='$pass' WHERE user_id='$user_id'");
			setcookie("user_id",$check->token_login($user_info['user_id'],$pass),time() + 2593000,'/');
			$ok=1;
			$thongbao='Đã lưu thay đổi thành công';
		}
	}else{
		$ok=0;
		$thongbao='Thất bại! Bạn chưa đăng nhập';
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
}else if($action=='edit_profile'){
	if(!isset($_COOKIE['user_id'])){
		echo json_encode(array('ok'=>0,'thongbao'=>'Bạn chưa đăng nhập...'));
		exit();
	}
	$name=addslashes(strip_tags($_REQUEST['name']));
	$duoi = $check->duoi_file($_FILES['file']['name']);
	$tach_token=json_decode($check->token_login_decode($_COOKIE['user_id']),true);
	$user_id=$tach_token['user_id'];
	$user_info=$class_member->user_info($conn,$_COOKIE['user_id']);
	if(strlen($name)<4){
		$ok=0;
		$thongbao='Tên hiển thị quá ngắn';
	}else{
		if(in_array($duoi, array('jpg','jpeg','png','gif'))==true){
			$minh_hoa='/uploads/avatar/'.$check->blank($name).'-'.time().'.'.$duoi;
		    move_uploaded_file($_FILES['file']['tmp_name'], '.'.$minh_hoa);
		    @unlink('.'.$user_info['avatar']);
			$thongbao='Thành công! Đã cập nhật thông tin';
			$ok=1;
			mysqli_query($conn,"UPDATE user_info SET name='$name',avatar='$minh_hoa' WHERE user_id='$user_id'");
		} else{
			$thongbao='Thành công! Đã cập nhật thông tin';
			$ok=1;
			mysqli_query($conn,"UPDATE user_info SET name='$name' WHERE user_id='$user_id'");
		}
	}
	$info=array(
		'ok'=>$ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);
}else if ($action == 'register') {
	$username = addslashes(strip_tags($_REQUEST['username']));
	$email = addslashes(strip_tags($_REQUEST['email']));
	$password = $_REQUEST['password'];
	$re_password = $_REQUEST['re_password'];
	$salt=$check->random_string(6);
	$hientai=time();
	$ip_address=$_SERVER['REMOTE_ADDR'];
	if (strlen($username) < 2) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập nick name';
	} else if (strlen($email) < 6) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập Email';
	} else if (strlen($password) < 6) {
		$ok = 0;
		$thongbao = 'Thất bại! Vui lòng nhập mật khẩu dài từ 6 ký tự';
	} else if ($password != $re_password) {
		$ok = 0;
		$thongbao = 'Thất bại! Xác nhận mật khẩu không khớp';
	} else {
		if ($check->check_email($email) == false) {
			$ok=0;
			$thongbao='Thất bại! Email không đúng định dạng';
		} else {
			$thongtin = mysqli_query($conn, "SELECT *,count(user_id) AS total FROM user_info WHERE email='$email'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] > 0) {
				$ok = 0;
				$thongbao = 'Thất bại! Địa chỉ email đã có trên hệ thống...';
			} else {
				$thongtin_username = mysqli_query($conn, "SELECT *,count(user_id) AS total FROM user_info WHERE username='$username'");
				$r_user = mysqli_fetch_assoc($thongtin_username);
				if($r_user['total']>0){
					$ok = 0;
					$thongbao = 'Thất bại! Tài khoản đã có trên hệ thống...';
				}else{
					$pass = md5($password.''.$salt);
					mysqli_query($conn, "INSERT INTO user_info(username,password,salt,email,name,canh_gioi,avatar,mobile,user_money,birthday,follow,active,created,ip_address,date_vip)VALUES('$username','$pass','$salt','$email','$username','','$avatar','$mobile','0','$birthday','','1','$hientai','$ip_address','$hientai')");
					$ok = 1;
					$thongbao = 'Chúc mừng! Bạn đã đăng ký thành công...';
				}
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
}else if ($action == 'forgot_password') {
	if (isset($_COOKIE['user_id'])) {
		echo json_encode(array('ok' => 0, 'thongbao' => 'Thất bại! Bạn đã đăng nhập...'));
		exit();
	}
	$email = addslashes(strip_tags($_REQUEST['email']));
	if ($check->check_email($email) == false) {
		$ok = 0;
		$thongbao = 'Email không đúng định dạng';
	} else {
		$thongtin_email = mysqli_query($conn, "SELECT *,count(user_id) AS total FROM user_info WHERE email='$email'");
		$r_tt = mysqli_fetch_assoc($thongtin_email);
		if ($r_tt['total'] == 0) {
			$ok = 0;
			$thongbao = 'Email không tồn tại trên hệ thống';
		} else {
			$code_active = $check->random_string(10);
			$passnew = $check->random_number(8);
			$link_active = $index_setting['link_domain'] . '/confirm_password.php?email=' . $email . '&token=' . $code_active;
			include_once "./class.phpmailer.php";
			$mailer = new PHPMailer(); // khởi tạo đối tượng
			$mailer->IsSMTP(); // gọi class smtp để đăng nhập
			$mailer->CharSet = "utf-8"; // bảng mã unicode
			$mailer->SMTPAuth = true; // gửi thông tin đăng nhập
			$mailer->SMTPSecure = "ssl"; // Giao thức SSL
			$mailer->Host = $index_setting['email_server']; // SMTP của GMAIL
			$mailer->Port = $index_setting['email_server_port']; // cổng SMTP
			$mailer->Username = $index_setting['email']; // GMAIL username
			$mailer->Password = $index_setting['email_password']; // GMAIL password
			$mailer->FromName = $index_setting['email_name']; // tên người gửi
			$mailer->From = $index_setting['email']; // mail người gửi
			$mailer->AddAddress($email, $r_tt['name']); //thêm mail của admin
			$mailer->Subject = 'Lấy lại mật khẩu';
			$mailer->IsHTML(true); //Bật HTML không thích thì false
			$mailer->Body = 'Mật khẩu mới của bạn tại ' . $index_setting['link_domain'] . ' là: ' . $passnew . ', vui lòng bấm vào link <a href="' . $link_active . '">' . $link_active . '</a> để xác nhận thay đổi';
			if ($mailer->Send() == true) {
				mysqli_query($conn, "INSERT INTO forgot_password (email,password,code_active,date_post)VALUES('$email','$passnew','$code_active'," . time() . ")");
				$ok = 1;
				$thongbao = 'Mật khẩu đã được gửi tới email của bạn';
			} else {
				$ok = 0;
				$thongbao = 'Gặp lỗi trong quá trình gửi mail';
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
}else {
	echo 'Not Action';
}
?>