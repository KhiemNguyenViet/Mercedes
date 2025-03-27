<?php
include '../includes/tlca_world.php';
include_once "../class.phpmailer.php";
$check = $tlca_do->load('class_check');
$action = addslashes($_REQUEST['action']);
$class_index = $tlca_do->load('class_cpanel');
$skin = $tlca_do->load('class_skin_cpanel');
$class_e_member = $tlca_do->load('class_e_member');
$setting = mysqli_query($conn, "SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s = mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']] = $r_s['value'];
}
if(isset($_COOKIE['emin_id'])){
	$tach_token = json_decode($check->token_login_decode($_COOKIE['emin_id']), true);
	$emin_id = $tach_token['user_id'];
	$emin_info = $class_e_member->user_info($conn, $emin_id);
}
if ($action == "dangnhap") {
	$username = addslashes(strip_tags($_REQUEST['username']));
	$password = addslashes($_REQUEST['password']);
	$remember = strip_tags(addslashes($_REQUEST['remember']));
	$ketqua = $class_e_member->login($conn, $username, $password, $remember);
	if ($ketqua == 200) {
		$ok = 1;
		$thongbao = "Đăng nhập thành công";
	} else if ($ketqua == 0) {
		$ok = 0;
		$thongbao = "Vui lòng nhập username";
	} else if ($ketqua == 1) {
		$ok = 0;
		$thongbao = "Tài khoản không tồn tại";
	} else if ($ketqua == 2) {
		$ok = 0;
		$thongbao = "Mật khẩu không chính xác";
	} else {
		$ok = 0;
		$thongbao = "Gặp lỗi khi xử lý";
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == 'load_napcoin') {
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
	} else {
		$ok = 1;
		$user_id = intval($_POST['user_id']);
		$page = intval($_REQUEST['page']);
		$limit = 100;
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT nap.*, user_info.username FROM nap LEFT JOIN user_info ON user_info.user_id=nap.user_id WHERE nap.user_id='$user_id' ORDER BY nap.id DESC LIMIT $start,$limit");
		$total = mysqli_num_rows($thongtin);
		if ($total == 0) {
			if ($page > 1) {
				$list = '<tr><td style="text-align:center" colspan="6">Không còn giao dịch nào!</td></tr>';
			} else {
				$list = '<tr><td style="text-align:center" colspan="6">Không có giao dịch nào!</td></tr>';
			}
			$phantrang = '';
		} else {
			$i = $start;
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$r_tt['coin'] = number_format($r_tt['coin']);
				$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
				$list .= $skin->skin_replace('skin_cpanel/box_action/tr_napcoin', $r_tt);
			}
			if ($total < $limit) {
				$phantrang = '';
			} else {
				$page++;
				$phantrang = '<button class="load_data" page="' . $page . '">Tải thêm</button>';
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'list' => $list,
		'phantrang' => $phantrang,
	);
	echo json_encode($info);
}else if($action=='goiy_phim'){
	$keyword=addslashes(strip_tags($_REQUEST['keyword']));
	$tach_keyword=explode(' ', $keyword);
	$k=0;
	foreach ($tach_keyword as $key => $value) {
		if($value!=''){
			$k++;
			if($k==1){
				$where_key.="tieu_de LIKE '%$value%'";
			}else{
				$where_key.=" AND tieu_de LIKE '%$value%'";
			}
		}
	}
	if(strlen($keyword)>2){
		$thongtin=mysqli_query($conn,"SELECT * FROM phim WHERE $where_key ORDER BY tieu_de ASC LIMIT 10");
		$list='';
		while($r_tt=mysqli_fetch_assoc($thongtin)){
			$list.='<div class="li_goiy goiy_phim" phim="'.$r_tt['id'].'">'.$r_tt['tieu_de'].'</div>';
		}
	}else{
		$list='';
	}
	$info = array(
		'list' => $list,
	);
	echo json_encode($info);
}else if($action=='add_lichchieu'){
	$list_phim=addslashes($_REQUEST['list_phim']);
	$list_thu=addslashes($_REQUEST['list_thu']);
	if(strpos($list_phim, ',')!==false){
		$tach_phim=explode(',', $list_phim);
		foreach ($tach_phim as $key => $value) {
			$thongtin=mysqli_query($conn,"SELECT * FROM lich_chieu WHERE phim='$value'");
			$total=mysqli_num_rows($thongtin);
			if($total==0){
				mysqli_query($conn,"INSERT INTO lich_chieu(phim,thu,an)VALUES('$value','$list_thu','0')");
			}else{
				mysqli_query($conn,"UPDATE lich_chieu SET thu='$list_thu' WHERE phim='$value'");
			}
		}
		$ok=1;
		$thongbao='Thêm lịch chiếu thành công';
	}else{
		$thongtin=mysqli_query($conn,"SELECT * FROM lich_chieu WHERE phim='$list_phim'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
			mysqli_query($conn,"INSERT INTO lich_chieu(phim,thu,an)VALUES('$list_phim','$list_thu','0')");
			$ok=1;
			$thongbao='Thêm lịch chiếu thành công';
		}else{
			mysqli_query($conn,"UPDATE lich_chieu SET thu='$list_thu' WHERE phim='$list_phim'");
			$ok=1;
			$thongbao='Cập nhật lịch thành công';
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);
}else if($action=='edit_lichchieu'){
	$list_phim=addslashes($_REQUEST['list_phim']);
	$list_thu=addslashes($_REQUEST['list_thu']);
	$an=intval($_REQUEST['an']);
	$thongtin=mysqli_query($conn,"SELECT * FROM lich_chieu WHERE phim='$list_phim'");
	$total=mysqli_num_rows($thongtin);
	if($total==0){
		mysqli_query($conn,"INSERT INTO lich_chieu(phim,thu,an)VALUES('$list_phim','$list_thu','0')");
		$ok=1;
		$thongbao='Thêm lịch chiếu thành công';
	}else{
		mysqli_query($conn,"UPDATE lich_chieu SET thu='$list_thu',an='$an' WHERE phim='$list_phim'");
		$ok=1;
		$thongbao='Cập nhật lịch thành công';
	}
	$info = array(
		'ok' => $ok,
		'thongbao'=>$thongbao
	);
	echo json_encode($info);
} else if ($action == 'load_donate') {
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
	} else {
		$ok = 1;
		$user_donate = intval($_POST['user_id']);
		$page = intval($_REQUEST['page']);
		if($page<1){
			$page=1;
		}
		$limit = 100;
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT * FROM donate WHERE user_id='$user_donate' ORDER BY id DESC LIMIT $start,$limit");
		$total = mysqli_num_rows($thongtin);
		if ($total == 0) {
			if ($page > 1) {
				$list = '<tr><td style="text-align:center" colspan="6">Không còn giao dịch nào!</td></tr>';
			} else {
				$list = '<tr><td style="text-align:center" colspan="6">Không có giao dịch nào!</td></tr>';
			}
			$phantrang = '';
		} else {
			$i = $start;
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$thongtin_nhan=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='{$r_tt['user_nhan']}'");
				$r_nhan=mysqli_fetch_assoc($thongtin_nhan);
				$i++;
				$r_tt['i'] = $i;
				$r_tt['coin'] = number_format($r_tt['coin']);
				$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
				if($r_tt['truyen']==0){
					$r_tt['noidung']='Donate cho nhóm : '.$r_nhan['name'];

				}else{
					$thongtin_truyen=mysqli_query($conn,"SELECT * FROM truyen WHERE id='{$r_tt['truyen']}'");
					$r_truyen=mysqli_fetch_assoc($thongtin_truyen);
					$r_tt['noidung']='Donate truyện: '.$r_truyen['tieu_de'];

				}
				$r_tt['name']=$r_nhan['name'];
				$list .= $skin->skin_replace('skin_cpanel/box_action/tr_donate', $r_tt);
			}
			if ($total < $limit) {
				$phantrang = '';
			} else {
				$page++;
				$phantrang = '<button class="load_data" page="' . $page . '">Tải thêm</button>';
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'list' => $list,
		'phantrang' => $phantrang,
	);
	echo json_encode($info);
} else if ($action == 'load_muachap') {
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
	} else {
		$ok = 1;
		$user_id = intval($_POST['user_id']);
		$page = intval($_REQUEST['page']);
		$limit = 100;
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT muachap.*, user_info.username, truyen.tieu_de, truyen.link, chap.link AS link_chap, chap.tieu_de AS tieude_chap FROM muachap LEFT JOIN user_info ON user_info.user_id=muachap.user_id LEFT JOIN truyen ON truyen.id=muachap.truyen LEFT JOIN chap ON muachap.chap=chap.id WHERE muachap.user_id='$user_id' ORDER BY muachap.id DESC LIMIT $start,$limit");
		$total = mysqli_num_rows($thongtin);
		if ($total == 0) {
			if ($page > 1) {
				$list = '<tr><td style="text-align:center" colspan="6">Không còn giao dịch nào!</td></tr>';
			} else {
				$list = '<tr><td style="text-align:center" colspan="6">Không có giao dịch nào!</td></tr>';
			}
			$phantrang = '';
		} else {
			$i = $start;
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$r_tt['coin'] = number_format($r_tt['coin']);
				$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
				$list .= $skin->skin_replace('skin_cpanel/box_action/tr_muachap', $r_tt);
			}
			if ($total < $limit) {
				$phantrang = '';
			} else {
				$page++;
				$phantrang = '<button class="load_data" page="' . $page . '">Tải thêm</button>';
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'list' => $list,
		'phantrang' => $phantrang,
	);
	echo json_encode($info);
} else if ($action == 'load_report') {
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
	} else {
		$ok = 1;
		$user_id = intval($_POST['user_id']);
		$page = intval($_REQUEST['page']);
		$limit = 100;
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT baoloi.*, truyen.tieu_de, truyen.link, user_info.username FROM baoloi LEFT JOIN truyen ON truyen.id=baoloi.truyen LEFT JOIN user_info ON user_info.user_id=baoloi.user_id WHERE baoloi.user_id='$user_id' ORDER BY baoloi.id DESC LIMIT $start,$limit");
		$total = mysqli_num_rows($thongtin);
		if ($total == 0) {
			if ($page > 1) {
				$list = '<tr><td style="text-align:center" colspan="7">Không còn báo lỗi nào!</td></tr>';
			} else {
				$list = '<tr><td style="text-align:center" colspan="7">Không có báo lỗi nào!</td></tr>';
			}
			$phantrang = '';
		} else {
			$i = $start;
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				$r_tt['date_post'] = date('d/m/Y', $r_tt['date_post']);
				if ($r_tt['tinh_trang'] == 1) {
					$r_tt['tinh_trang'] = 'Đã xác nhận';
				} else if ($r_tt['tinh_trang'] == 2) {
					$r_tt['tinh_trang'] = 'Đã fix';
				} else if ($r_tt['tinh_trang'] == 3) {
					$r_tt['tinh_trang'] = 'Báo sai';
				} else {
					$r_tt['tinh_trang'] = 'Mới';
				}
				$list .= $skin->skin_replace('skin_cpanel/box_action/tr_report', $r_tt);
			}
			if ($total < $limit) {
				$phantrang = '';
			} else {
				$page++;
				$phantrang = '<button class="load_data" page="' . $page . '">Tải thêm</button>';
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'list' => $list,
		'phantrang' => $phantrang,
	);
	echo json_encode($info);
} else if ($action == 'load_history') {
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
	} else {
		$ok = 1;
		$user_id = intval($_POST['user_id']);
		$page = intval($_REQUEST['page']);
		$limit = 100;
		$start = $page * $limit - $limit;
		$thongtin = mysqli_query($conn, "SELECT history.*, truyen.tieu_de AS truyen_tieude, truyen.link AS truyen_link, chap.tieu_de AS chap_tieude, chap.link AS chap_link, user_info.username FROM history LEFT JOIN truyen ON truyen.id=history.truyen LEFT JOIN user_info ON user_info.user_id=history.user_id LEFT JOIN chap ON chap.id=history.chap WHERE history.user_id='$user_id' ORDER BY history.id DESC LIMIT $start,$limit");
		$total = mysqli_num_rows($thongtin);
		if ($total == 0) {
			if ($page > 1) {
				$list = '<tr><td style="text-align:center" colspan="8">Không còn lịch sử nào!</td></tr>';
			} else {
				$list = '<tr><td style="text-align:center" colspan="8">Không có lịch sử nào!</td></tr>';
			}
			$phantrang = '';
		} else {
			$i = $start;
			while ($r_tt = mysqli_fetch_assoc($thongtin)) {
				$i++;
				$r_tt['i'] = $i;
				if (strlen($r_tt['chap_tieude']) > 1) {
					$r_tt['tieu_de'] = $r_tt['truyen_tieude'] . ' - ' . $r_tt['chap_tieude'];
					$r_tt['link_truyen'] = '/truyen-tranh/' . $r_tt['truyen_link'] . '/' . $r_tt['chap_link'] . '.html';
				} else {
					$r_tt['tieu_de'] = $r_tt['truyen_tieude'];
					$r_tt['link_truyen'] = '/truyen-tranh/' . $r_tt['truyen_link'] . '.html';
				}
				$r_tt['thoigian'] = $check->time_online($r_tt['date_end'] - $r_tt['date_post']);
				$r_tt['date_post'] = date('H:i:s d/m/Y', $r_tt['date_post']);
				$r_tt['date_end'] = date('H:i:s d/m/Y', $r_tt['date_end']);
				$list .= $skin->skin_replace('skin_cpanel/box_action/tr_history', $r_tt);
			}
			if ($total < $limit) {
				$phantrang = '';
			} else {
				$page++;
				$phantrang = '<button class="load_data" page="' . $page . '">Tải thêm</button>';
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'list' => $list,
		'phantrang' => $phantrang,
	);
	echo json_encode($info);
} else if ($action == 'add_post') {
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
		$title = addslashes(strip_tags($_REQUEST['title']));
		$description = addslashes(strip_tags($_REQUEST['description']));
		$noidung = addslashes($_REQUEST['noidung']);
		$duoi = $check->duoi_file($_FILES['file']['name']);
		if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif')) == true) {
			$minh_hoa = '/uploads/minh_hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
			move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
			$thongbao = 'Thêm bài viết thành công';
			$ok = 1;
			$minh_hoa = $index_setting['link_img'] . '' . $minh_hoa;
			$link=$check->blank($tieu_de);
			mysqli_query($conn, "INSERT INTO post(tieu_de,minh_hoa,link,noidung,title,description,view,date_post)VALUES('$tieu_de','$minh_hoa','$link','$noidung','$title','$description','0'," . time() . ")");
		} else {
			$thongbao = 'Vui lòng chọn ảnh minh họa';
			$ok = 0;
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'add_vitri_ads') {
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		$tieu_de=addslashes($_REQUEST['tieu_de']);
		$vi_tri=addslashes($_REQUEST['vi_tri']);
		$vi_tri=$check->blank($vi_tri);
		$coin = preg_replace('/[^0-9]/', '', $_REQUEST['coin']);
		$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM vitri_ads WHERE vi_tri='$vi_tri'");
		$r_tt = mysqli_fetch_assoc($thongtin);
		if ($r_tt['total'] > 0) {
			$ok = 0;
			$thongbao = 'Thất bại! Vị trí đã tồn tại';
		} else {
			$ok = 1;
			mysqli_query($conn,"INSERT INTO vitri_ads(tieu_de,coin,vi_tri)VALUES('$tieu_de','$coin','$vi_tri')");
			$thongbao = 'Thành công! Đã thêm vị trí quảng cáo';
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'edit_vitri_ads') {
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		$id=intval($_REQUEST['id']);
		$tieu_de=addslashes($_REQUEST['tieu_de']);
		$vi_tri=addslashes($_REQUEST['vi_tri']);
		$vi_tri=$check->blank($vi_tri);
		$coin = preg_replace('/[^0-9]/', '', $_REQUEST['coin']);
		$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM vitri_ads WHERE id='$id'");
		$r_tt = mysqli_fetch_assoc($thongtin);
		if ($r_tt['total'] > 0) {
			$thongtin_vitri=mysqli_query($conn,"SELECT * FROM vitri_ads WHERE vi_tri='$vi_tri'");
			$total_vitri=mysqli_num_rows($thongtin_vitri);
			if($total_vitri==0){
				mysqli_query($conn,"UPDATE vitri_ads SET tieu_de='$tieu_de',coin='$coin',vi_tri='$vi_tri' WHERE id='$id'");
				$ok=1;
				$thongbao='Thành công! Đã cập nhật thông tin';
			}else{
				$r_vt=mysqli_fetch_assoc($thongtin_vitri);
				if($r_vt['id']==$id){
					mysqli_query($conn,"UPDATE vitri_ads SET tieu_de='$tieu_de',coin='$coin',vi_tri='$vi_tri' WHERE id='$id'");
					$ok=1;
					$thongbao='Thành công! Đã cập nhật thông tin';
				}else{
					$ok=0;
					$thongbao='Thất bại! Vị trí đã tồn tại';

				}
			}
		} else {
			$ok=0;
			$thongbao='Thất bại! Dữ liệu không tồn tại';
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'add_coin') {
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		$user_id = intval($_REQUEST['user_id']);
		$coin = preg_replace('/[^0-9]/', '', $_REQUEST['coin']);
		$noidung = addslashes(strip_tags($_REQUEST['noidung']));
		$madon=rand(100000000, 999999999);
		$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE user_id='$user_id'");
		$r_tt = mysqli_fetch_assoc($thongtin);
		if ($r_tt['total'] > 0) {
			$moi = $r_tt['user_money'] + $coin;
			mysqli_query($conn, "UPDATE user_info SET user_money='$moi' WHERE user_id='$user_id'");
			mysqli_query($conn, "INSERT INTO nap(user_id,coin,noidung,status,madon,date_post)VALUES('$user_id','$coin','$noidung','1','$madon'," . time() . ")");
			$ok = 1;
			$thongbao = 'Đã thêm coin thành công';
		} else {
			$ok = 0;
			$thongbao = 'Thất bại! Thành viên không tồn tại';
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'add_napcoin') {
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		$madon=rand(100000000, 999999999);
		$user_id = addslashes($_REQUEST['username']);
		$coin = preg_replace('/[^0-9]/', '', $_REQUEST['coin']);
		$noidung = addslashes(strip_tags($_REQUEST['noidung']));
		$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE user_id='$user_id'");
		$r_tt = mysqli_fetch_assoc($thongtin);
		if ($r_tt['total'] > 0) {
			$moi = $r_tt['user_money'] + $coin;
			mysqli_query($conn, "UPDATE user_info SET user_money='$moi' WHERE user_id='$user_id'");
			mysqli_query($conn, "INSERT INTO nap(user_id,coin,noidung,status,madon,date_post)VALUES('$user_id','$coin','$noidung','1','$madon'," . time() . ")");
			$ok = 1;
			$thongbao = 'Đã thêm coin thành công';
		} else {
			$ok = 0;
			$thongbao = 'Thất bại! Thành viên không tồn tại';
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'add_block') {
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		$ip_address = addslashes($_REQUEST['ip_address']);
		$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM block_ip WHERE ip_address='$ip_address'");
		$r_tt = mysqli_fetch_assoc($thongtin);
		if ($r_tt['total'] > 0) {
			$ok = 0;
			$thongbao = 'ip này đã bị chặn';
		} else {
			$ok = 1;
			$thongbao = 'Chặn ip mới thành công';
			mysqli_query($conn, "INSERT INTO block_ip(ip_address,date_post)VALUES('$ip_address'," . time() . ")");
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'edit_napcoin') {
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		$username = addslashes($_REQUEST['username']);
		$coin = preg_replace('/[^0-9]/', '', $_REQUEST['coin']);
		$noidung = addslashes(strip_tags($_REQUEST['noidung']));
		$id = intval($_REQUEST['id']);
		$status=intval($_REQUEST['status']);
		$thongtin = mysqli_query($conn, "SELECT nap.*,count(*) AS total, user_info.user_money FROM nap LEFT JOIN user_info ON nap.user_id=user_info.user_id WHERE nap.id='$id'");
		$r_tt = mysqli_fetch_assoc($thongtin);
		if ($r_tt['total'] > 0) {
			if($status==1 AND $r_tt['status']==1){
				if ($coin > $r_tt['coin']) {
					$cong = $coin - $r_tt['coin'];
					$moi = $r_tt['user_money'] + $cong;
				} else {
					$tru = $r_tt['coin'] - $coin;
					$moi = $r_tt['user_money'] - $tru;
				}
				mysqli_query($conn, "UPDATE user_info SET user_money='$moi' WHERE user_id='{$r_tt['user_id']}'");
				mysqli_query($conn, "UPDATE nap SET coin='$coin',noidung='$noidung' WHERE id='$id'");
				$ok = 1;
				$thongbao = 'Chỉnh sửa nạp coin thành công';

			}else if($status==1 AND $r_tt['status']!=1){
				$moi = $r_tt['user_money'] + $coin;
				mysqli_query($conn, "UPDATE user_info SET user_money='$moi' WHERE user_id='{$r_tt['user_id']}'");
				mysqli_query($conn, "UPDATE nap SET coin='$coin',status='1',noidung='$noidung' WHERE id='$id'");
				$ok = 1;
				$thongbao = 'Chỉnh sửa nạp coin thành công';

			}else{
				mysqli_query($conn, "UPDATE nap SET coin='$coin',status='$status',noidung='$noidung' WHERE id='$id'");
				$ok = 1;
				$thongbao = 'Chỉnh sửa nạp coin thành công';
			}
		} else {
			$ok = 0;
			$thongbao = 'Thất bại! Giao dịch không tồn tại';
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'edit_report') {
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		$id = intval($_REQUEST['id']);
		$tinh_trang = intval($_REQUEST['tinh_trang']);
		$thongtin = mysqli_query($conn, "SELECT baoloi.*,count(*) AS total, user_info.user_money FROM baoloi LEFT JOIN user_info ON baoloi.user_id=user_info.user_id WHERE baoloi.id='$id'");
		$r_tt = mysqli_fetch_assoc($thongtin);
		if ($r_tt['total'] > 0) {
			if ($tinh_trang == 3 AND $r_tt['tinh_trang'] == 0) {
				$cong = $r_tt['user_money'] - 50;
				mysqli_query($conn, "UPDATE user_info SET user_money='$cong' WHERE user_id='{$r_tt['user_id']}'");
				mysqli_query($conn, "INSERT INTO nap(user_id,coin,noidung,date_post)VALUES('{$r_tt['user_id']}','-50','Trừ 50 coin do báo lỗi sai.'," . time() . ")");
				mysqli_query($conn, "UPDATE baoloi SET tinh_trang='$tinh_trang' WHERE id='$id'");
				$ok = 1;
				$thongbao = 'Cập nhật báo lỗi thành công';
			} else {
				if (($tinh_trang == 1 OR $tinh_trang == 2) AND $r_tt['tinh_trang'] == 0) {
					$cong = $r_tt['user_money'] + 50;
					mysqli_query($conn, "UPDATE user_info SET user_money='$cong' WHERE user_id='{$r_tt['user_id']}'");
					mysqli_query($conn, "INSERT INTO nap(user_id,coin,noidung,date_post)VALUES('{$r_tt['user_id']}','50','Cộng 50 coin do báo lỗi đúng'," . time() . ")");
					mysqli_query($conn, "UPDATE baoloi SET tinh_trang='$tinh_trang' WHERE id='$id'");
					$ok = 1;
					$thongbao = 'Cập nhật báo lỗi thành công';
				} else {
					if ($tinh_trang == 0 AND $r_tt['tinh_trang'] > 0) {
						$ok = 0;
						$thongbao = 'Thất bại! Không thể cập nhật về trạng thái mới';
					} else {
						$ok = 1;
						$thongbao = 'Cập nhật báo lỗi thành công';
						mysqli_query($conn, "UPDATE baoloi SET tinh_trang='$tinh_trang' WHERE id='$id'");
					}

				}
			}
		} else {
			$ok = 0;
			$thongbao = 'Thất bại! Báo lỗi không tồn tại';
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'edit_post') {
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
		$title = addslashes(strip_tags($_REQUEST['title']));
		$description = addslashes(strip_tags($_REQUEST['description']));
		$noidung = addslashes($_REQUEST['noidung']);
		$duoi = $check->duoi_file($_FILES['file']['name']);
		$id = intval($_REQUEST['id']);
		$thongtin = mysqli_query($conn, "SELECT * FROM post WHERE id='$id'");
		$r_tt = mysqli_fetch_assoc($thongtin);
		$link=$check->blank($tieu_de);
		if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif')) == true) {
			$minh_hoa = '/uploads/minh_hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
			move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
			$thongbao = 'Sửa bài viết thành công';
			$ok = 1;
			$minh_hoa = $index_setting['link_img'] . '' . $minh_hoa;
			mysqli_query($conn, "UPDATE post SET tieu_de='$tieu_de',minh_hoa='$minh_hoa',noidung='$noidung',link='$link',title='$title',description='$description' WHERE id='$id'");
			if (strpos($r_tt['minh_hoa'], $index_setting['link_img']) !== false) {
				@unlink(str_replace($index_setting['link_img'], '..', $r_tt['minh_hoa']));
			} else {
				@unlink('..' . $r_tt['minh_hoa']);

			}
		} else {
			mysqli_query($conn, "UPDATE post SET tieu_de='$tieu_de',noidung='$noidung',link='$link',title='$title',description='$description' WHERE id='$id'");
			$thongbao = 'Sửa bài viết thành công';
			$ok = 0;
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'add_tacgia') {
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
		$link = addslashes(strip_tags($_REQUEST['link']));
		$thu_tu = addslashes(strip_tags($_REQUEST['thu_tu']));
		$noidung = addslashes($_REQUEST['noidung']);
		$duoi = $check->duoi_file($_FILES['file']['name']);
		$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM seo WHERE link='$link'");
		$r_tt = mysqli_fetch_assoc($thongtin);
		if ($r_tt['total'] > 0) {
			$ok = 0;
			$thongbao = 'Link xem đã tồn tại';
		} else {
			if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif')) == true) {
				$minh_hoa = '/uploads/tac-gia/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
				move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
				$thongbao = 'Thêm tác giả thành công';
				$ok = 1;
				$minh_hoa = $index_setting['link_domain'] . '' . substr($minh_hoa, 1);
				mysqli_query($conn, "INSERT INTO tac_gia(tieu_de,link,minh_hoa,mo_ta,thu_tu)VALUES('$tieu_de','$link','$minh_hoa','$noidung','$thu_tu')");
				mysqli_query($conn, "INSERT INTO seo(loai,link) VALUES ('tacgia','$link')");
			} else {
				mysqli_query($conn, "INSERT INTO tac_gia(tieu_de,link,minh_hoa,mo_ta,thu_tu)VALUES('$tieu_de','$link','','$noidung','$thu_tu')");
				mysqli_query($conn, "INSERT INTO seo(loai,link) VALUES ('tacgia','$link')");
				$thongbao = 'Thêm tác giả thành công';
				$ok = 1;
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'edit_tacgia') {
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
		$link = addslashes(strip_tags($_REQUEST['link']));
		$link_old = addslashes(strip_tags($_REQUEST['link_old']));
		$thu_tu = addslashes(strip_tags($_REQUEST['thu_tu']));
		$noidung = addslashes($_REQUEST['noidung']);
		$duoi = $check->duoi_file($_FILES['file']['name']);
		$id = intval($_REQUEST['id']);
		$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM tac_gia WHERE id='$id'");
		$r_tt = mysqli_fetch_assoc($thongtin);
		if ($r_tt['total'] == 0) {
			$ok = 0;
			$thongbao = 'Tác giả không tồn tại';
		} else {
			if ($link_old == $link) {
				if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif')) == true) {
					$minh_hoa = '/uploads/tac-gia/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
					move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
					$thongbao = 'Sửa tác giả thành công';
					$ok = 1;
					$minh_hoa = $index_setting['link_domain'] . '' . substr($minh_hoa, 1);
					mysqli_query($conn, "UPDATE tac_gia SET tieu_de='$tieu_de',minh_hoa='$minh_hoa',mo_ta='$noidung',link='$link',thu_tu='$thu_tu' WHERE id='$id'");
					@unlink('..' . $r_tt['minh_hoa']);
				} else {
					mysqli_query($conn, "UPDATE tac_gia SET tieu_de='$tieu_de',mo_ta='$noidung',link='$link',thu_tu='$thu_tu' WHERE id='$id'");
					$thongbao = 'Sửa tác giả thành công';
					$ok = 1;
				}
			} else {
				$thongtin_seo = mysqli_query($conn, "SELECT *, count(*) AS total FROM seo WHERE link='$link'");
				$r_seo = mysqli_fetch_assoc($thongtin_seo);
				if ($r_seo['total'] > 0) {
					$ok = 0;
					$thongbao = 'Link xem đã tồn tại';
				} else {
					if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif')) == true) {
						$minh_hoa = '/uploads/tac-gia/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
						move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
						$thongbao = 'Sửa tác giả thành công';
						$ok = 1;
						$minh_hoa = $index_setting['link_domain'] . '' . substr($minh_hoa, 1);
						mysqli_query($conn, "UPDATE tac_gia SET tieu_de='$tieu_de',minh_hoa='$minh_hoa',mo_ta='$noidung',link='$link',thu_tu='$thu_tu' WHERE id='$id'");
						@unlink('..' . $r_tt['minh_hoa']);
						mysql_query("UPDATE seo SET link='$link' WHERE link='$link_old'");
					} else {
						mysqli_query($conn, "UPDATE tac_gia SET tieu_de='$tieu_de',mo_ta='$noidung',link='$link',thu_tu='$thu_tu' WHERE id='$id'");
						mysql_query("UPDATE seo SET link='$link' WHERE link='$link_old'");
						$thongbao = 'Sửa tác giả thành công';
						$ok = 1;
					}
				}
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'add_premium') {
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
		$price = preg_replace('/[^0-9]/', '', $_REQUEST['price']);
		$expired = preg_replace('/[^0-9]/', '', $_REQUEST['expired']);
		if (strlen($tieu_de)<2) {
			$ok = 0;
			$thongbao = 'Vui lòng nhập tên gói';
		}else if(intval($expired)<1){
			$ok=0;
			$thongbao='Vui lòng nhập số ngày premium';

		} else {
			mysqli_query($conn,"INSERT INTO premium_price(tieu_de,price,expired)VALUES('$tieu_de','$price','$expired')");
			$ok=1;
			$thongbao='Thêm gói premium thành công';
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'edit_premium') {
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
		$price = preg_replace('/[^0-9]/', '', $_REQUEST['price']);
		$expired = preg_replace('/[^0-9]/', '', $_REQUEST['expired']);
		$id=intval($_REQUEST['id']);
		if (strlen($tieu_de)<2) {
			$ok = 0;
			$thongbao = 'Vui lòng nhập tên gói';
		}else if(intval($expired)<1){
			$ok=0;
			$thongbao='Vui lòng nhập số ngày premium';

		} else {
			mysqli_query($conn,"UPDATE premium_price SET tieu_de='$tieu_de',price='$price',expired='$expired' WHERE id='$id'");
			$ok=1;
			$thongbao='Cập nhật gói premium thành công';
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == 'edit_thanhvien') {
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		$name = addslashes(strip_tags($_REQUEST['name']));
		$coin = preg_replace('/[^0-9]/', '', $_REQUEST['coin']);
		$donate = preg_replace('/[^0-9]/', '', $_REQUEST['donate']);
		$active = intval($_REQUEST['active']);
		$loai = intval($_REQUEST['loai']);
		$duoi = $check->duoi_file($_FILES['file']['name']);
		$id = intval($_REQUEST['id']);
		$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE user_id='$id'");
		$r_tt = mysqli_fetch_assoc($thongtin);
		if ($r_tt['total'] == 0) {
			$ok = 0;
			$thongbao = 'Thành viên không tồn tại';
		} else {
			if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif')) == true) {
				$minh_hoa = '/uploads/avatar/' . $check->blank($name) . '-' . time() . '.' . $duoi;
				move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
				$thongbao = 'Sửa thành viên thành công';
				$ok = 1;
				mysqli_query($conn, "UPDATE user_info SET name='$name',avatar='$minh_hoa',user_money='$coin',active='$active' WHERE user_id='$id'");
				@unlink('..' . $r_tt['avatar']);
			} else {
				mysqli_query($conn, "UPDATE user_info SET name='$name',user_money='$coin',active='$active' WHERE user_id='$id'");
				$thongbao = 'Sửa thành viên thành công';
				$ok = 1;
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);
} else if ($action == "edit_profile") {
	$name = strip_tags(addslashes($_REQUEST['name']));
	$mobile = preg_replace('/[^0-9]/', '', $_REQUEST['mobile']);
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if (strlen($name) < 2) {
			$thongbao = "Vui lòng nhập họ và tên";
			$ok = 0;
		} else {
			$user_id = $_COOKIE['emin_id'];
			mysqli_query($conn, "UPDATE emin_info SET name='$name',mobile='$mobile' WHERE id='$user_id'");
			$ok = 1;
			$thongbao = 'Sửa thông tin thành công!';
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == "edit_setting") {
	$name = preg_replace('/[^0-9a-zA-Z_-]/', '', $_REQUEST['name']);
	$noidung = addslashes($_REQUEST['noidung']);
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		mysqli_query($conn, "UPDATE index_setting SET value='$noidung' WHERE name='$name'");
		$ok = 1;
		$thongbao = 'Sửa cài đặt thành công!';
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == 'add_menu') {
	$loai = addslashes($_REQUEST['loai']);
	$tieu_de = addslashes($_REQUEST['tieu_de']);
	$link = addslashes($_REQUEST['link']);
	$target = addslashes($_REQUEST['target']);
	$thu_tu = intval($_REQUEST['thu_tu']);
	$main_id = intval($_REQUEST['main_id']);
	$col = intval($_REQUEST['col']);
	$category = addslashes($_REQUEST['category']);
	$page = addslashes($_REQUEST['page']);
	$post = addslashes($_REQUEST['post']);
	$vi_tri=addslashes($_REQUEST['vi_tri']);
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if ($loai == 'page') {
			if (strlen($tieu_de) < 2) {
				$ok = 0;
				$thongbao = 'Thất bại! Hãy nhập tiêu đề';
			} else {
				$ok = 1;
				$thongbao = 'Thêm menu thành công';
				mysqli_query($conn, "INSERT INTO menu (menu_main,menu_tieude,menu_cat,menu_link,menu_target,menu_thutu,menu_loai,menu_col,menu_vitri)VALUES('$main_id','$tieu_de','','$page','$target','$thu_tu','$loai','$col','$vi_tri')");
			}
		}else if ($loai == 'post') {
			if (strlen($tieu_de) < 2) {
				$ok = 0;
				$thongbao = 'Thất bại! Hãy nhập tiêu đề';
			} else {
				$ok = 1;
				$thongbao = 'Thêm menu thành công';
				mysqli_query($conn, "INSERT INTO menu (menu_main,menu_tieude,menu_cat,menu_link,menu_target,menu_thutu,menu_loai,menu_col,menu_vitri)VALUES('$main_id','$tieu_de','','$post','$target','$thu_tu','$loai','$col','$vi_tri')");
			}
		} else if ($loai == 'category') {
			if (strlen($tieu_de) < 2) {
				$ok = 0;
				$thongbao = 'Thất bại! Hãy nhập tiêu đề';
			} else {
				$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM category WHERE cat_id='$category' ORDER BY cat_id DESC LIMIT 1");
				$r_tt = mysqli_fetch_assoc($thongtin);
				if ($r_tt['total'] > 0) {
					$ok = 1;
					$thongbao = 'Thêm menu thành công';
					mysqli_query($conn, "INSERT INTO menu (menu_main,menu_tieude,menu_cat,menu_link,menu_target,menu_thutu,menu_loai,menu_col,menu_vitri)VALUES('$main_id','$tieu_de','$category','/the-loai/{$r_tt['cat_blank']}.html','$target','$thu_tu','$loai','$col','$vi_tri')");
				} else {
					$ok = 0;
					$thongbao = 'Thất bại! Thể loại được chọn không tồn tại';

				}
			}
		} else {
			if (strlen($tieu_de) < 2) {
				$ok = 0;
				$thongbao = 'Thất bại! Hãy nhập tiêu đề';
			} else {
				$ok = 1;
				$thongbao = 'Thêm menu thành công';
				mysqli_query($conn, "INSERT INTO menu (menu_main,menu_tieude,menu_cat,menu_link,menu_target,menu_thutu,menu_loai,menu_col,menu_vitri)VALUES('$main_id','$tieu_de','','$link','$target','$thu_tu','$loai','$col','$vi_tri')");
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == 'edit_menu') {
	$loai = addslashes($_REQUEST['loai']);
	$tieu_de = addslashes($_REQUEST['tieu_de']);
	$link = addslashes($_REQUEST['link']);
	$target = addslashes($_REQUEST['target']);
	$thu_tu = intval($_REQUEST['thu_tu']);
	$main_id = intval($_REQUEST['main_id']);
	$col = intval($_REQUEST['col']);
	$category = addslashes($_REQUEST['category']);
	$page = addslashes($_REQUEST['page']);
	$post = addslashes($_REQUEST['post']);
	$vi_tri=addslashes($_REQUEST['vi_tri']);
	$id = intval($_REQUEST['id']);
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if ($loai == 'page') {
			if (strlen($tieu_de) < 2) {
				$ok = 0;
				$thongbao = 'Thất bại! Hãy nhập tiêu đề';
			} else {
				$ok = 1;
				$thongbao = 'sửa menu thành công';
				mysqli_query($conn, "UPDATE menu SET menu_main='$main_id',menu_tieude='$tieu_de',menu_cat='',menu_link='$page',menu_target='$target',menu_thutu='$thu_tu',menu_col='$col',menu_loai='$loai',menu_vitri='$vi_tri' WHERE menu_id='$id'");
			}
		}else if ($loai == 'post') {
			if (strlen($tieu_de) < 2) {
				$ok = 0;
				$thongbao = 'Thất bại! Hãy nhập tiêu đề';
			} else {
				$ok = 1;
				$thongbao = 'sửa menu thành công';
				mysqli_query($conn, "UPDATE menu SET menu_main='$main_id',menu_tieude='$tieu_de',menu_cat='',menu_link='$post',menu_target='$target',menu_thutu='$thu_tu',menu_col='$col',menu_loai='$loai',menu_vitri='$vi_tri' WHERE menu_id='$id'");
			}
		} else if ($loai == 'category') {
			if (strlen($tieu_de) < 2) {
				$ok = 0;
				$thongbao = 'Thất bại! Hãy nhập tiêu đề';
			} else {
				$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM category WHERE cat_id='$category' ORDER BY cat_id DESC LIMIT 1");
				$r_tt = mysqli_fetch_assoc($thongtin);
				if ($r_tt['total'] > 0) {
					$ok = 1;
					$thongbao = 'Sửa menu thành công';
					mysqli_query($conn, "UPDATE menu SET menu_main='$main_id',menu_tieude='$tieu_de',menu_cat='$category',menu_link='/the-loai/{$r_tt['cat_blank']}.html',menu_target='$target',menu_thutu='$thu_tu',menu_col='$col',menu_loai='$loai',menu_vitri='$vi_tri' WHERE menu_id='$id'");
				} else {
					$ok = 0;
					$thongbao = 'Thất bại! Thể loại được chọn không tồn tại';

				}
			}
		} else {
			if (strlen($tieu_de) < 2) {
				$ok = 0;
				$thongbao = 'Thất bại! Hãy nhập tiêu đề';
			} else {
				$ok = 1;
				$thongbao = 'Sửa menu thành công';
				mysqli_query($conn, "UPDATE menu SET menu_main='$main_id',menu_tieude='$tieu_de',menu_cat='',menu_link='$link',menu_target='$target',menu_thutu='$thu_tu',menu_col='$col',menu_loai='$loai',menu_vitri='$vi_tri' WHERE menu_id='$id'");
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if($action=='get_folder'){
	$folder=addslashes($_REQUEST['folder']);
	$domain=addslashes($_REQUEST['domain']);
	$taikhoan=addslashes($_REQUEST['taikhoan']);
	$limit=intval($_REQUEST['limit']);
	$page=intval($_REQUEST['page']);
	if($domain=='streamwish.com'){
		$get_file='https://api.streamwish.com/api/folder/list?key=10256k872ft4dxxjd51bx&fld_id='.$folder.'&files=1';
		$xxx=$check->getpage($get_file,$get_file);
		//$tach_xxx=json_decode($xxx,true);
		// Chuyển chuỗi JSON thành mảng PHP
		$data = json_decode($xxx, true);
		// Kiểm tra xem "files" có tồn tại không
		if (isset($data['result']['files'])) {
		    // Sắp xếp mảng theo trường "title"
		    usort($data['result']['files'], function ($a, $b) {
		        return strcmp($a['title'], $b['title']);
		    });
		    $x=0;
		    foreach ($data['result']['files'] as $key => $value) {
		    	$x++;
		    	$tach_tap=explode('Tập', $value['title']);
		    	$tach_so=explode(' ', trim($tach_tap[1]));
		    	$tap=$tach_so[0];
		    	$list.='<div>'.$x.': '.$value['title'].'</div><div class="li_input_server"><div class="input_name"><input type="text" autocomplete="off" name="tieu_de" value="'.$tap.'" placeholder="Nhập tên tập"></div><div class="input_thutu"><input type="text" name="thu_tu" placeholder="Nhập thứ tự" value="'.$tap.'"></div><div class="input_link"><input type="text" name="link_video" value="'.$value['link'].'" placeholder="Nhập link video"></div><div class="input_del"><button>Xóa</button></div></div>';
		    }
		} else {
		}
	}else if($domain=='doodstream.com'){
		if($taikhoan=='videofull'){
			$get_file='https://doodapi.com/api/file/list?key=342022d70sr962zqpml6y8&fld_id='.$folder.'&per_page='.$limit.'&page='.$page;
			$xxx=$check->getpage($get_file,$get_file);
			//$tach_xxx=json_decode($xxx,true);
			// Chuyển chuỗi JSON thành mảng PHP
			$data = json_decode($xxx, true);
			if (isset($data['result']['files'])) {
			    // Sắp xếp mảng theo trường "title"
			    usort($data['result']['files'], function ($a, $b) {
			        return strcmp($a['title'], $b['title']);
			    });
			    $x=0;
			    foreach ($data['result']['files'] as $key => $value) {
			    	$x++;
			    	$tach_tap=explode('Tập', $value['title']);
			    	$tach_so=explode(' ', trim($tach_tap[1]));
			    	$tap=$tach_so[0];
			    	$list.='<div>'.$x.': '.$value['title'].'</div><div class="li_input_server"><div class="input_name"><input type="text" autocomplete="off" name="tieu_de" value="'.$tap.'" placeholder="Nhập tên tập"></div><div class="input_thutu"><input type="text" name="thu_tu" placeholder="Nhập thứ tự" value="'.$tap.'"></div><div class="input_link"><input type="text" name="link_video" value="'.$value['download_url'].'" placeholder="Nhập link video"></div><div class="input_del"><button>Xóa</button></div></div>';
			    }
			} else {
			}
		}else if($taikhoan=='docthaudem'){
			$get_file='https://doodapi.com/api/file/list?key=340992hgnb8ymboqmdbq95&fld_id='.$folder.'&per_page='.$limit.'&page='.$page;
			$xxx=$check->getpage($get_file,$get_file);
			//$tach_xxx=json_decode($xxx,true);
			// Chuyển chuỗi JSON thành mảng PHP
			$data = json_decode($xxx, true);
			// Kiểm tra xem "files" có tồn tại không
			if (isset($data['result']['files'])) {
			    // Sắp xếp mảng theo trường "title"
			    usort($data['result']['files'], function ($a, $b) {
			        return strcmp($a['title'], $b['title']);
			    });
			    $x=0;
			    foreach ($data['result']['files'] as $key => $value) {
			    	$x++;
			    	$tach_tap=explode('Tập', $value['title']);
			    	$tach_so=explode(' ', trim($tach_tap[1]));
			    	$tap=$tach_so[0];
			    	$list.='<div>'.$x.': '.$value['title'].'</div><div class="li_input_server"><div class="input_name"><input type="text" autocomplete="off" name="tieu_de" value="'.$tap.'" placeholder="Nhập tên tập"></div><div class="input_thutu"><input type="text" name="thu_tu" placeholder="Nhập thứ tự" value="'.$tap.'"></div><div class="input_link"><input type="text" name="link_video" value="'.$value['download_url'].'" placeholder="Nhập link video"></div><div class="input_del"><button>Xóa</button></div></div>';
			    }
			} else {
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'list'=>$list
	);
	echo json_encode($info);
} else if ($action == 'add_tap_nhanh') {
	$list_tap = $_REQUEST['list_tap'];
	$phim=intval($_REQUEST['phim']);
	$tach_list_tap=json_decode('['.$list_tap.']',true);
	foreach ($tach_list_tap as $key => $value) {
		$tieu_de=$value['tieu_de'];
		$thu_tu=intval($value['thu_tu']);
		$link_video=$value['link_video'];
		if(strpos($tieu_de, 'Tập')!==false OR strpos($tieu_de, 'TẬP')!==false OR strpos($tieu_de, 'tập')!==false){
		}else{
			$tieu_de='Tập '.$tieu_de;
		}
		$thongtin=mysqli_query($conn,"SELECT * FROM list_tap WHERE phim='$phim' AND tieu_de='$tieu_de'");
		$total=mysqli_num_rows($thongtin);
		if($total==0){
            if(strpos($link_video, 'ok.ru')!==false){
                $ten_server='OK';
            }else if(strpos($link_video, 'dai.ly')!==false){
                $ten_server='DL';
            }else if(strpos($link_video, 'dailymotion')!==false){
                $ten_server='DL';
            }else if(strpos($link_video, 'youtube')!==false){
                $ten_server='YT';
            }else if(strpos($link_video, 'xfast')!==false){
                $ten_server='XF';
            }else if(strpos($link_video, 'short.ink')!==false){
                $ten_server='HH';
            }else if(strpos($link_video, 'obeywish.com')!==false){
                $ten_server='SW';
            }else if(strpos($link_video, 'd0o0d.com')!==false){
                $ten_server='DO';
            }else if(strpos($link_video, 'doodstream.com')!==false){
                $ten_server='DO';
            }else if(strpos($link_video, 'helvid.com')!==false){
                $ten_server='HEL';
            }else{
            	$ten_server='OT';
            }
            $hientai=time();
			$list_server='{"server":"'.$ten_server.'","nguon":"'.$link_video.'"}';
			mysqli_query($conn, "INSERT INTO list_tap(tieu_de,phim,server,thu_tu,date_post)VALUES('$tieu_de','$phim','$list_server','$thu_tu','$hientai')");
			mysqli_query($conn, "UPDATE phim SET update_post='$hientai',tap_moi='$tieu_de' WHERE id='$phim'");

		}else{
            if(strpos($link_video, 'ok.ru')!==false){
                $ten_server='OK';
            }else if(strpos($link_video, 'dai.ly')!==false){
                $ten_server='DL';
            }else if(strpos($link_video, 'dailymotion')!==false){
                $ten_server='DL';
            }else if(strpos($link_video, 'youtube')!==false){
                $ten_server='YT';
            }else if(strpos($link_video, 'xfast')!==false){
                $ten_server='XF';
            }else if(strpos($link_video, 'short.ink')!==false){
                $ten_server='HH';
            }else if(strpos($link_video, 'obeywish.com')!==false){
                $ten_server='SW';
            }else if(strpos($link_video, 'd0o0d.com')!==false){
                $ten_server='DO';
            }else if(strpos($link_video, 'doodstream.com')!==false){
                $ten_server='DO';
            }else if(strpos($link_video, 'helvid.com')!==false){
                $ten_server='HEL';
            }else{
            	$ten_server='OT';
            }
            $r_tt=mysqli_fetch_assoc($thongtin);
            if(strpos($r_tt['server'], $link_video)!==false OR strpos(str_replace('/d/', '/e/',$r_tt['server']), $link_video)!==false){

            }else{
	            $list_server=$r_tt['server'].',{"server":"'.$ten_server.'","nguon":"'.$link_video.'"}';
	            mysqli_query($conn,"UPDATE list_tap SET server='$list_server' WHERE id='{$r_tt['id']}'");
            }

		}
	}	
	$ok = 1;
	$thongbao = 'Thêm tập mới thành công!';
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == 'add_tap') {
	$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
	if(strpos($tieu_de, 'Tập')!==false OR strpos($tieu_de, 'TẬP')!==false OR strpos($tieu_de, 'tập')!==false){
	}else{
		$tieu_de='Tập '.$tieu_de;
	}
	$link = $check->blank($tieu_de);
	$thu_tu = intval($_REQUEST['thu_tu']);
	$phim = intval($_REQUEST['phim']);
	$list_server = addslashes($_REQUEST['list_server']);
	$hientai = time();
	mysqli_query($conn, "INSERT INTO list_tap(tieu_de,phim,server,thu_tu,date_post)VALUES('$tieu_de','$phim','$list_server','$thu_tu','$hientai')");
	$id = mysqli_insert_id($conn);
	mysqli_query($conn, "UPDATE phim SET update_post='$hientai',tap_moi='$tieu_de' WHERE id='$phim'");
	$ok = 1;
	$thongbao = 'Thêm tập mới thành công!';
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == 'edit_tap') {
	$tieu_de = addslashes(strip_tags($_REQUEST['tieu_de']));
	if(strpos($tieu_de, 'Tập')!==false OR strpos($tieu_de, 'TẬP')!==false OR strpos($tieu_de, 'tập')!==false){
	}else{
		$tieu_de='Tập '.$tieu_de;
	}
	$thu_tu = intval($_REQUEST['thu_tu']);
	$phim = intval($_REQUEST['phim']);
	$id = intval($_REQUEST['id']);
	$list_server = addslashes($_REQUEST['list_server']);
	$hientai = time();
	mysqli_query($conn, "UPDATE list_tap SET phim='$phim',tieu_de='$tieu_de',server='$list_server',thu_tu='$thu_tu' WHERE id='$id'");
	$ok = 1;
	$thongbao = 'Sửa tập phim thành công!';
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == "add_phim") {
	$tieu_de = strip_tags(addslashes($_REQUEST['tieu_de']));
	$ten_khac = strip_tags(addslashes($_REQUEST['ten_khac']));
	$category = addslashes($_REQUEST['category']);
	$link = strip_tags(addslashes($_REQUEST['link']));
	$link_copy = strip_tags(addslashes($_REQUEST['link_copy']));
	$tags = addslashes($_REQUEST['tags']);
	$hot = intval($_REQUEST['hot']);
	$full = intval($_REQUEST['full']);
	$moi = intval($_REQUEST['moi']);
	$loai_hinh = addslashes($_REQUEST['loai_hinh']);
	$thoi_luong = addslashes($_REQUEST['thoi_luong']);
	$nam = addslashes($_REQUEST['nam']);
	$noidung = addslashes($_REQUEST['noidung']);
	$title = strip_tags(addslashes($_REQUEST['title']));
	$description = strip_tags(addslashes($_REQUEST['description']));
	$tags = strip_tags(addslashes($_REQUEST['tags']));
	$duoi = $check->duoi_file($_FILES['file']['name']);
	$hientai=time();
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if ($tieu_de == '') {
			$ok = 0;
			$thongbao = 'Vui lòng nhập tiêu đề';
		} else if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'jpe')) == false) {
			$ok = 0;
			$thongbao = 'Vui lòng chọn ảnh minh họa';
		} else {
			$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM seo WHERE link='$link' AND loai='phim'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 1;
				$ngay = intval(date('d'));
				$thongbao = 'Thêm phim thành công';
				$tieu_de = trim($tieu_de);
				$minh_hoa = '/uploads/minh_hoa/' . $link . '-' . time() . '.' . $duoi;
				move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
				mysqli_query($conn, "INSERT INTO phim (user_id,tieu_de,ten_khac,category,link,link_copy,tags,minh_hoa,content,thich,luot_xem,view_day,view_week,view_month,view_year,title,description,tap_moi,full,loai_hinh,hot,moi,thoi_luong,nam,rate,rate_number,date_post,update_post,follow,crawl,ngay)VALUES('$emin_id','$tieu_de','$ten_khac','$category','$link','$link_copy','$tags','$minh_hoa','$noidung','0','0','0','0','0','0','$title','$description','','$full','$loai_hinh','$hot','$moi','$thoi_luong','$nam','0','0','$hientai','$hientai','0','0','$ngay')");
				mysqli_query($conn, "INSERT INTO seo (loai,link)VALUES('phim','$link')");
			} else {
				$ok = 0;
				$thongbao = "Link xem đã tồn tại";
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == "edit_phim") {
	$tieu_de = strip_tags(addslashes($_REQUEST['tieu_de']));
	$ten_khac = strip_tags(addslashes($_REQUEST['ten_khac']));
	$category = addslashes($_REQUEST['category']);
	$link = strip_tags(addslashes($_REQUEST['link']));
	$link_old = strip_tags(addslashes($_REQUEST['link_old']));
	$link_copy = strip_tags(addslashes($_REQUEST['link_copy']));
	$loai_hinh = strip_tags(addslashes($_REQUEST['loai_hinh']));
	$tags = addslashes($_REQUEST['tags']);
	$hot = intval($_REQUEST['hot']);
	$full = intval($_REQUEST['full']);
	$moi = intval($_REQUEST['moi']);
	$thoi_luong = addslashes($_REQUEST['thoi_luong']);
	$nam = addslashes($_REQUEST['nam']);
	$noidung = addslashes($_REQUEST['noidung']);
	$title = strip_tags(addslashes($_REQUEST['title']));
	$description = strip_tags(addslashes($_REQUEST['description']));
	$tags = strip_tags(addslashes($_REQUEST['tags']));
	$duoi = $check->duoi_file($_FILES['file']['name']);
	$hientai = time();
	$id = intval($_REQUEST['id']);
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if ($tieu_de == '') {
			$ok = 0;
			$thongbao = 'Vui lòng nhập tiêu đề';
		} else {
			$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM phim WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] > 0) {
				if ($link_old == $link) {
					$ok = 1;
					$thongbao = 'Sửa phim thành công';
					$tieu_de = trim($tieu_de);
					$tieude_search = $check->check_length($check->tieude_en($tieu_de));
					if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'jpe')) == true) {
						$minh_hoa = '/uploads/minh_hoa/' . $link . '-' . time() . '.' . $duoi;
						move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
						@unlink('..'.$r_tt['minh_hoa']);
					} else {
						$minh_hoa = $r_tt['minh_hoa'];
					}
					mysqli_query($conn, "UPDATE phim SET tieu_de='$tieu_de',ten_khac='$ten_khac',category='$category',link='$link',link_copy='$link_copy',tags='$tags',minh_hoa='$minh_hoa',content='$noidung',title='$title',description='$description',hot='$hot',full='$full',loai_hinh='$loai_hinh',moi='$moi',thoi_luong='$thoi_luong',nam='$nam' WHERE id='$id'");

				} else {
					$thongtin_seo = mysqli_query($conn, "SELECT *,count(*) AS total FROM seo WHERE link='$link' AND loai='phim'");
					$r_seo = mysqli_fetch_assoc($thongtin_seo);
					if ($r_seo['total'] > 0) {
						$ok = 0;
						$thongbao = 'Link xem đã tồn tại';
					} else {
						$ok = 1;
						$thongbao = 'Sửa phim thành công';
						$tieu_de = trim($tieu_de);
						$tieude_search = $check->check_length($check->tieude_en($tieu_de));
						if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'jpe')) == true) {
							$minh_hoa = '/uploads/minh_hoa/' . $link . '-' . time() . '.' . $duoi;
							move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
							@unlink('..'.$r_tt['minh_hoa']);
						} else {
							$minh_hoa = $r_tt['minh_hoa'];
						}
						mysqli_query($conn, "UPDATE phim SET tieu_de='$tieu_de',ten_khac='$ten_khac',category='$category',link='$link',link_copy='$link_copy',tags='$tags',minh_hoa='$minh_hoa',content='$noidung',title='$title',description='$description',hot='$hot',full='$full',loai_hinh='$loai_hinh',moi='$moi',thoi_luong='$thoi_luong',nam='$nam' WHERE id='$id'");
						mysqli_query($conn, "UPDATE seo SET link='$link' WHERE link='$link_old'");

					}

				}
			} else {
				$ok = 0;
				$thongbao = "Phim này không tồn tại";
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == "add_slide") {
	$tieu_de = strip_tags(addslashes($_REQUEST['tieu_de']));
	$link = strip_tags(addslashes($_REQUEST['link']));
	$target = addslashes($_REQUEST['target']);
	$thu_tu = intval($_REQUEST['thu_tu']);
	$duoi = $check->duoi_file($_FILES['file']['name']);
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if ($tieu_de == '') {
			$ok = 0;
			$thongbao = 'Vui lòng nhập tiêu đề';
		} else if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'jpe')) == false) {
			$ok = 0;
			$thongbao = 'Vui lòng chọn ảnh minh họa';
		} else {
			$ok = 1;
			$thongbao = 'Thêm slide thành công';
			$tieu_de = trim($tieu_de);
			$minh_hoa = '/uploads/minh_hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
			move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
			mysqli_query($conn, "INSERT INTO slide (tieu_de,minh_hoa,link,target,thu_tu)VALUES('$tieu_de','$minh_hoa','$link','$target','$thu_tu')");
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == "edit_slide") {
	$tieu_de = strip_tags(addslashes($_REQUEST['tieu_de']));
	$link = strip_tags(addslashes($_REQUEST['link']));
	$target = addslashes($_REQUEST['target']);
	$thu_tu = intval($_REQUEST['thu_tu']);
	$duoi = $check->duoi_file($_FILES['file']['name']);
	$hientai = time();
	$id = intval($_REQUEST['id']);
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if ($tieu_de == '') {
			$ok = 0;
			$thongbao = 'Vui lòng nhập tiêu đề';
		} else {
			$thongtin = mysqli_query($conn, "SELECT *, count(*) AS total FROM slide WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] > 0) {
				$ok = 1;
				$thongbao = 'Sửa slide thành công';
				$tieu_de = trim($tieu_de);
				if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif', 'jpe')) == true) {
					$minh_hoa = '/uploads/minh_hoa/' . $check->blank($tieu_de) . '-' . time() . '.' . $duoi;
					move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
					@unlink('..'.$r_tt['minh_hoa']);
				} else {
					$minh_hoa = $r_tt['minh_hoa'];
				}
				mysqli_query($conn, "UPDATE slide SET tieu_de='$tieu_de',minh_hoa='$minh_hoa',link='$link',target='$target' WHERE id='$id'");
			} else {
				$ok = 0;
				$thongbao = "Dữ liệu không tồn tại";
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == "add_theloai") {
	$cat_tieude = strip_tags($_REQUEST['cat_tieude']);
	$cat_title = strip_tags($_REQUEST['cat_title']);
	$cat_description = strip_tags($_REQUEST['cat_description']);
	$cat_noidung = strip_tags($_REQUEST['cat_noidung']);
	$cat_thutu = intval($_REQUEST['cat_thutu']);
	$cat_blank = addslashes($_REQUEST['cat_blank']);
	$cat_main = intval($_REQUEST['cat_main']);
	$cat_icon = addslashes($_REQUEST['cat_icon']);
	$cat_index = intval($_REQUEST['cat_index']);
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if ($cat_tieude == '') {
			$ok = 0;
			$thongbao = 'Vui lòng nhập tiêu đề';
		} else {
			$thongtin_seo = mysqli_query($conn, "SELECT count(*) AS total FROM seo WHERE link='$cat_blank' ORDER BY id DESC LIMIT 1");
			$r_seo = mysqli_fetch_assoc($thongtin_seo);
			if ($r_seo['total'] > 0) {
				$ok = 0;
				$thongbao = 'Thất bại! Link xem đã tồn tại';
			} else {
				$ok = 1;
				$thongbao = "Thêm thể loại thành công";
				mysqli_query($conn, "INSERT INTO category(cat_tieude,cat_blank,cat_noidung,cat_title,cat_main,cat_description,cat_index,cat_thutu,cat_icon)VALUES('$cat_tieude','$cat_blank','$cat_noidung','$cat_title','$cat_main','$cat_description','$cat_index','$cat_thutu','$cat_icon')");
				mysqli_query($conn, "INSERT INTO seo (loai,link)VALUES('category','$cat_blank')");

			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == "edit_theloai") {
	$cat_tieude = strip_tags($_REQUEST['cat_tieude']);
	$cat_title = strip_tags($_REQUEST['cat_title']);
	$cat_description = strip_tags($_REQUEST['cat_description']);
	$cat_noidung = strip_tags($_REQUEST['cat_noidung']);
	$link_old = addslashes($_REQUEST['link_old']);
	$cat_thutu = intval($_REQUEST['cat_thutu']);
	$cat_blank = addslashes($_REQUEST['cat_blank']);
	$cat_id = intval($_REQUEST['cat_id']);
	$cat_main = intval($_REQUEST['cat_main']);
	$cat_icon = addslashes($_REQUEST['cat_icon']);
	$cat_index = intval($_REQUEST['cat_index']);
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if ($cat_tieude == '') {
			$ok = 0;
			$thongbao = 'Vui lòng nhập tiêu đề';
		} else {
			if ($cat_blank == $link_old) {
				$ok = 1;
				$thongbao = "Sửa thể loại thành công";
				mysqli_query($conn, "UPDATE category SET cat_tieude='$cat_tieude',cat_main='$cat_main',cat_blank='$cat_blank',cat_noidung='$cat_noidung',cat_title='$cat_title',cat_description='$cat_description',cat_thutu='$cat_thutu',cat_icon='$cat_icon',cat_index='$cat_index' WHERE cat_id='$cat_id'");

			} else {
				$thongtin_seo = mysqli_query($conn, "SELECT count(*) AS total FROM seo WHERE link='$cat_blank' ORDER BY id DESC LIMIT 1");
				$r_seo = mysqli_fetch_assoc($thongtin_seo);
				if ($r_seo['total'] > 0) {
					$ok = 0;
					$thongbao = 'Thất bại! Link xem đã tồn tại';

				} else {
					$ok = 1;
					$thongbao = "Sửa thể loại thành công";
					mysqli_query($conn, "UPDATE category SET cat_tieude='$cat_tieude',cat_blank='$cat_blank',cat_noidung='$cat_noidung',cat_main='$cat_main',cat_title='$cat_title',cat_description='$cat_description',cat_thutu='$cat_thutu',cat_icon='$cat_icon' WHERE cat_id='$cat_id'");
					mysqli_query($conn, "UPDATE seo SET link='$cat_blank' WHERE link='$link_old'");
				}

			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == "change_password") {
	$old_pass = addslashes($_REQUEST['old_pass']);
	$pass = md5($old_pass);
	$new_pass = addslashes($_REQUEST['new_pass']);
	$confirm = addslashes($_REQUEST['confirm']);
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if (strlen($new_pass) < 6) {
			$thongbao = "Mật khẩu mới phải dài từ 6 ký tự";
			$ok = 0;
		} else if ($new_pass != $confirm) {
			$thongbao = "Nhập lại mật khẩu mới không khớp";
			$ok = 0;
		} else {
			$user_id = $_COOKIE['emin_id'];
			$thongtin = mysqli_query($conn, "SELECT * FROM emin_info WHERE id='$user_id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['password'] != $pass) {
				$ok = 0;
				$thongbao = "Mật khẩu hiện tại không đúng";
			} else {
				$password = md5($new_pass);
				mysqli_query($conn, "UPDATE emin_info SET password='$password' WHERE id='$user_id'");
				$ok = 1;
				$thongbao = 'Đổi mật khẩu thành công';

			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == 'copy_truyen') {
	$link_copy = addslashes($_REQUEST['link_copy']);
	$thongtin = mysqli_query($conn, "SELECT count(*) AS total FROM phim WHERE link_copy='$link_copy'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] > 0) {
		$ok = 0;
		$thongbao = 'Link đã tồn tại';
	} else {
		$ok = 1;
		$thongbao = 'Copy thành công';
		if (strpos($_REQUEST['link_copy'], 'hh3dhay.com') !== false) {
			$xxx = $check->curl($link_copy);
			preg_match('/<h1>(.*?)<\/h1>/is', $xxx, $tach_tieude);
			$tieu_de = $tach_tieude[1];
			preg_match('/<span class="info-item">Tên Khác: (.*?)<\/span>/is', $xxx, $tach_tenkhac);
			$ten_khac = $tach_tenkhac[1];
			preg_match('/<div class="story-detail-info">(.*?)<\/div>/is', $xxx, $tach_noidung);
			$noidung = $check->removeLink(trim($tach_noidung[1]));
			$title = $tieu_de;
			$link_xem = $check->blank($tieu_de);
			$description = $check->words($noidung, 35);
			preg_match('/<meta property="og:image" content="(.*?)">/is', $xxx, $tach_img);
			$img = $tach_img[1];
		}
	}
	$info = array(
		'tieu_de' => $tieu_de,
		'ten_khac' => $ten_khac,
		'title' => $title,
		'description' => trim($description),
		'noidung' => trim($noidung),
		'img' => $img,
		'link_xem' => $link_xem,
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == 'copy_category') {
	$link_copy = addslashes($_REQUEST['link_copy']);
	$ok = 1;
	$thongbao = 'Copy thành công';
	if (strpos($_REQUEST['link_copy'], '3dchill.net') !== false) {
		$xxx = $check->getpage($link_copy,$link_copy);
		echo $xxx;
		preg_match('/<title>(.*?)<\/title>/is', $xxx,$tach_title);
		preg_match('/<meta name="description" content="(.*?)" \/>/is', $xxx,$tach_description);
		preg_match('/<meta name=keywords content="(.*?)">/is', $xxx,$tach_keywords);
		preg_match('/<h3 class="section-title"><span>Thể Loại : (.*?)<\/span><\/h3>/is', $xxx,$tach_tieude);
		$title=$tach_title[1];
		$description=trim($tach_description[1]);
		$link_xem = $check->blank(trim($tach_tieude[1]));
		$tieu_de=str_replace('Truyện ', '', $tach_tieude[1]);
	}
	$info = array(
		'tieu_de' => $tieu_de,
		'title' => $title,
		'description' => trim($description),
		'link_xem' => $link_xem,
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == 'copy_chap') {
	$link_copy = addslashes($_REQUEST['link_copy']);
	if (strpos($_REQUEST['link_copy'], 'timtruyen.net') !== false) {
		$xxx = $check->curl($link_copy);
		preg_match('/<li class="breadcrumb-item active"><a href="(.*?)">(.*?)<\/a><\/li>/is', $xxx, $tach_tieude);
		$tieu_de = $tach_tieude[2];
		preg_match('/<section class="section-detail-story">(.*?)<\/section>/is', $xxx, $tach_noidung);
		preg_match_all('/<img class="lazy" data-src="(.*?)" data-original="(.*?)" alt="(.*?)">/is', $tach_noidung[1], $tach_img);
		foreach ($tach_img[1] as $key => $value) {
			$noidung .= $value . "\n";
		}
	} else if (strpos($_REQUEST['link_copy'], 'nettruyen.com') !== false) {
		$xxx = $check->curl($link_copy);
		preg_match('/<h1 class=\'txt-primary\'><a href=\'(.*?)\'>(.*?)<\/a> <span>- (.*?)<\/span><\/h1>/is', $xxx, $tach_tieude);
		$tieu_de = $tach_tieude[3];
		preg_match('/<div class="reading-detail box_doc">(.*?)<div class="container">/is', $xxx, $tach_noidung);
		preg_match_all('/<img alt=\'(.*?)\' data-index=\'(.*?)\' src=\'(.*?)\' data-original=\'(.*?)\' \/>/is', $tach_noidung[1], $tach_img);
		foreach ($tach_img[3] as $key => $value) {
			$noidung .= $value . "\n";
		}
	} else if (strpos($_REQUEST['link_copy'], 'truyenqq.com/') !== false) {
		$xxx = $check->curl($link_copy);
		preg_match('/<h1 class="detail-title"><a href="(.*?)">(.*?)<\/a> (.*?)<\/h1>/is', $xxx, $tach_tieude);
		$tieu_de = $tach_tieude[3];
		preg_match('/<div class="story-see-content">(.*?)<\/div>/is', $xxx, $tach_noidung);
		preg_match_all('/<img class="lazy" src="(.*?)" alt="(.*?)" \/>/is', $tach_noidung[1], $tach_img);
		foreach ($tach_img[1] as $key => $value) {
			$noidung .= $value . "\n";
		}
	} else {
		$ok = 0;
		$thongbao = 'Link không được hỗ trợ';
	}
	$noidung = substr($noidung, 0, -1);
	$info = array(
		'tieu_de' => $tieu_de,
		'noidung' => $noidung,
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == 'copy_chap_auto') {
	$link_copy = addslashes($_REQUEST['link_copy']);
	$truyen = intval($_REQUEST['truyen']);
	$chap = intval($_REQUEST['chap']);
	$server = addslashes($_REQUEST['server']);
	$chap_total = intval($_REQUEST['chap_total']);
	$link_next = addslashes($_REQUEST['link_next']);
	$thongtin = mysqli_query($conn, "SELECT * FROM truyen WHERE id='$truyen' ORDER BY id DESC LIMIT 1");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if (strpos($_REQUEST['link_copy'], 'timtruyen.net') !== false) {
		$tach_link = explode('chapter-', $link_copy);
		if ($chap == $chap_total) {
			$tiep = 0;
			$list = 'Đã copy hoàn thành<br>';
		} else {
			if ($chap == 0) {
				$link_curl = $link_copy;
			} else {
				$link_curl = $link_next;
			}
			$next_chap = $chap + 1;
			$xxx = $check->curl($link_curl);
			preg_match('/<li class="breadcrumb-item active"><a href="(.*?)">(.*?)<\/a><\/li>/is', $xxx, $tach_tieude);
			$tieu_de = $tach_tieude[2];
			preg_match('/<section class="section-detail-story">(.*?)<\/section>/is', $xxx, $tach_noidung);
			preg_match_all('/<img(.*?)data-src="(.*?)"(.*?)>/is', $tach_noidung[1], $tach_img);
			preg_match('/<a class="link-next-chap" href="(.*?)">/is', $xxx, $tach_next);
			$link_next = $tach_next[1];
			foreach ($tach_img[2] as $key => $value) {
				$noidung .= $value . "\n";
			}
			if (strlen($noidung) > 50) {
				$tiep = 1;
				$link = $check->blank($tieu_de);
				$thongtin_cuoi = mysqli_query($conn, "SELECT * FROM chap WHERE truyen='$truyen' ORDER BY thu_tu DESC LIMIT 1");
				$r_c = mysqli_fetch_assoc($thongtin_cuoi);
				$total_chap = mysqli_num_rows($thongtin_cuoi);
				if ($total_chap == 0) {
					$thu_tu = 1;
				} else {
					$thu_tu = $r_c['thu_tu'] + 1;
				}
				$hientai = time();
				$thongtin_chap = mysqli_query($conn, "SELECT *,count(*) AS total FROM chap WHERE truyen='$truyen' AND link='$link'");
				$r_c = mysqli_fetch_assoc($thongtin_chap);
				if ($r_c['total'] == 0) {
					$list_server = '{"' . $server . '":{"nguon":"' . $link_curl . '","crawl":"0","noidung":"' . $noidung . '"}}';
					mysqli_query($conn, "INSERT INTO chap(tieu_de,link,truyen,noidung,thu_tu,date_post,crawl_all,view,coin)VALUES('$tieu_de','$link','$truyen','$list_server','$thu_tu','$hientai','1','0','0')");
					mysqli_query($conn, "UPDATE truyen SET update_post='$hientai',chap='$tieu_de' WHERE id='$truyen'");
					$list = 'Đã thêm xong ' . $tieu_de . '<br>';
				} else {
					if ($r_c['noidung'] == '') {
						//$list_server='{"'.$server.'":"'.$noidung.'"}';
						$list_server = '{"' . $server . '":{"nguon":"' . $link_curl . '","crawl":"0","noidung":"' . $noidung . '"}}';
						mysqli_query($conn, "INSERT INTO chap(tieu_de,link,truyen,noidung,thu_tu,date_post,crawl_all,view,coin)VALUES('$tieu_de','$link','$truyen','$list_server','$thu_tu','$hientai','1','0','0')");
						mysqli_query($conn, "UPDATE truyen SET update_post='$hientai',chap='$tieu_de' WHERE id='$truyen'");
						$list = 'Đã thêm xong ' . $tieu_de . '<br>';
					} else {
						if (strpos($r_c['noidung'], '"' . $server . '":"') !== false) {
							$list = 'Chap này đã có server ' . $server . '<br>';
						} else {
							$list_server = substr($r_c['noidung'], 0, -1) . ',"' . $server . '":"' . $noidung . '"}';
							$list = 'Đã cập nhật chap thành công<br>';
						}
					}

				}
			} else {
				$tiep = 0;
				$list = 'Đã copy hết chap của truyện<br>';
			}

		}
	} else if (strpos($_REQUEST['link_copy'], 'truyenvn.com') !== false) {
		$tach_link = explode('chapter-', $link_copy);
		if ($chap == $chap_total) {
			$tiep = 0;
			$list = 'Đã copy hoàn thành<br>';
		} else {
			if ($chap == 0) {
				$link_curl = $link_copy;
			} else {
				$link_curl = $link_next;
			}
			$next_chap = $chap + 1;
			$xxx = $check->curl($link_curl);
			preg_match('/<span class="last">(.*?)<\/span>/is', $xxx, $tach_tieude);
			$tieu_de = $tach_tieude[2];
			preg_match('/<section class="section-detail-story">(.*?)<\/section>/is', $xxx, $tach_noidung);
			preg_match_all('/<img(.*?)data-src="(.*?)"(.*?)>/is', $tach_noidung[1], $tach_img);
			preg_match('/<a class="link-next-chap" href="(.*?)">/is', $xxx, $tach_next);
			$link_next = $tach_next[1];
			foreach ($tach_img[2] as $key => $value) {
				$noidung .= $value . "\n";
			}
			if (strlen($noidung) > 50) {
				$tiep = 1;
				$link = $check->blank($tieu_de);
				$thongtin_cuoi = mysqli_query($conn, "SELECT * FROM chap WHERE truyen='$truyen' ORDER BY thu_tu DESC LIMIT 1");
				$r_c = mysqli_fetch_assoc($thongtin_cuoi);
				$total_chap = mysqli_num_rows($thongtin_cuoi);
				if ($total_chap == 0) {
					$thu_tu = 1;
				} else {
					$thu_tu = $r_c['thu_tu'] + 1;
				}
				$hientai = time();
				$thongtin_chap = mysqli_query($conn, "SELECT *,count(*) AS total FROM chap WHERE truyen='$truyen' AND link='$link'");
				$r_c = mysqli_fetch_assoc($thongtin_chap);
				if ($r_c['total'] == 0) {
					$list_server = '{"' . $server . '":{"nguon":"' . $link_curl . '","crawl":"0","noidung":"' . $noidung . '"}}';
					mysqli_query($conn, "INSERT INTO chap(tieu_de,link,truyen,noidung,thu_tu,date_post,crawl_all,view,coin)VALUES('$tieu_de','$link','$truyen','$list_server','$thu_tu','$hientai','1','0','0')");
					mysqli_query($conn, "UPDATE truyen SET update_post='$hientai',chap='$tieu_de' WHERE id='$truyen'");
					$list = 'Đã thêm xong ' . $tieu_de . '<br>';
				} else {
					if ($r_c['noidung'] == '') {
						//$list_server='{"'.$server.'":"'.$noidung.'"}';
						$list_server = '{"' . $server . '":{"nguon":"' . $link_curl . '","crawl":"0","noidung":"' . $noidung . '"}}';
						mysqli_query($conn, "INSERT INTO chap(tieu_de,link,truyen,noidung,thu_tu,date_post,crawl_all,view,coin)VALUES('$tieu_de','$link','$truyen','$list_server','$thu_tu','$hientai','1','0','0')");
						mysqli_query($conn, "UPDATE truyen SET update_post='$hientai',chap='$tieu_de' WHERE id='$truyen'");
						$list = 'Đã thêm xong ' . $tieu_de . '<br>';
					} else {
						if (strpos($r_c['noidung'], '"' . $server . '":"') !== false) {
							$list = 'Chap này đã có server ' . $server . '<br>';
						} else {
							$list_server = substr($r_c['noidung'], 0, -1) . ',"' . $server . '":"' . $noidung . '"}';
							$list = 'Đã cập nhật chap thành công<br>';
						}
					}

				}
			} else {
				$tiep = 0;
				$list = 'Đã copy hết chap của truyện<br>';
			}

		}
	} else {
		$tiep = 0;
		$list = 'Link không được hỗ trợ<br>';
	}
	$noidung = substr($noidung, 0, -1);
	$info = array(
		'ok' => 1,
		'list' => $list,
		'tiep' => $tiep,
		'link_next' => $link_next,
		'chap' => $next_chap,
	);
	echo json_encode($info);

}else if($action=='del_all'){
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		$user_id=intval($_REQUEST['user_id']);
		mysqli_query($conn,"DELETE FROM chat WHERE user_id='$user_id'");
		$ok=1;
		$thongbao='Đã xóa thành công';
	}
	echo json_encode(array('ok'=>$ok,'thongbao'=>$thongbao));
}else if($action=='block_user'){
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		$user_id=intval($_REQUEST['user_id']);
		mysqli_query($conn,"UPDATE user_info SET active='2' WHERE user_id='$user_id'");
		$ok=1;
		$thongbao='Đã chặn thành công';
	}
	echo json_encode(array('ok'=>$ok,'thongbao'=>$thongbao));
} else if ($action == 'del') {
	$loai = addslashes($_REQUEST['loai']);
	$id = preg_replace('/[^0-9a-z]/', '', $_REQUEST['id']);
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
	} else {
		if ($loai == 'phim') {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM phim WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Phim không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa phim thành công';
				mysqli_query($conn, "DELETE FROM phim WHERE id='$id'");
				mysqli_query($conn, "DELETE FROM list_tap WHERE phim='$id'");
				mysqli_query($conn, "DELETE FROM seo WHERE link='{$r_tt['link']}' AND loai='phim'");
				@unlink('..' . $r_tt['minh_hoa']);
			}
		} else if ($loai == 'tap') {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM list_tap WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Tập phim không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa tập thành công';
				mysqli_query($conn, "DELETE FROM list_tap WHERE id='$id'");
			}
		} else if ($loai == 'chat') {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM chat WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Nội dung không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa nội dung thành công';
				mysqli_query($conn, "DELETE FROM chat WHERE id='$id'");
			}
		}else if ($loai == 'premium') {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM premium_price WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Gói premium không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa gói premium thành công';
				mysqli_query($conn, "DELETE FROM premium_price WHERE id='$id'");
			}
		}   else if ($loai == 'comment') {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM comment WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Nội dung không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa bình luận thành công';
				mysqli_query($conn, "DELETE FROM comment WHERE id='$id'");
				mysqli_query($conn, "DELETE FROM comment WHERE reply='$id'");
			}
		} else if ($loai == 'category') {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM category WHERE cat_id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Thể loại không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa thể loại thành công';
				mysqli_query($conn, "DELETE FROM category WHERE cat_id='$id'");
				mysqli_query($conn, "DELETE FROM seo WHERE link='{$r_tt['cat_blank']}'");
			}
		} else if ($loai == 'menu') {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM menu WHERE menu_id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Menu không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa menu thành công';
				mysqli_query($conn, "DELETE FROM menu WHERE menu_id='$id'");
			}
		} else if ($loai == 'timkiem') {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM timkiem WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Từ khóa không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa tìm kiếm thành công';
				mysqli_query($conn, "DELETE FROM timkiem WHERE id='$id'");
			}
		} else if ($loai == 'donate') {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM donate WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Giao dịch không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa donate thành công';
				mysqli_query($conn, "DELETE FROM donate WHERE id='$id'");
			}
		} else if ($loai == 'slide') {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM slide WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Slide không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa slide thành công';
				mysqli_query($conn, "DELETE FROM slide WHERE id='$id'");
				@unlink('..'.$r_tt['minh_hoa']);
			}
		} else if ($loai == 'vitri_ads') {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM vitri_ads WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Vị trí quảng cáo không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa vị trí quảng cáo thành công';
				mysqli_query($conn, "DELETE FROM vitri_ads WHERE id='$id'");
			}
		} else if ($loai == 'muachap') {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM muachap WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Giao dịch này không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa mua chap vip thành công';
				mysqli_query($conn, "DELETE FROM muachap WHERE id='$id'");
			}
		} else if ($loai == 'napcoin') {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM nap WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Giao dịch này không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa nạp coin thành công';
				mysqli_query($conn, "DELETE FROM nap WHERE id='$id'");
			}
		} else if ($loai == 'history') {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM history WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Dữ liệu này không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa lịch sử thành công';
				mysqli_query($conn, "DELETE FROM history WHERE id='$id'");
			}
		} else if ($loai == 'report') {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM baoloi WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Dữ liệu này không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa báo lỗi thành công';
				mysqli_query($conn, "DELETE FROM baoloi WHERE id='$id'");
			}
		} else if ($loai == 'block') {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM block_ip WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Dữ liệu này không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa chặn thành công';
				mysqli_query($conn, "DELETE FROM block_ip WHERE id='$id'");
			}
		} else if ($loai == 'thanhvien') {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM user_info WHERE user_id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Thành viên này không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa thành viên thành công';
				@unlink('..' . $r_tt['avatar']);
				mysqli_query($conn, "DELETE FROM user_info WHERE user_id='$id'");
				mysqli_query($conn, "DELETE FROM nap WHERE user_id='$id'");
				mysqli_query($conn, "DELETE FROM muachap WHERE user_id='$id'");
				mysqli_query($conn, "DELETE FROM donate WHERE user_id='$id'");
				mysqli_query($conn, "DELETE FROM baoloi WHERE user_id='$id'");
				mysqli_query($conn, "DELETE FROM history WHERE user_id='$id'");
			}
		} else if ($loai == 'baiviet') {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM post WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Bài viết không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa bài viết thành công';
				mysqli_query($conn, "DELETE FROM post WHERE id='$id'");
				if (strpos($r_tt['minh_hoa'], $index_setting['link_img']) !== false) {
					@unlink(str_replace($index_setting['link_img'], '..', $r_tt['minh_hoa']));
				} else {
					@unlink('..' . $r_tt['minh_hoa']);
				}
			}
		} else if ($loai == 'tacgia') {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM tac_gia WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Tác giả không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa tác giả thành công';
				mysqli_query($conn, "DELETE FROM tac_gia WHERE id='$id'");
				mysqli_query($conn, "DELETE FROM seo WHERE link='{$r_tt['link']}'");
				@unlink('..' . $r_tt['minh_hoa']);
			}
		} else if ($loai == 'contact') {
			$thongtin = mysqli_query($conn, "SELECT *,count(*) AS total FROM contact WHERE id='$id'");
			$r_tt = mysqli_fetch_assoc($thongtin);
			if ($r_tt['total'] == 0) {
				$ok = 0;
				$thongbao = 'Liên hệ không tồn tại';
			} else {
				$ok = 1;
				$thongbao = 'Xóa liên hệ thành công';
				mysqli_query($conn, "DELETE FROM contact WHERE id='$id'");
			}
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
	);
	echo json_encode($info);

} else if ($action == 'upload_tinymce') {
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
		$minh_hoa = '';
	} else {
		$filename = $_FILES['file']['name'];
		$duoi = $check->duoi_file($_FILES['file']['name']);
		if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif')) == true) {
			$minh_hoa = '/uploads/minh_hoa/' . $check->blank(str_replace('.'.$duoi,'', $filename)) . '-' . time() . '.' . $duoi;
			move_uploaded_file($_FILES['file']['tmp_name'], '..' . $minh_hoa);
			$thongbao = 'Upload ảnh thành công';
			$ok = 1;
			$minh_hoa = $index_setting['link_img'] . '' . $minh_hoa;
		} else {
			$thongbao = 'Vui lòng chọn ảnh minh họa';
			$ok = 0;
			$minh_hoa = '';
		}
	}
	$info = array(
		'ok' => $ok,
		'thongbao' => $thongbao,
		'minh_hoa' => $minh_hoa,
	);
	echo json_encode($info);

} else if ($action == 'upload_photo') {
	if (!isset($_COOKIE['emin_id'])) {
		$ok = 0;
		$thongbao = 'Bạn chưa đăng nhập';
		$list = '';
	} else {
		$total=count($_FILES['file']['name']);
		$truyen=intval($_REQUEST['truyen']);
		$k=0;
		for ($i=0; $i < $total ; $i++) { 
			$filename = $_FILES['file']['name'][$i];
			$duoi = $check->duoi_file($_FILES['file']['name'][$i]);
			if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp')) == true) {
				$folder_name = '/uploads/minh_hoa/'.$truyen.'/';

				if (!file_exists('..'.$folder_name)) {
				    mkdir('..'.$folder_name, 0777);
				} else {
				}
				$minh_hoa = $folder_name.''. $check->blank(str_replace('.'.$duoi,'', $filename)) . '-' . time() . '.' . $duoi;
				move_uploaded_file($_FILES['file']['tmp_name'][$i], '..' . $minh_hoa);
				//$minh_hoa = $index_setting['link_img'] . '' . $minh_hoa;
				$list.=$index_setting['link_domain'] . '' . substr($minh_hoa,1)."\n";
				$k++;
			}
		}
		if($k>0){
			$ok=1;
			$thongbao='Upload ảnh thành công!';
		}else{
			$thongbao='Không có ảnh nào được upload'.$total;
			$ok=0;
		}
	}
	echo json_encode(array('ok'=>$ok,'thongbao'=>$thongbao,'list'=>$list));
} else if ($action == 'timkiem') {
	$key = addslashes(strip_tags($_REQUEST['key']));
	$list = $class_index->list_kq_timkiem($conn, $key);
	$list = '<tr>
				<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
				<th style="text-align: center;width: 120px;" class="hide_mobile">Minh họa</th>
				<th style="text-align: left;">Tiêu đề</th>
				<th style="text-align: center;">Tập mới</th>
				<!-- <th style="text-align: center;width: 100px;" class="hide_mobile">View</th> -->
				<th style="text-align: center;width: 150px;">Hành động</th>
			</tr>' . $list;
	$info = array(
		'ok' => 1,
		'list' => $list,
	);
	echo json_encode($info);
} else if ($action == 'timkiem_member') {
	$key = addslashes(strip_tags($_REQUEST['key']));
	$list = $class_index->list_kq_timkiem_member($conn, $key);
	$list = '<tr>
				<th style="text-align: center;width: 50px;" class="hide_mobile">STT</th>
				<th style="text-align: left;">ID</th>
				<th style="text-align: left;">Tài khoản</th>
				<th style="text-align: left;" class="hide_mobile">Họ tên</th>
				<th style="text-align: left;" class="hide_mobile">Email</th>
				<th style="text-align: center;">Coin</th>
				<th style="text-align: center;">Donate</th>
				<th style="text-align: center;" class="hide_mobile">Loại</th>
				<th style="text-align: center;" class="hide_mobile">Tình trạng</th>
				<th style="text-align: center;" class="hide_mobile">Đăng ký</th>
				<th style="text-align: center;width: 225px;">Hành động</th>
			</tr>' . $list;
	$info = array(
		'ok' => 1,
		'list' => $list,
	);
	echo json_encode($info);
} else if ($action == 'timkiem_chap') {
	$key = addslashes(strip_tags($_REQUEST['key']));
	$truyen=intval($_REQUEST['truyen']);
	$list = $class_index->list_kq_timkiem_chap($conn, $truyen,$key);
	$list = '<tr>
				<th style="text-align: center;width: 50px;" class="hide_mobile">ID</th>
				<th style="text-align: left;">Tiêu đề</th>
				<th style="text-align: center;" class="hide_mobile">Thứ tự</th>
				<th style="text-align: center;width: 100px;">Hành động</th>
			</tr>' . $list;
	$info = array(
		'ok' => 1,
		'list' => $list,
	);
	echo json_encode($info);
} else if ($action == 'goi_y') {
	$tieu_de = strip_tags(addslashes($_REQUEST['tieu_de']));
	$cat = strip_tags(addslashes($_REQUEST['cat']));
	$cat = 'cat' . $cat;
	$thongtin = mysqli_query($conn, "SELECT id,tieu_de FROM sanpham WHERE MATCH(tieu_de) AGAINST('$tieu_de') AND MATCH(category) AGAINST('$cat') ORDER BY gia ASC");
	while ($r_tt = mysqli_fetch_assoc($thongtin)) {
		$list .= '<li value="' . $r_tt['id'] . '"><span>' . $r_tt['tieu_de'] . '</span></li>';
	}
	$info = array(
		'ok' => 1,
		'list' => $list,
	);
	echo json_encode($info);
} else if ($action == 'check_blank') {
	$link = $check->blank($_REQUEST['link']);
	$thongtin = mysqli_query($conn, "SELECT count(*) AS total FROM seo WHERE link='$link'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] > 0) {
		$ok = 0;
	} else {
		$ok = 1;
	}
	$info = array(
		'ok' => $ok,
		'link' => $link,
	);
	echo json_encode($info);
} else if ($action == 'check_link') {
	$link = $_REQUEST['link'];
	$thongtin = mysqli_query($conn, "SELECT count(*) AS total FROM seo WHERE link='$link'");
	$r_tt = mysqli_fetch_assoc($thongtin);
	if ($r_tt['total'] > 0) {
		$ok = 0;
	} else {
		$ok = 1;
	}
	$info = array(
		'ok' => $ok,
		'link' => $link,
	);
	echo json_encode($info);
} else {
	echo "Không có hành động nào được xử lý";
}
?>