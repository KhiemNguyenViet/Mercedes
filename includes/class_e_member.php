<?php
 class class_e_member extends class_manage
 {
    function check_login(){
        if(!isset($_COOKIE['emin_id'])){
            return 0;
        }else{
            //setcookie('user_id',$_COOKIE['user_id'],time()+3600);
            return $_COOKIE['emin_id'];
        }
    }
    /////////////////////////////////
    function token_login($user_id,$password){
        $pass_1=substr($password, 0,8);
        $pass_2=substr($password, 8,8);
        $pass_3=substr($password, 16,8);
        $pass_4=substr($password, 24,8);
        $string=$pass_1.'-'.$pass_3.'-'.$pass_2.''.$user_id.'-'.$pass_2.'-'.$pass_4;
        $token_login=base64_encode($string);
        return $token_login;
    }
    /////////////////////////////////
    function token_login_decode($token){
        $string=base64_decode($token);
        $tach_string=explode('-',$string);
        $pass_1=$tach_string[0];
        $pass_2=$tach_string[3];
        $pass_3=$tach_string[1];
        $pass_4=$tach_string[4];
        $password=$pass_1.''.$pass_2.''.$pass_3.''.$pass_4;
        $user_id=str_replace($pass_2, '', $tach_string[2]);
        $info=array('user_id'=>$user_id,'password'=>$password);
        return json_encode($info);
    }
    ///////////////////////
    function login($conn,$username,$password,$remember){
        if(strlen($username)<4){
            return 0;
        }else{
            $info=mysqli_query($conn,"SELECT * FROM emin_info WHERE username='$username'");
            $total=mysqli_num_rows($info);
            if($total>0){
                $r_info=mysqli_fetch_assoc($info);
                $pass=md5($password);
                if($pass!=$r_info['password']){
                    return 2;
                }else{
                    if($remember=='on'){
                        setcookie("emin_id",$this->token_login($r_info['id'],$r_tt['password']),time() + 31536000,'/');
                    }else{
                        setcookie("emin_id",$this->token_login($r_info['id'],$r_tt['password']),time() + 3600,'/');
                    }
                    return 200;
                }
            }else{
                return 1;
            }
        }
    }
//////////////////////////////////////////////////////////
    function logout(){
        setcookie("emin_id",$_COOKIE['emin_id'],time() - 3600,'/');
    }
///////////////////////////////////////////////////////////
    function user_info($conn,$user_id){
        $user_id = intval($user_id);
        $thongtin=mysqli_query($conn,"SELECT * FROM emin_info WHERE id='$user_id'");   
        $total=mysqli_num_rows($thongtin);    
        if($total>0){
            $r_tt=mysqli_fetch_assoc($thongtin);
        }
        return $r_tt;
    }
///////////////////////////////////////////////////////////
    function acount_info($conn,$username){
        $username = addslashes($username);
        $thongtin=mysqli_query($conn,"SELECT * FROM emin_info WHERE username='$username'");   
        $total=mysqli_num_rows($thongtin);    
        if($total>0){
            $r_tt=mysqli_fetch_assoc($thongtin);
        }
        return $r_tt;
    }
/////////////////////////////////////////////////////////////
}
?>
