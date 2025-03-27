<?php
function token_login($user_id,$password){
    $pass_1=substr($password, 0,8);
    $pass_2=substr($password, 8,8);
    $pass_3=substr($password, 16,8);
    $pass_4=substr($password, 24,8);
    $string=$pass_1.'-'.$pass_3.'-'.$pass_2.''.$user_id.'-'.$pass_2.'-'.$pass_4;
    $token_login=base64_encode($string);
    return $token_login;
}
include('./includes/config.php');
$email=addslashes(strip_tags($_REQUEST['username']));
$password=addslashes(strip_tags($_REQUEST['password']));
$thongtin=mysqli_query($conn,"SELECT *,count(*) AS total FROM user_info WHERE email='$email' OR username='$email'");
$r_tt=mysqli_fetch_assoc($thongtin);
if($r_tt['total']>0){
    $pass=md5($password.''.$r_tt['salt']);
    if($pass!=$r_tt['password']){
        $ok=0;
        $thongbao='Mật khẩu không đúng';
    }else if($r_tt['active']==0){
        $ok=0;
        $thongbao='Tài khoản của bạn chưa kích hoạt';
    }else if($r_tt['active']==2){
        $ok=0;
        $thongbao='Tài khoản của bạn đang tạm khóa';
    }else if($r_tt['active']==3){
        $ok=0;
        $thongbao='Tài khoản của bạn đã khóa vĩnh viễn';
    }else{
        $hientai=time();
        setcookie("user_id",token_login($r_tt['user_id'],$r_tt['password']),time() + 2593000,'/');
        $ok=1;
        $thongbao='Đang nhập thành công';
    }
}else{
    $ok=0;
    $thongbao='Tài khoản không tồn tại';
}
$info=array(
	'ok'=>$ok,
	'thongbao'=>$thongbao
);
echo json_encode($info);
?>