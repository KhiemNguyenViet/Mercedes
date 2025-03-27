 <?php
    class class_member extends class_manage{
        function check_login(){
            if(!isset($_COOKIE['user_id'])){
                return 0;
            }else{
                //setcookie('user_id',$_COOKIE['user_id'],time()+3600);
                return $_COOKIE['user_id'];
            }
        }
        ///////////////////////
        function login($conn,$username,$password){
            if(strlen($username)<4){
                return 0;
            }else{
                $info=mysqli_query($conn,"SELECT * FROM user_info WHERE username='$username'");
                $total=mysqli_num_rows($info);
                if($total>0){
                    $r_info=mysqli_fetch_assoc($info);
                    $pass=md5($password);
                    if($pass!=$r_info['password']){
                        return 2;
                    }elseif($r_info['active']!='1'){
                        return 3;

                    }else{
                        $hientai=time();
                        $check=$this->load('class_check');
                        $token=$check->random_string(20);
                        $ip_address=$_SERVER['REMOTE_ADDR'];
                        setcookie("token",$token,time() + 31536000);
                        mysqli_query($conn,"INSERT INTO user_online(user_id,token,ip_address,created)VALUES('{$r_info['user_id']}','$token','$ip_address',".time().")");
                        mysqli_query($conn,"UPDATE user_info SET logined='$hientai',end_online='$hientai' WHERE user_id='{$r_info['user_id']}'");
                        setcookie("user_id",$r_info['user_id'],time() + 31536000);
                        return 200;
                    }

                }else{
                    return 1;
                }
            }

        }
        ///////////////////////
        function login_email($conn,$email,$password){
            if(strlen($email)<4){
                return 0;
            }else{
                $info=mysqli_query($conn,"SELECT * FROM user_info WHERE email='$email'");
                $total=mysqli_num_rows($info);
                if($total>0){
                    $r_info=mysqli_fetch_assoc($info);
                    $pass=md5($password);
                    if($pass!=$r_info['password']){
                        return 2;
                    }elseif($r_info['active']!='1'){
                        return 3;

                    }else{
                        $hientai=time();
                        $check=$this->load('class_check');
                        $token=$check->random_string(20);
                        $ip_address=$_SERVER['REMOTE_ADDR'];
                        setcookie("token",$token,time() + 31536000);
                        mysqli_query($conn,"INSERT INTO user_online(user_id,token,ip_address,created)VALUES('{$r_info['user_id']}','$token','$ip_address',".time().")");
                        mysqli_query($conn,"UPDATE user_info SET logined='$hientai' WHERE user_id='{$r_info['user_id']}'");
                        setcookie("user_id",$r_info['user_id'],time() + 31536000);
                        return 200;
                    }

                }else{
                    return 1;
                }
            }
        }
        ///////////////////////
        function login_mobile($conn,$mobile,$password){
            if(strlen($mobile)<8){
                return 0;
            }else{
                $info=mysqli_query($conn,"SELECT * FROM user_info WHERE mobile='$mobile'");
                $total=mysqli_num_rows($info);
                if($total>0){
                    $r_info=mysqli_fetch_assoc($info);
                    $pass=md5($password);
                    if($pass!=$r_info['password']){
                        return 2;
                    }elseif($r_info['active']!='1'){
                        return 3;

                    }else{
                        $hientai=time();
                        $check=$this->load('class_check');
                        $token=$check->random_string(20);
                        $ip_address=$_SERVER['REMOTE_ADDR'];
                        setcookie("token",$token,time() + 31536000);
                        mysqli_query($conn,"INSERT INTO user_online(user_id,token,ip_address,created)VALUES('{$r_info['user_id']}','$token','$ip_address',".time().")");
                        mysqli_query($conn,"UPDATE user_info SET logined='$hientai' WHERE user_id='{$r_info['user_id']}'");
                        setcookie("user_id",$r_info['user_id'],time() + 31536000);
                        return 200;
                    }

                }else{
                    return 1;
                }
            }
        }
        ///////////////////////
        function openid_login($conn,$username,$type){
            if($type=='facebook'){
                $info=mysqli_query($conn,"SELECT * FROM user_info WHERE id_fb='$username'");
                $total=mysqli_num_rows($info);
                if($total>0){
                    $r_info=mysqli_fetch_assoc($info);
                    if($r_info['active']!='1'){
                        return 3;
                    }else{
                        $hientai=time();
                        $check=$this->load('class_check');
                        $token=$check->random_string(20);
                        $ip_address=$_SERVER['REMOTE_ADDR'];
                        setcookie("token",$token,time() + 31536000);
                        mysqli_query($conn,"INSERT INTO user_online(user_id,token,ip_address,created)VALUES('{$r_info['user_id']}','$token','$ip_address',".time().")");
                        mysqli_query($conn,"UPDATE user_info SET logined='$hientai' WHERE user_id='{$r_info['user_id']}'");
                        setcookie("user_id",$r_info['user_id'],time() + 31536000);
                        return 200;
                    }

                }else{
                    return 1;
                }
            }else if($type=='google'){
                $info=mysqli_query($conn,"SELECT * FROM user_info WHERE email='$username'");
                $total=mysqli_num_rows($info);
                if($total>0){
                    $r_info=mysqli_fetch_assoc($info);
                    if($r_info['active']!='1'){
                        return 3;
                    }else{
                        $hientai=time();
                        $check=$this->load('class_check');
                        $token=$check->random_string(20);
                        $ip_address=$_SERVER['REMOTE_ADDR'];
                        setcookie("token",$token,time() + 31536000);
                        mysqli_query($conn,"INSERT INTO user_online(user_id,token,ip_address,created)VALUES('{$r_info['user_id']}','$token','$ip_address',".time().")");
                        mysqli_query($conn,"UPDATE user_info SET logined='$hientai' WHERE id='{$r_info['user_id']}'");
                        setcookie("user_id",$r_info['user_id'],time() + 31536000);
                        return 200;
                    }

                }else{
                    return 1;
                }

            }
        }
        ///////////////////////
        function logout($conn){
            mysqli_query($conn,"DELETE FROM user_online WHERE user_id='{$_COOKIE['user_id']}' AND token='{$_COOKIE['token']}'");
            setcookie("token",$_COOKIE['token'],time() - 3600);
            setcookie("user_id",$_COOKIE['user_id'],time() - 3600);
        }
        ///////////////////////
        function register_email($conn,$name,$email,$password){
            $check = $this->load('class_check');
            if($check->check_email($email)==true){
                $info=mysqli_query($conn,"SELECT * FROM user_info WHERE email='$email' ORDER BY user_id ASC LIMIT 1");
                $total=mysqli_num_rows($info);
                if($total>0){
                    $r_info=mysqli_fetch_assoc($info);
                    if($r_info['active']==0){
                        return 1;
                    }else{
                        return 2;

                    }
                }else if(strlen($name)<2){
                    return 3;
                }else if(strlen($password)<6){
                    return 4;
                }else{
                    $pass=md5($password);
                    $code=$check->random_string(20);
                    $ip_address=$_SERVER['REMOTE_ADDR'];
                    $limit=time()-300;
                    $info_limit=mysqli_query($conn,"SELECT * FROM user_info WHERE ip_address='$ip_address' AND created>'$limit'");
                    $total_limit=mysqli_num_rows($info_limit);
                    if($total_limit>0){
                        return 5;
                    }else{
                        mysqli_query($conn,"INSERT INTO user_info (name,email,password,code_active,active,created,ip_address)VALUES('$name','$email','$pass','$code','1',".time().",'$ip_address')");
                        $mem_info=mysqli_query($conn,"SELECT * FROM user_info WHERE email='$email' ORDER BY user_id DESC LIMIT 1");
                        $r_m=mysqli_fetch_assoc($mem_info);
                        setcookie('user_id',$r_m['user_id'],time()+31536000);
                        return 200;
                    }
                }
            }else{
                return 0;

            }
        }
        ///////////////////////
        function register_mobile($conn,$name,$mobile,$password){
            $check = $this->load('class_check');
            if($check->check_mobile($mobile)==true){
                $info=mysqli_query($conn,"SELECT * FROM user_info WHERE mobile='$mobile' ORDER BY user_id ASC LIMIT 1");
                $total=mysqli_num_rows($info);
                if($total>0){
                    $r_info=mysqli_fetch_assoc($info);
                    if($r_info['active']==0){
                        return 1;
                    }else{
                        return 2;

                    }
                }else if(strlen($name)<2){
                    return 3;
                }else if(strlen($password)<6){
                    return 4;
                }else{
                    $pass=md5($password);
                    $code=$check->random_number(6);
                    $ip_address=$_SERVER['REMOTE_ADDR'];
                    $limit=time()-300;
                    $info_limit=mysqli_query($conn,"SELECT * FROM user_info WHERE ip_address='$ip_address' AND created>'$limit'");
                    $total_limit=mysqli_num_rows($info_limit);
                    if($total_limit>0){
                        return 5;
                    }else{
                        mysqli_query($conn,"INSERT INTO user_info (name,mobile,password,code_active,active,created,ip_address)VALUES('$name','$mobile','$pass','$code','1',".time().",'$ip_address')");
                        $mem_info=mysqli_query($conn,"SELECT * FROM user_info WHERE mobile='$mobile' ORDER BY user_id DESC LIMIT 1");
                        $r_m=mysqli_fetch_assoc($mem_info);
                        //$check->send_smsnhanh($mobile,'Ma kich hoat tai khoan tai 18008198.com cua ban la: '.$code);
                        setcookie('user_id',$r_m['user_id'],time()+31536000);
                        return 200;
                    }
                }
            }else{
                return 0;

            }
        }
        ///////////////////////
        function user_info($conn,$user_id){
            $check = $this->load('class_check');
            $tach=json_decode($check->token_login_decode($user_id),true);
            $user_id=$tach['user_id'];
            $password=$tach['password'];
            $info=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='$user_id' AND password='$password' ORDER BY user_id ASC LIMIT 1");
            $total=mysqli_num_rows($info);
            if($total>0){
                $r_info=mysqli_fetch_assoc($info);
                return $r_info;
            }else{
                return '';
            }
        }

    }
?>

