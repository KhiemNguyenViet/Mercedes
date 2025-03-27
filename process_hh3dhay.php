<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers:*');
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$setting=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name ASC");
while ($r_s=mysqli_fetch_assoc($setting)) {
	$index_setting[$r_s['name']]=$r_s['value'];
}
$img=$_REQUEST['img'];
$anh=intval($_REQUEST['anh']);
$url=strip_tags(addslashes($_REQUEST['url']));
$baomat=addslashes(strip_tags($_REQUEST['baomat']));
$action=addslashes(strip_tags($_REQUEST['action']));
$loai=addslashes(strip_tags($_REQUEST['loai']));
if($baomat=='thangngu'){
	if($loai=='get_list'){
		if($action=='select_phim'){
			$id=file_get_contents('id_get.txt');
			$id=preg_replace('/[^0-9]/', '', $id);
			$id=intval($id);
			$ngay=intval(date('d'));
			$thongtin=mysqli_query($conn,"SELECT * FROM phim WHERE id>'$id' AND (crawl='0' OR ngay!='$ngay') AND link_copy LIKE '%hh3dhay.com%' ORDER BY id ASC LIMIT 1");
			$total=mysqli_num_rows($thongtin);
			if($total>0){

				$r_tt=mysqli_fetch_assoc($thongtin);
				$fp = fopen('id_get.txt', 'w');
				fwrite($fp, $r_tt['id']);
				fclose($fp);
				if(strpos($r_tt['link_copy'], 'hh3dhay.com')!==false){
					$link=$r_tt['link_copy'];
					$ok=1;
				}else{

				}
			}else{
				$thongtin_cu=mysqli_query($conn,"SELECT * FROM phim WHERE (crawl='0' OR ngay!='$ngay') AND link_copy LIKE '%hh3dhay.com%' ORDER BY id ASC LIMIT 1");
				$total_cu=mysqli_num_rows($thongtin_cu);
				if($total_cu>0){
					$r_tt=mysqli_fetch_assoc($thongtin_cu);
					$fp = fopen('id_get.txt', 'w');
					fwrite($fp, $r_tt['id']);
					fclose($fp);
					if(strpos($r_tt['link_copy'], 'hh3dhay.com')!==false){
						$link=$r_tt['link_copy'];
						$ok=1;
					}else{

					}
				}else{
					$ok=0;
					$link='';
				}
			}
			echo json_encode(array('ok'=>$ok,'link'=>$link));

		}else if($action=='tap_link'){
			$list=$_REQUEST['list'];
			$nguon=addslashes(strip_tags($_REQUEST['nguon']));
			$ngay=intval(date('d'));
			$k=intval($_REQUEST['k']);
			$tach_list=json_decode('['.$list.']',true);
			if(strpos($nguon, 'hh3dhay.com')!==false){
				$thongtin_phim=mysqli_query($conn,"SELECT *,count(*) AS total FROM phim WHERE link_copy='$nguon'");
				$r_t=mysqli_fetch_assoc($thongtin_phim);
				$total=mysqli_num_rows($thongtin_phim);
				if($total>0){
					foreach ($tach_list as $key => $value) {
						$ten=intval($value['ten']);
						$link=$value['link'];
						$phim=$r_t['id'];
						$thongtin_copy=mysqli_query($conn,"SELECT * FROM link_copy WHERE link='$link'");
						$total_link=mysqli_num_rows($thongtin_copy);
						if($total_link>0){

						}else{
							mysqli_query($conn,"INSERT INTO link_copy(phim,tap,link,copy)VALUES('$phim','$ten','$link','0')");
						}
					}
					mysqli_query($conn,"UPDATE phim SET crawl='1',ngay='$ngay' WHERE id='{$r_t['id']}'");
					$id=file_get_contents('id_get.txt');
					$id=preg_replace('/[^0-9]/', '', $id);
					$fp = fopen('id_get.txt', 'w');
					$thongtin=mysqli_query($conn,"SELECT * FROM phim WHERE id>'$id' AND (crawl='0' OR ngay!='$ngay') AND link_copy LIKE '%hh3dhay.com%' ORDER BY id ASC LIMIT 1");
					$total=mysqli_num_rows($thongtin);
					if($total==0){
						$tiep=0;
					}else{
						$tiep=1;
					}
				}else{

				}
			}
			echo json_encode(array('tiep'=>$tiep,'link'=>$link));

		}
	}else if($loai=='add'){
		$nguon=addslashes(strip_tags($_REQUEST['nguon']));
		if($action=='select_phim'){
			$thongtin=mysqli_query($conn,"SELECT * FROM link_copy WHERE copy='0' ORDER BY tap ASC, phim ASC LIMIT 1");
			$total=mysqli_num_rows($thongtin);
			if($total>0){
				$r_tt=mysqli_fetch_assoc($thongtin);
				$ok=1;
				$link=$r_tt['link'];
				mysqli_query($conn,"UPDATE link_copy SET copy='1' WHERE link='{$r_tt['link']}'");
			}else{
				$ok=0;
				$link='';
			}
			echo json_encode(array('ok'=>$ok,'link'=>$link));
		}else if($action=='update_noidung'){
			$tieu_de=addslashes(strip_tags($_REQUEST['tieu_de']));
			$link_media=addslashes(strip_tags($_REQUEST['link_media']));
			$link_media=str_replace('https://hh3dhay.com/embed/?link=', '', $link_media);
			$tach_media=explode('&id=', $link_media);
			$link_media=$tach_media[0];
			$ten_server=addslashes(strip_tags($_REQUEST['ten_server']));
			$hientai=time();
			if(strpos($nguon, 'hh3dhay.com')!==false){
				$thongtin=mysqli_query($conn,"SELECT *, count(*) AS total FROM link_copy WHERE link='$nguon' ORDER BY id ASC LIMIT 1");
				$r_tt=mysqli_fetch_assoc($thongtin);
				if($r_tt['total']>0){
					$thongtin_tap=mysqli_query($conn,"SELECT * FROM list_tap WHERE phim='{$r_tt['phim']}' AND thu_tu='{$r_tt['tap']}'");
					$total_tap=mysqli_num_rows($thongtin_tap);
					if($total_tap>0){
						$r_tap=mysqli_fetch_assoc($thongtin_tap);
						$tach_tap=json_decode('['.$r_tap['server'].']',true);
						$k=0;
						$co=0;
						foreach ($tach_tap as $key => $value) {
							$k++;
							if($value['nguon']==$link_media){
								$co=1;
							}
						}
						if($co==0){
							$server=$r_tap['server'].',{"server":"'.$ten_server.'","nguon":"'.$link_media.'"}';
							mysqli_query($conn,"UPDATE list_tap SET server='$server' WHERE id='{$r_tap['id']}'");
						}
					}else{
						$server='{"server":"'.$ten_server.'","nguon":"'.$link_media.'"}';
						mysqli_query($conn,"INSERT INTO list_tap(phim,tieu_de,server,thu_tu,date_post)VALUES('{$r_tt['phim']}','$tieu_de','$server','{$r_tt['tap']}','$hientai')");

					}
				}else{
					$ok=0;

				}
			}else{

			}
			echo json_encode(array('ok'=>$ok));
		}
	}
}else{
	echo "Can't access this url";
}
?>