<?php
include('./includes/tlca_world.php');
$check=$tlca_do->load('class_check');
$thongtin=mysqli_query($conn,"SELECT * FROM list_tap ORDER BY id ASC");
while($r_tt=mysqli_fetch_assoc($thongtin)){
	$tieu_de=strtoupper($r_tt['tieu_de']);
	if(strpos($tieu_de, 'TẬP')!==false){
	}else{
		$tieu_de='Tập '.$tieu_de;
		mysqli_query($conn,"UPDATE list_tap SET tieu_de='$tieu_de' WHERE id='{$r_tt['id']}'");
		echo "Đã cập nhật ".$tieu_de.'<br>';
	}
}
?>