<?php
class class_index extends class_manage {
	///////////////////
	function list_phim_index($conn,$page,$limit) {
		$start = $page * $limit - $limit;
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM phim ORDER BY update_post DESC LIMIT $start,$limit");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if($r_tt['thoi_luong']==''){
				$r_tt['thoi_luong']='N/A';
			}
			if($r_tt['rate']==''){
				$r_tt['rate']='N/A';
			}
			$list .= $skin->skin_replace('skin/box_li/li_phim', $r_tt);
		}
		return $list;
		mysqli_free_result($thongtin);
		mysqli_close($conn);
	}
	///////////////////
	function list_history($conn,$user_id,$page,$limit) {
		$start = $page * $limit - $limit;
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT history.*,phim.tieu_de,phim.minh_hoa,phim.link,list_tap.tieu_de AS ten_tap FROM history INNER JOIN phim ON history.phim=phim.id LEFT JOIN list_tap ON history.tap=list_tap.id WHERE history.user_id='$user_id' ORDER BY history.date_end DESC LIMIT $start,$limit");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if($r_tt['thoi_luong']==''){
				$r_tt['thoi_luong']='N/A';
			}
			if($r_tt['rate']==''){
				$r_tt['rate']='N/A';
			}
			$list .= $skin->skin_replace('skin/box_li/li_history', $r_tt);
		}
		return $list;
		mysqli_free_result($thongtin);
		mysqli_close($conn);
	}
	///////////////////
	function list_follow($conn,$user_id,$page,$limit) {
		$start = $page * $limit - $limit;
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT phim.* FROM follow INNER JOIN phim ON follow.phim=phim.id WHERE follow.user_id='$user_id' ORDER BY follow.date_post DESC LIMIT $start,$limit");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if($r_tt['thoi_luong']==''){
				$r_tt['thoi_luong']='N/A';
			}
			if($r_tt['rate']==''){
				$r_tt['rate']='N/A';
			}
			$list .= $skin->skin_replace('skin/box_li/li_follow', $r_tt);
		}
		return $list;
		mysqli_free_result($thongtin);
		mysqli_close($conn);
	}
	///////////////////
	function list_phim_loc($conn,$cat,$nam,$full,$loai,$page,$limit) {
		$start = $page * $limit - $limit;
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		if($cat=='all'){
			$cat='';
		}
		if($nam=='all'){
			$nam='';
		}
		if($loai=='all'){
			$loai='';
		}
		if($full=='all'){
			$full='';
		}
		if($cat=='' OR $cat=='all'){
			$where_cat="";
		}else{
			$where_cat="FIND_IN_SET('$cat',category)>0";
		}
		if($nam=='' OR $nam=='all'){
			$where_nam="";
		}else{
			if($cat==''){
				$where_nam="nam='$nam'";
			}else{
				$where_nam="AND nam='$nam'";
			}
		}
		if($full=='' OR $full=='all'){
			$where_full="";
		}else{
			if($nam=='' AND $cat==''){
				$where_full="full='$full'";
			}else{
				$where_full="AND full='$full'";
			}
		}
		if($loai=='' OR $loai=='all'){
			$where_loai="";
		}else{
			if($nam=='' AND $cat=='' AND $full==''){
				$where_loai="loai_hinh='$loai'";
			}else{
				$where_loai="AND loai_hinh='$loai'";
			}
		}
		if(($cat=='' OR $cat=='all') AND ($nam=='' OR $nam=='all') AND ($full=='' OR $full=='all') AND ($loai=='' OR $loai=='all')){
			$thongtin = mysqli_query($conn, "SELECT * FROM phim ORDER BY id DESC LIMIT $start,$limit");
		}else{
			$thongtin = mysqli_query($conn, "SELECT * FROM phim WHERE $where_cat $where_nam $where_full $where_loai ORDER BY update_post DESC LIMIT $start,$limit");
		}
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if($r_tt['thoi_luong']==''){
				$r_tt['thoi_luong']='N/A';
			}
			if($r_tt['rate']==''){
				$r_tt['rate']='N/A';
			}
			$list .= $skin->skin_replace('skin/box_li/li_phim', $r_tt);
		}
		return $list;
		mysqli_free_result($thongtin);
		mysqli_close($conn);
	}
	///////////////////
	function list_phim_category($conn,$cat,$nam,$full,$loai,$page,$limit) {
		$start = $page * $limit - $limit;
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		if($nam=='all'){
			$nam='';
		}
		if($loai=='all'){
			$loai='';
		}
		if($full=='all'){
			$full='';
		}
		if($nam==''){
			$where_nam="";
		}else{
			$where_nam="AND nam='$nam'";
		}
		if($full==''){
			$where_full="";
		}else{
			$where_full="AND full='$full'";
		}
		if($loai==''){
			$where_loai="";
		}else{
			$where_loai="AND loai_hinh='$loai'";
		}
		$thongtin = mysqli_query($conn, "SELECT * FROM phim WHERE FIND_IN_SET('$cat',category)>0 $where_nam $where_full $where_loai ORDER BY update_post DESC LIMIT $start,$limit");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if($r_tt['thoi_luong']==''){
				$r_tt['thoi_luong']='N/A';
			}
			if($r_tt['rate']==''){
				$r_tt['rate']='N/A';
			}
			$list .= $skin->skin_replace('skin/box_li/li_phim', $r_tt);
		}
		return $list;
		mysqli_free_result($thongtin);
		mysqli_close($conn);
	}
	///////////////////
	function list_phim_timkiem($conn,$keywords,$page,$limit) {
		$start = $page * $limit - $limit;
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		if(strpos($keywords, ' ')!==false){
			$tach_keyword=explode(' ', $keywords);
			$k=0;
			foreach ($tach_keyword as $key => $value) {
				$k++;
				if($k==1){
					$where_key.="tieu_de LIKE '%$value%'";
				}else{
					$where_key.=" AND tieu_de LIKE '%$value%'";
				}
			}
			$thongtin = mysqli_query($conn, "SELECT * FROM phim WHERE $where_key ORDER BY update_post DESC LIMIT $start,$limit");
		}else{
			$thongtin = mysqli_query($conn, "SELECT * FROM phim WHERE tieu_de LIKE '%$keywords%'ORDER BY update_post DESC LIMIT $start,$limit");	
		}
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if($r_tt['thoi_luong']==''){
				$r_tt['thoi_luong']='N/A';
			}
			if($r_tt['rate']==''){
				$r_tt['rate']='N/A';
			}
			$list .= $skin->skin_replace('skin/box_li/li_phim', $r_tt);
		}
		return $list;
		mysqli_free_result($thongtin);
		mysqli_close($conn);
	}
	///////////////////
	function list_phim_tags($conn,$keywords,$page,$limit) {
		$start = $page * $limit - $limit;
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		if(strpos($keywords, ' ')!==false){
			$tach_keyword=explode(' ', $keywords);
			$k=0;
			foreach ($tach_keyword as $key => $value) {
				$k++;
				if($k==1){
					$where_key.="tags LIKE '%$value%'";
				}else{
					$where_key.=" AND tags LIKE '%$value%'";
				}
			}
			$thongtin = mysqli_query($conn, "SELECT * FROM phim WHERE $where_key ORDER BY update_post DESC LIMIT $start,$limit");
		}else{
			$thongtin = mysqli_query($conn, "SELECT * FROM phim WHERE tags LIKE '%$keywords%'ORDER BY update_post DESC LIMIT $start,$limit");	
		}
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if($r_tt['thoi_luong']==''){
				$r_tt['thoi_luong']='N/A';
			}
			if($r_tt['rate']==''){
				$r_tt['rate']='N/A';
			}
			$list .= $skin->skin_replace('skin/box_li/li_phim', $r_tt);
		}
		return $list;
		mysqli_free_result($thongtin);
		mysqli_close($conn);
	}
	///////////////////
	function list_phim_decu($conn,$limit) {
		$start = $page * $limit - $limit;
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM phim WHERE hot='1' ORDER BY update_post DESC LIMIT $limit");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if($r_tt['thoi_luong']==''){
				$r_tt['thoi_luong']='N/A';
			}
			if($r_tt['rate']==''){
				$r_tt['rate']='N/A';
			}
			$list .= $skin->skin_replace('skin/box_li/li_phim_decu', $r_tt);
		}
		return $list;
		mysqli_free_result($thongtin);
		mysqli_close($conn);
	}
	///////////////////
	function list_tap($conn,$phim,$id) {
		$start = $page * $limit - $limit;
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM list_tap WHERE phim='$phim' ORDER BY thu_tu DESC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$list .= $skin->skin_replace('skin/box_li/li_tap', $r_tt);
		}
		return $list;
		mysqli_free_result($thongtin);
		mysqli_close($conn);
	}
	///////////////////
	function list_comment($conn,$user_id,$phim,$page,$limit) {
		$start = $page * $limit - $limit;
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT comment.*,user_info.name,user_info.avatar FROM comment INNER JOIN user_info ON comment.user_id=user_info.user_id WHERE comment.phim='$phim' AND comment.reply='0' AND comment.an='0' ORDER BY comment.date_post DESC LIMIT $start,$limit");
		$i = 0;
		$list='';
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$r_tt['date_post']=$check->chat_update($r_tt['date_post']);
			$thongtin_total_sub=mysqli_query($conn,"SELECT comment.*,user_info.name,user_info.avatar FROM comment INNER JOIN user_info ON comment.user_id=user_info.user_id WHERE comment.reply='{$r_tt['id']}' AND comment.an='0' ORDER BY comment.date_post ASC");
			$total_sub=mysqli_num_rows($thongtin_total_sub);
			$thongtin_sub=mysqli_query($conn,"SELECT comment.*,user_info.name,user_info.avatar FROM comment INNER JOIN user_info ON comment.user_id=user_info.user_id WHERE comment.reply='{$r_tt['id']}' AND comment.an='0' ORDER BY comment.date_post ASC LIMIT 3");
			$total_s=mysqli_num_rows($thongtin_sub);
			if($total_sub==0){
				$r_tt['list_sub_comment']='';
			}else{
				while($r_sub=mysqli_fetch_assoc($thongtin_sub)){
					$r_sub['date_post']=$check->chat_update($r_sub['date_post']);
					if($user_id>0){
						if($user_id==$r_sub['user_id']){
							$list_sub_comment .= $skin->skin_replace('skin/box_li/li_sub_comment_login_user', $r_sub);
						}else{
							$list_sub_comment .= $skin->skin_replace('skin/box_li/li_sub_comment_login', $r_sub);
						}
					}else{
						$list_sub_comment .= $skin->skin_replace('skin/box_li/li_sub_comment', $r_sub);
					}
				}
				if($total_sub>$total_s){
					$r_tt['list_sub_comment']=$list_sub_comment.'<div class="flex flex-ver-center fw-700 load-more button-default bg-blue load_more_sub_comment" page="1" reply="'.$r_tt['id'].'"><a href="javascript:;">Tải thêm bình luận</a></div>';
				}else{
					$r_tt['list_sub_comment']=$list_sub_comment;
				}
				unset($list_sub_comment);
			}
			if($user_id>0){
				if($user_id==$r_tt['user_id']){
					$list .= $skin->skin_replace('skin/box_li/li_comment_login_user', $r_tt);
				}else{
					$list .= $skin->skin_replace('skin/box_li/li_comment_login', $r_tt);
				}
			}else{
				$list .= $skin->skin_replace('skin/box_li/li_comment', $r_tt);
			}
		}
		$total=$i;
		$info=array(
			'list'=>$list,
			'total'=>$total
		);
		return json_encode($info);
		mysqli_free_result($thongtin);
		mysqli_close($conn);
	}
	///////////////////
	function list_reply_comment($conn,$user_id,$phim,$reply,$page,$limit) {
		$start = $page * $limit - $limit;
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin_sub=mysqli_query($conn,"SELECT comment.*,user_info.name,user_info.avatar FROM comment INNER JOIN user_info ON comment.user_id=user_info.user_id WHERE comment.reply='$reply' AND comment.an='0' ORDER BY comment.date_post ASC LIMIT $start,$limit");
		$total_s=mysqli_num_rows($thongtin_sub);
		$i=0;
		while($r_sub=mysqli_fetch_assoc($thongtin_sub)){
			$i++;
			$r_sub['date_post']=$check->chat_update($r_sub['date_post']);
			if($user_id>0){
				if($user_id==$r_sub['user_id']){
					$list .= $skin->skin_replace('skin/box_li/li_sub_comment_login_user', $r_sub);
				}else{
					$list .= $skin->skin_replace('skin/box_li/li_sub_comment_login', $r_sub);
				}
			}else{
				$list .= $skin->skin_replace('skin/box_li/li_sub_comment', $r_sub);
			}
		}
		$total=$i;
		$info=array(
			'list'=>$list,
			'total'=>$total
		);
		return json_encode($info);
		mysqli_free_result($thongtin);
		mysqli_close($conn);
	}
	///////////////////
	function list_theloai($conn) {
		$start = $page * $limit - $limit;
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM category ORDER BY cat_thutu ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$list .= $skin->skin_replace('skin/box_li/li_theloai', $r_tt);
		}
		return $list;
		mysqli_free_result($thongtin);
		mysqli_close($conn);
	}
	///////////////////
	function list_option_theloai($conn,$cat) {
		$start = $page * $limit - $limit;
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM category ORDER BY cat_thutu ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if($cat==$r_tt['cat_blank']){
				$list .= '<option value="'.$r_tt['cat_blank'].'" selected>'.$r_tt['cat_tieude'].'</option>';
			}else{
				$list .= '<option value="'.$r_tt['cat_blank'].'">'.$r_tt['cat_tieude'].'</option>';
			}
		}
		return $list;
		mysqli_free_result($thongtin);
		mysqli_close($conn);
	}
	///////////////////
	function list_nam($conn) {
		$start = $page * $limit - $limit;
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM list_nam ORDER BY nam ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			$list .= $skin->skin_replace('skin/box_li/li_nam', $r_tt);
		}
		return $list;
		mysqli_free_result($thongtin);
		mysqli_close($conn);
	}
	///////////////////
	function list_option_nam($conn,$nam) {
		$start = $page * $limit - $limit;
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM list_nam ORDER BY nam ASC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if($nam==$r_tt['nam']){
				$list .= '<option value="'.$r_tt['nam'].'" selected>'.$r_tt['nam'].'</option>';
			}else{
				$list .= '<option value="'.$r_tt['nam'].'">'.$r_tt['nam'].'</option>';
			}
		}
		return $list;
		mysqli_free_result($thongtin);
		mysqli_close($conn);
	}
	///////////////////
	function list_tag_footer($conn,$limit) {
		$start = $page * $limit - $limit;
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT * FROM phim ORDER BY view_week DESC LIMIT $limit");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if($r_tt['thoi_luong']==''){
				$r_tt['thoi_luong']='N/A';
			}
			if($r_tt['rate']==''){
				$r_tt['rate']='N/A';
			}
			$list .= $skin->skin_replace('skin/box_li/li_tag_footer', $r_tt);
		}
		return $list;
		mysqli_free_result($thongtin);
		mysqli_close($conn);
	}
	///////////////////
	function lich_chieu($conn,$thu) {
		$start = $page * $limit - $limit;
		$skin = $this->load('class_skin');
		$check = $this->load('class_check');
		$thongtin = mysqli_query($conn, "SELECT phim.*,lich_chieu.thu FROM lich_chieu INNER JOIN phim ON lich_chieu.phim=phim.id WHERE FIND_IN_SET($thu, lich_chieu.thu)>0 AND lich_chieu.an='0' ORDER BY phim.tieu_de DESC");
		$i = 0;
		while ($r_tt = mysqli_fetch_assoc($thongtin)) {
			$i++;
			if($r_tt['thoi_luong']==''){
				$r_tt['thoi_luong']='N/A';
			}
			if($r_tt['rate']==''){
				$r_tt['rate']='N/A';
			}
			$list .= $skin->skin_replace('skin/box_li/li_phim', $r_tt);
		}
		return $list;
		mysqli_free_result($thongtin);
		mysqli_close($conn);
	}
	function phantrang($page,$total,$link){
		if($total<=1){
			return '';
		}else{
			if($total<=5){
				for ($i=1; $i <=$total; $i++) { 
					if($i==$page){
						$list.='<a class="page-link active_page" href="'.$link.'" data-original-title="" title="Trang '.$i.'">'.$i.'</a>';
					}else{
						$list.='<a class="page-link" href="'.$link.'?page='.$i.'" data-original-title="" title="Trang '.$i.'">'.$i.'</a>';
					}
				}
				if($page==1){
					$back=1;
				}else{
					$back = $page - 1;
				}
				if($page==$total){
					$next=$total;
				}else{
					$next = $page + 1;
				}
				return '<a class="page-link" href="'.$link.'?page='.$back.'" data-original-title="" title="Trang '.$back.'"><i class="fa fa-caret-left"></i></a>'.$list.'<a class="page-link" href="'.$link.'?page='.$next.'" data-original-title="" title="Trang '.$next.'"><i class="fa fa-caret-right"></i></a>';
			}else if($page<$total - 2){
				if($page>2){
					$dau=$page - 2;
					$cuoi=$page + 2;
					for ($i=$dau; $i <=$cuoi; $i++) { 
						if($i==$page){
							$list.='<a class="page-link active_page" href="'.$link.'" data-original-title="" title="Trang '.$i.'">'.$i.'</a>';
						}else{
							$list.='<a class="page-link" href="'.$link.'?page='.$i.'" data-original-title="" title="Trang '.$i.'">'.$i.'</a>';
						}
					}
					if($page==1){
						$back=1;
					}else{
						$back = $page - 1;
					}
					if($page==$total){
						$next=$total;
					}else{
						$next = $page + 1;
					}
					return '<a class="page-link" href="'.$link.'?page='.$back.'" data-original-title="" title="Trang '.$back.'"><i class="fa fa-caret-left"></i></a>'.$list.'<a class="page-link" href="'.$link.'?page='.$next.'" data-original-title="" title="Trang '.$next.'"><i class="fa fa-caret-right"></i></a>';
				}else{
					for ($i=1; $i <=5; $i++) { 
						if($i==$page){
							$list.='<a class="page-link active_page" href="'.$link.'" data-original-title="" title="Trang '.$i.'">'.$i.'</a>';
						}else{
							$list.='<a class="page-link" href="'.$link.'?page='.$i.'" data-original-title="" title="Trang '.$i.'">'.$i.'</a>';
						}
					}
					if($page==1){
						$back=1;
					}else{
						$back = $page - 1;
					}
					if($page==$total){
						$next=$total;
					}else{
						$next = $page + 1;
					}
					return '<a class="page-link" href="'.$link.'?page='.$back.'" data-original-title="" title="Trang '.$back.'"><i class="fa fa-caret-left"></i></a>'.$list.'<a class="page-link" href="'.$link.'?page='.$next.'" data-original-title="" title="Trang '.$next.'"><i class="fa fa-caret-right"></i></a>';
				}
			}else{
				$dau=$total - 4;
				for ($i=$dau; $i <=$total; $i++) { 
					if($i==$page){
						$list.='<a class="page-link active_page" href="'.$link.'" data-original-title="" title="Trang '.$i.'">'.$i.'</a>';
					}else{
						$list.='<a class="page-link" href="'.$link.'?page='.$i.'" data-original-title="" title="Trang '.$i.'">'.$i.'</a>';
					}
				}
				if($page==1){
					$back=1;
				}else{
					$back = $page - 1;
				}
				if($page==$total){
					$next=$total;
				}else{
					$next = $page + 1;
				}
				return '<a class="page-link" href="'.$link.'?page='.$back.'" data-original-title="" title="Trang '.$back.'"><i class="fa fa-caret-left"></i></a>'.$list.'<a class="page-link" href="'.$link.'?page='.$next.'" data-original-title="" title="Trang '.$next.'"><i class="fa fa-caret-right"></i></a>';

			}

		}
	}
	function phantrang_timkiem($page,$total,$link){
		if($total<=1){
			return '';
		}else{
			if($total<=5){
				for ($i=1; $i <=$total; $i++) { 
					if($i==$page){
						$list.='<a class="page-link active_page" href="'.$link.'" data-original-title="" title="Trang '.$i.'">'.$i.'</a>';
					}else{
						$list.='<a class="page-link" href="'.$link.'&page='.$i.'" data-original-title="" title="Trang '.$i.'">'.$i.'</a>';
					}
				}
				if($page==1){
					$back=1;
				}else{
					$back = $page - 1;
				}
				if($page==$total){
					$next=$total;
				}else{
					$next = $page + 1;
				}
				return '<a class="page-link" href="'.$link.'&page='.$back.'" data-original-title="" title="Trang '.$back.'"><i class="fa fa-caret-left"></i></a>'.$list.'<a class="page-link" href="'.$link.'&page='.$next.'" data-original-title="" title="Trang '.$next.'"><i class="fa fa-caret-right"></i></a>';
			}else if($page<$total - 2){
				if($page>2){
					$dau=$page - 2;
					$cuoi=$page + 2;
					for ($i=$dau; $i <=$cuoi; $i++) { 
						if($i==$page){
							$list.='<a class="page-link active_page" href="'.$link.'" data-original-title="" title="Trang '.$i.'">'.$i.'</a>';
						}else{
							$list.='<a class="page-link" href="'.$link.'&page='.$i.'" data-original-title="" title="Trang '.$i.'">'.$i.'</a>';
						}
					}
					if($page==1){
						$back=1;
					}else{
						$back = $page - 1;
					}
					if($page==$total){
						$next=$total;
					}else{
						$next = $page + 1;
					}
					return '<a class="page-link" href="'.$link.'&page='.$back.'" data-original-title="" title="Trang '.$back.'"><i class="fa fa-caret-left"></i></a>'.$list.'<a class="page-link" href="'.$link.'&page='.$next.'" data-original-title="" title="Trang '.$next.'"><i class="fa fa-caret-right"></i></a>';
				}else{
					for ($i=1; $i <=5; $i++) { 
						if($i==$page){
							$list.='<a class="page-link active_page" href="'.$link.'" data-original-title="" title="Trang '.$i.'">'.$i.'</a>';
						}else{
							$list.='<a class="page-link" href="'.$link.'&page='.$i.'" data-original-title="" title="Trang '.$i.'">'.$i.'</a>';
						}
					}
					if($page==1){
						$back=1;
					}else{
						$back = $page - 1;
					}
					if($page==$total){
						$next=$total;
					}else{
						$next = $page + 1;
					}
					return '<a class="page-link" href="'.$link.'&page='.$back.'" data-original-title="" title="Trang '.$back.'"><i class="fa fa-caret-left"></i></a>'.$list.'<a class="page-link" href="'.$link.'&page='.$next.'" data-original-title="" title="Trang '.$next.'"><i class="fa fa-caret-right"></i></a>';
				}
			}else{
				$dau=$total - 4;
				for ($i=$dau; $i <=$total; $i++) { 
					if($i==$page){
						$list.='<a class="page-link active_page" href="'.$link.'" data-original-title="" title="Trang '.$i.'">'.$i.'</a>';
					}else{
						$list.='<a class="page-link" href="'.$link.'&page='.$i.'" data-original-title="" title="Trang '.$i.'">'.$i.'</a>';
					}
				}
				if($page==1){
					$back=1;
				}else{
					$back = $page - 1;
				}
				if($page==$total){
					$next=$total;
				}else{
					$next = $page + 1;
				}
				return '<a class="page-link" href="'.$link.'&page='.$back.'" data-original-title="" title="Trang '.$back.'"><i class="fa fa-caret-left"></i></a>'.$list.'<a class="page-link" href="'.$link.'&page='.$next.'" data-original-title="" title="Trang '.$next.'"><i class="fa fa-caret-right"></i></a>';

			}

		}
	}
}
?>

