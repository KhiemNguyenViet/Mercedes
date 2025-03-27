 <?php
 class class_check extends class_manage{
    function check_link($url=NULL){
        if($url == NULL) return false;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);//lay code tra ve cua http
            curl_close($ch);
            if($httpcode>=200 && $httpcode<300){
                return true;
            } else {
                return false;
            }
        }
    function show_thu($time){
        $weekday = date("l",$time);
        $weekday = strtolower($weekday);
        switch($weekday) {
            case 'monday':
                $weekday = '2';
                break;
            case 'tuesday':
                $weekday = '3';
                break;
            case 'wednesday':
                $weekday = '4';
                break;
            case 'thursday':
                $weekday = '5';
                break;
            case 'friday':
                $weekday = '6';
                break;
            case 'saturday':
                $weekday = '7';
                break;
            default:
                $weekday = '8';
                break;
        }
        return $weekday;
    }
    /////////////////////////////////
        function rate($diem){
            $diem=intval($diem);
            for($i=1;$i<=10;$i++){
                if($i==1){
                    $title='Không còn gì để nói...';
                }else if($i==2){
                    $title='Thật không thể tin nổi.';
                }else if($i==3){
                    $title='Cái gì thế này ?!';
                }else if($i==4){
                    $title='Haizz';
                }else if($i==5){
                    $title='Tạm';
                }else if($i==6){
                    $title='Cũng được';
                }else if($i==7){
                    $title='Khá đấy';
                }else if($i==8){
                    $title='Được';
                }else if($i==9){
                    $title='Hay';
                }else{
                    $title='Tuyệt đỉnh!';
                }
                if($i<=$diem){
                    $list.='<img alt="'.$i.'" id="rate_'.$i.'" src="/images/star-on.png" title="'.$title.'"> ';
                }else{
                    $list.='<img alt="'.$i.'" id="rate_'.$i.'" src="/images/star-off.png" title="'.$title.'"> ';
                }
            }
            $list=substr($list, 0,-1);
            return $list;
        }
    /////////////////////////////////
    function time_online($time){
        $thoigian=intval($time);
        if($thoigian<60){
            if($thoigian<10){
                return '0'.$thoigian.' giây';
            }else{
                return $thoigian.' giây';
            }
        }else if($thoigian<3600){
            $phut=floor($thoigian/60);
            $conlai=$thoigian - $phut*60;
            if($phut<10){
                $phut='0'.$phut;
            }
            if($conlai<10){
                $conlai='0'.$conlai;
            }
            return $phut.' phút '.$conlai.' giây';
        }else{
            $gio=floor($thoigian/3600);
            $conlai=$thoigian - $gio*3600;
            $phut=floor($conlai/60);
            $giay=$conlai - $phut*60;
            if($gio<10){
                $gio='0'.$gio;
            }
            if($phut<10){
                $phut='0'.$phut;
            }
            if($giay<10){
                $giay='0'.$giay;
            }
            return $gio.' giờ '.$phut.' phút '.$giay.' giây';
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
    /////////////////////////////////
    function date_update($time){
        $thoigian=time() - $time;
        if($thoigian<60){
            return 'Mới cập nhật';
        }else if($thoigian<3600){
            return floor($thoigian/60).' phút trước';
        }else if($thoigian<86400){
            $gio=floor($thoigian/3600);
            $conlai=$thoigian - $gio*3600;
            $phut=floor($conlai/60);
            //return $gio.' giờ '.$phut.' phút trước';
            return $gio.' giờ trước';
        }else if($thoigian<604800){
            $ngay=floor($thoigian/86400);
            return $ngay.' ngày trước';
        }else{
            return date('d/m/Y', $time);
        }
    }
    /////////////////////////////////
    function chat_update($time){
        $thoigian=time() - $time;
        if($thoigian<60){
            return 'Vài giây trước';
        }else if($thoigian<3600){
            return floor($thoigian/60).' phút trước';
        }else if($thoigian<86400){
            $gio=floor($thoigian/3600);
            $conlai=$thoigian - $gio*3600;
            $phut=floor($conlai/60);
            //return $gio.' giờ '.$phut.' phút trước';
            return $gio.' giờ trước';
        }else if($thoigian<604800){
            $ngay=floor($thoigian/86400);
            return $ngay.' ngày trước';
        }else{
            return date('d/m/Y', $time);
        }
    }
    /////////////////////////////////
    function history_update($time){
        $thoigian=time() - $time;
        if($thoigian<60){
            return 'Mới đọc xong';
        }else if($thoigian<3600){
            return floor($thoigian/60).' phút trước';
        }else if($thoigian<86400){
            $gio=floor($thoigian/3600);
            $conlai=$thoigian - $gio*3600;
            $phut=floor($conlai/60);
            //return $gio.' giờ '.$phut.' phút trước';
            return $gio.' giờ trước';
        }else if($thoigian<604800){
            $ngay=floor($thoigian/86400);
            return $ngay.' ngày trước';
        }else{
            return date('d/m/Y', $time);
        }
    }
    /////////////////////////////////
    function level($coin){
        $coin=intval($coin);
        if($coin<50000){
            return 'Thành viên mới';
        }else if($coin<100000){
            return 'VIP 1';            
        }else if($coin<200000){
            return 'VIP 2';            
        }else if($coin<300000){
            return 'VIP 3';            
        }else if($coin<400000){
            return 'VIP 4';            
        }else if($coin<500000){
            return 'VIP 5';            
        }else if($coin<600000){
            return 'VIP 6';            
        }else if($coin<700000){
            return 'VIP 7';            
        }else if($coin<800000){
            return 'VIP 8';            
        }else if($coin<900000){
            return 'VIP 9';            
        }else if($coin<1000000){
            return 'VIP 10';            
        }else if($coin<1100000){
            return 'VIP 11';            
        }else if($coin<1200000){
            return 'VIP 12';            
        }else if($coin<1300000){
            return 'VIP 13';            
        }else if($coin<1400000){
            return 'VIP 14';            
        }else if($coin<1500000){
            return 'VIP 15';            
        }else if($coin<1600000){
            return 'VIP 16';            
        }else if($coin<1700000){
            return 'VIP 17';            
        }else if($coin<1800000){
            return 'VIP 18';            
        }else if($coin<1900000){
            return 'VIP 19';            
        }else if($coin<2000000){
            return 'VIP 20';            
        }else{
            return 'SIÊU VIP';
        }
    }
    /////////////////////////////////
    function class_level($coin){
        $coin=intval($coin);
        if($coin<50000){
            return 'level_0';
        }else if($coin<100000){
            return 'level_1';           
        }else if($coin<200000){
            return 'level_2';           
        }else if($coin<300000){
            return 'level_3';            
        }else if($coin<400000){
            return 'level_4';            
        }else if($coin<500000){
            return 'level_5';         
        }else if($coin<600000){
            return 'level_6';         
        }else if($coin<700000){
            return 'level_7';         
        }else if($coin<800000){
            return 'level_8';         
        }else if($coin<900000){
            return 'level_9';          
        }else if($coin<1000000){
            return 'level_10';            
        }else if($coin<1100000){
            return 'level_11';           
        }else if($coin<1200000){
            return 'level_12';        
        }else if($coin<1300000){
            return 'level_13';       
        }else if($coin<1400000){
            return 'level_14';       
        }else if($coin<1500000){
            return 'level_15';            
        }else if($coin<1600000){
            return 'level_16';            
        }else if($coin<1700000){
            return 'level_17';      
        }else if($coin<1800000){
            return 'level_18';            
        }else if($coin<1900000){
            return 'level_19';            
        }else if($coin<2000000){
            return 'level_20';          
        }else{
            return 'level_top';
        }
    }
    /////////////////////////////////
    function rank($coin){
        $coin=intval($coin);
        if($coin<50000){
            return 'Hiếm';
        }else if($coin<200000){
            return 'Anh Hùng';            
        }else if($coin<700000){
            return 'Sử thi';            
        }else if($coin<2000000){
            return 'Huyền thoại';            
        }else{
            return 'Thần thoại';
        }
    }
    /////////////////////////////////
    function class_rank($coin){
        $coin=intval($coin);
        if($coin<50000){
            return 'level_1';
        }else if($coin<200000){
            return 'level_8';            
        }else if($coin<700000){
            return 'level_9';            
        }else if($coin<2000000){
            return 'level_11';            
        }else{
            return 'level_13';
        }
    }
    /////////////////////////////////
    function foldersize($path) {
        $total_size = 0;
        $files = scandir($path);
        foreach($files as $t) {
            if (is_dir(rtrim($path, '/') . '/' . $t)) {
                if ($t<>"." && $t<>"..") {
                    $size = $this->foldersize(rtrim($path, '/') . '/' . $t);
                    $total_size += $size;
                }
            } else {
                $size = filesize(rtrim($path, '/') . '/' . $t);
                $total_size += $size;
            }
        }
        return $total_size;
    }
    /////////////////////////////////
  function total_count($x,$str,$min_length){
    if(strlen($str)<$min_length){
        $count=0;
    }else{
        if(preg_match('/^'.$x.'/', $str)==true AND preg_match('/'.$x.'$/', $str)==true){
            $str=substr($str, 1,-1);
        }else if(preg_match('/^'.$x.'/', $str)==true){
            $str=substr($str, 1);
        }else if(preg_match('/'.$x.'/', $str)==true){
            $str=substr($str, 0,-1);
        }else{
            $str=$str;
        }
        $chars=str_split($str);
        $count=0;
        foreach($chars as &$char)
        {
            if($char==$x)
            {
              $count++;
          }
      }
      $count=$count+1;
  }
  return $count;
}
    /////////////////////////////////
function remote_size($file_url, $formatSize = true)
{
    $head = array_change_key_case(get_headers($file_url, 1));
            // content-length of download (in bytes), read from Content-Length: field
    $clen = isset($head['content-length']) ? $head['content-length'] : 0;
            // cannot retrieve file size, return "-1"
    if (!$clen) {
        return -1;
    }
    if (!$formatSize) {
        return $clen; 
                // return size in bytes
    }
    $size = $clen;
    switch ($clen) {
        case $clen < 1024:
        $size = $clen .' B'; break;
        case $clen < 1048576:
        $size = round($clen / 1024, 2) .' KB'; break;
        case $clen < 1073741824:
        $size = round($clen / 1048576, 2) . ' MB'; break;
        case $clen < 1099511627776:
        $size = round($clen / 1073741824, 2) . ' GB'; break;
    }
    return $size; 
            // return formatted size
}
/////////////////////////////////
function formatsize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format(($bytes / 1073741824),2).' GB';
    }elseif ($bytes >= 1048576) {
        return number_format(($bytes / 1048576),2).' MB';
    }else{
        return number_format(($bytes / 1024),2).' KB';
    }
}
/////////////////////////////////
function removeLink($str){
    $regex = '/<a (.*)<\/a>/isU';
    preg_match_all($regex,$str,$result);
    foreach($result[0] as $rs)
    {
        $regex = '/<a (.*)>(.*)<\/a>/isU';
        $text = preg_replace($regex,'$2',$rs);
        $str = str_replace($rs,$text,$str);
    }
    return $str;
}   
//////////////////////////////
function duoi_file($filename){
    $duoi= strtolower(substr(basename($filename), strrpos(basename($filename), ".") + 1));
    if(strpos($duoi, '?')!==false){
        $tach_duoi=explode('?', $duoi);
        return $tach_duoi[0];
    }else{
        return $duoi;
    }
}
/////////////////////////////////
function text_chuan($str){
    $x=explode(' ', $str);
    $count=count($x);
    for ($i=0; $i < $count ; $i++) { 
        if($x[$i]==''){
            $list.='';
        }else{
            $list.=$x[$i].' ';
        }
    }
    $list=trim($list);
    return $list;
}
function link_chuan($str){
    $x=explode(' ', $str);
    $count=count($x);
    for ($i=0; $i < $count ; $i++) { 
        if(in_array($x[$i], array('','!','@','#','$','%','^','&','*','(',')','_','+','-','=',',',';','<','>','.','?','/','{','}','[',']','|',"\\",':',"'",'"',' '))==true){
            $list.='';
        }else{
            $list.=$x[$i].' ';
        }
    }
    $list=trim($list);
    return $list;
}
/////////////////////////////////
function show_smile($directory = './images/smile/default/',$id,$size){
    if ($directory != '.')
    {
        $directory = rtrim($directory, '/') . '/';
    }
    if ($handle = opendir($directory))
    {
        while (false !== ($file = readdir($handle)))
        {
            if ($file != '.' && $file != '..')
            {
                $list.='<input type="button" class="item_smile" onclick="add_smile(\''.$directory.''.$file.'\',\''.$id.'\');" style="background: url('.$directory.''.$file.'); background-size: 100%;border: none;cursor: pointer;width: '.$size.'px; height: '.$size.'px;">';
            }
        }
        return $list;                
        closedir($handle);
    }
}
/////////////////////////////////
function show_smile_chat($directory = './images/smile/default/',$size){
    if ($directory != '.')
    {
        $directory = rtrim($directory, '/') . '/';
    }
    if ($handle = opendir($directory))
    {
        while (false !== ($file = readdir($handle)))
        {
            if ($file != '.' && $file != '..')
            {
                $list.='<input type="button" class="item_smile" src="'.$directory.''.$file.'" onclick="add_smile_chat(\''.$directory.''.$file.'\');" style="background: url('.$directory.''.$file.'); background-size: 100%;border: none;cursor: pointer;width: '.$size.'px; height: '.$size.'px;">';
            }
        }
        return $list;                
        closedir($handle);
    }
}
    /////////////////////////////////
function check_email($email_address){
    return ((preg_match("/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/", trim($email_address)) == true) ? true : false);
}
    /////////////////////////////////          
function check_username($string, $valid_chars = "abcdefghijklmnopqrstuvwxyz0123456789"){
    if(strlen($string)<4 OR strlen($string)>32){
        return false;
    }else{
        for ($i = 0; $i < strlen($string); $i++) {
            $string_preg_match = preg_quote(substr($string, $i, 1));
            if (preg_match("/{$string_preg_match}/", $valid_chars) == false) {
                return false;
            }
        }
        return true;
    }
}
    /////////////////////////////////
function check_mobile($mobile){
    $firts_3=substr($mobile, 0,3);
    $firts_4=substr($mobile, 0,4);
    if(in_array($firts_3, array('086', '096', '097', '098', '090', '093','091', '094','088','092','099'))==true){
        if(strlen($mobile)==10){
            return true;
        }else{
            return false;
        }
    }else if(in_array($firts_4, array('0162', '0163', '0164', '0165', '0166', '0167', '0168', '0169','0120', '0121', '0122', '0126', '0128','091', '0123', '0124', '0125', '0127', '0129', '0188','0186', '0199'))==true){
        if(strlen($mobile)==11){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}
    /////////////////////////////////
function send_sms($mobile,$content){
    $APIKey="0D27253FF6CE6CBE143AF565098402";
    $SecretKey="DCB095AEC30F920758942569126A4B";
    $ch = curl_init();
    $SampleXml = "<RQST>"
    . "<APIKEY>". $APIKey ."</APIKEY>"
    . "<SECRETKEY>". $SecretKey ."</SECRETKEY>"                                    
    . "<ISFLASH>0</ISFLASH>"
    . "<SMSTYPE>7</SMSTYPE>"
    . "<CONTENT>".$content."</CONTENT>"
    . "<CONTACTS>"
    . "<CUSTOMER>"
    . "<PHONE>". $mobile ."</PHONE>"
    . "</CUSTOMER>"                               
    . "</CONTACTS>"
    . "</RQST>";
    curl_setopt($ch, CURLOPT_URL,            "http://api.esms.vn/MainService.svc/xml/SendMultipleMessage_V2/" );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($ch, CURLOPT_POST,           1 );
    curl_setopt($ch, CURLOPT_POSTFIELDS,     $SampleXml ); 
    curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain')); 
    $result=curl_exec ($ch);        
    $xml = simplexml_load_string($result);
    if ($xml === false) {
        return false;
    }else{
        return true;
    }
}
    /////////////////////////////////
function send_smsnhanh($mobile,$content){
    $key='0D13FJR0';
    $content=urlencode($content);
    $link='http://api.smsnhanh.com/v2/?Accesskey='.$key.'&PhoneNumber='.$mobile.'&Text='.$content.'&Type=VIP';            
    $ch = @curl_init();
    curl_setopt($ch, CURLOPT_URL, $link);
    $head[] = "Connection: keep-alive";
    $head[] = "Keep-Alive: 300";
    $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    $head[] = "Accept-Language: en-us,en;q=0.5";
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Expect:'
    ));
    $page = curl_exec($ch);
    curl_close($ch);
    return $page;
}
    /////////////////////////////////
function photo_height($filename )
{
  $size_info=@getimagesize($filename);
  return $size_info[1];
}
    /////////////////////////////////
function random_string($max_length = 20, $random_chars = "abcdefghijklmnopqrstuvwxyz0123456789"){
    for ($i = 0; $i < $max_length; $i++) {
        $random_key     = mt_rand(0, strlen($random_chars));
        $random_string .= substr($random_chars, $random_key, 1);
    }
    return strtolower(str_shuffle($random_string));
}
    /////////////////////////////////
function random_number($max_length = 20, $random_chars = "0123456789"){
    for ($i = 0; $i < $max_length; $i++) {
        $random_key     = mt_rand(0, strlen($random_chars));
        $random_string .= substr($random_chars, $random_key, 1);
    }
    return strtolower(str_shuffle($random_string));
}
    /////////////////////////////////
function smile($str) {
    $chars = array(
        '<img src="/images/smile/default/0.gif">'=>array(':)'),
        '<img src="/images/smile/default/15.gif">'=>array(':('),
        '<img src="/images/smile/default/12.gif">'=>array(':p',':P'),
        '<img src="/images/smile/default/66.gif">'=>array('<3','&lt;3'),
        '<img src="/images/smile/default/79.gif">'=>array('(y)'),
        '<img src="/images/smile/default/9.gif">'=>array(':’('),
        '<img src="/images/smile/default/21.gif">'=>array(':3'),
        '<img src="/images/smile/default/37.gif">'=>array('3:)','3:-)'),
        '<img src="/images/smile/default/15.gif">'=>array(':-(',':(',':[','=('),
        '<img src="/images/smile/default/22.gif">'=>array(':-O',':O',':-o',':o'),
        '<img src="/images/smile/default/16.gif">'=>array('8-)','8)','B-)','B)'),
        '<img src="/images/smile/default/13.gif">'=>array(':-D',':D','=D'),
        '<img src="/images/smile/default/19.gif">'=>array('>:(','>:-('),
        '<img src="/images/smile/default/6.gif">'=>array('^_^'),
        '<img src="/images/smile/default/65.gif">'=>array(':-*',':*'),
        '<img src="/images/smile/default/28.gif">'=>array(':v'),
    );
    foreach ($chars as $key => $arr) 
        foreach ($arr as $val)
            $str = str_replace($val,$key,$str);
        return $str;
    }
    function check_length($str){
        if(strpos($str, ' ')!==false){
            $tach_str=explode(' ', $str);
            foreach ($tach_str as $key => $value) {
                if($key==0){
                    if(strlen($value)<3){
                        $moi.='_'.$value.'_';
                    }else{
                        $moi.=' '.$value;
                    }
                }else{
                    if(strlen($value)<3){
                        $moi.=' _'.$value.'_';
                    }else{
                        $moi.=' '.$value;
                    }
                }
            }
            return $moi;
        }else{
            if(strlen($str)<3){
                $moi='_'.$str.'_';
                return $moi;
            }else{
                return $str;
            }
        }

    }
    /////////////////////////////////
    function url_en($str) {
        $chars = array(
            'a'=>array('A','a'),
            'as'=>array('Á','á'),
            'af'=>array('À','à'),
            'ar'=>array('Ả','ả'),
            'ax'=>array('Ã','ã'),
            'aj'=>array('Ạ','ạ'),
            'aa'=>array('Â','â'),
            'aas'=>array('Ấ','ấ'),
            'aaf'=>array('Ầ','ầ'),
            'aaj'=>array('Ậ','ậ'),
            'aar'=>array('Ẩ','ẩ'),
            'aax'=>array('Ẫ','ẫ'),
            'aw'=>array('Ă','ă'),
            'aws'=>array('Ắ','ắ'),
            'awf'=>array('Ằ','ằ'),
            'awr'=>array('Ẳ','ẳ'),
            'awx'=>array('Ẵ','ẵ'),
            'awj'=>array('Ặ','ặ'),
            'b'=>array('B','b'),
            'c'=>array('C','c'),
            'd'=>array('D','d'),
            'dd'=>array('Đ','đ'),
            'e'=>array('E','e'),
            'es'=>array('É','é'),
            'ef'=>array('È','è'),
            'ej'=>array('Ẹ','ẹ'),
            'ex'=>array('Ẽ','ẽ'),
            'er'=>array('Ẻ','ẻ'),
            'ee'=>array('Ê','ê'),
            'ees'=>array('Ế','ế'),
            'eef'=>array('Ề','ề'),
            'eer'=>array('Ể','ể'),
            'eex'=>array('Ễ','ế'),
            'eej'=>array('Ệ','ệ'),
            'f'=>array('F','f'),
            'g'=>array('G','g'),
            'i'=>array('I','i'),
            'is'=>array('Í','í'),
            'if'=>array('Ì','ì'),
            'ir'=>array('Ỉ','ỉ'),
            'ix'=>array('Ĩ','ĩ'),
            'ij'=>array('Ị','ị'),
            'y'=>array('Y','y'),
            'ys'=>array('Ý','ý'),
            'yf'=>array('Ỳ','ỳ'),
            'yr'=>array('Ỷ','ỷ'),
            'yx'=>array('Ỹ','ỹ'),
            'yj'=>array('Ỵ','ỵ'),
            'h'=>array('H','h'),
            'j'=>array('J','j'),
            'k'=>array('K','k'),
            'l'=>array('L','l'),
            'm'=>array('M','m'),
            'n'=>array('N','n'),
            'o'=>array('O','o'),
            'os'=>array('Ó','ó'),
            'of'=>array('Ò','ò'),
            'or'=>array('Ỏ','ỏ'),
            'ox'=>array('Õ','õ'),
            'oj'=>array('Ọ','ọ'),
            'oo'=>array('Ô','ô'),
            'oos'=>array('Ố','ố'),
            'oof'=>array('Ồ','ồ'),
            'oor'=>array('Ổ','ổ'),
            'oox'=>array('Ỗ','ỗ'),
            'ooj'=>array('Ộ','ộ'),
            'ow'=>array('Ơ','ơ'),
            'ows'=>array('Ớ','ớ'),
            'owf'=>array('Ờ','ờ'),
            'owr'=>array('Ở','ở'),
            'owx'=>array('Ỡ','ỡ'),
            'owj'=>array('Ợ','ợ'),
            'p'=>array('P','p'),
            'q'=>array('Q','q'),
            'r'=>array('R','r'),
            's'=>array('S','s'),
            't'=>array('T','t'),
            'u'=>array('U','u'),
            'us'=>array('Ú','ú'),
            'uf'=>array('Ù','ù'),
            'ur'=>array('Ủ','ủ'),
            'ux'=>array('Ũ','ũ'),
            'uj'=>array('Ụ','ụ'),
            'uw'=>array('Ư','ư'),
            'uws'=>array('Ứ','ứ'),
            'uwf'=>array('Ừ','ừ'),
            'uwr'=>array('Ử','ử'),
            'uwx'=>array('Ữ','ữ'),
            'uwj'=>array('Ự','ự'),
            'v'=>array('V','v'),
            'x'=>array('X','x'),
            'z'=>array('Z','z'),
            'w'=>array('W','w'),
            '-'    =>    array('_',' ','?',':','"',')','<','>','.',',','(','}','-','{','`',',','--',':','%',']','/','[','|',"'"),
        );
        foreach ($chars as $key => $arr) 
            foreach ($arr as $val)
                $str = str_replace($val,$key,$str);
            return $str;
        }
    /////////////////////////////////
    function tieude_en($str) {
        $chars = array(
            'a'=>array('A','a'),
            'as'=>array('Á','á'),
            'af'=>array('À','à'),
            'ar'=>array('Ả','ả'),
            'ax'=>array('Ã','ã'),
            'aj'=>array('Ạ','ạ'),
            'aa'=>array('Â','â'),
            'aas'=>array('Ấ','ấ'),
            'aaf'=>array('Ầ','ầ'),
            'aaj'=>array('Ậ','ậ'),
            'aar'=>array('Ẩ','ẩ'),
            'aax'=>array('Ẫ','ẫ'),
            'aw'=>array('Ă','ă'),
            'aws'=>array('Ắ','ắ'),
            'awf'=>array('Ằ','ằ'),
            'awr'=>array('Ẳ','ẳ'),
            'awx'=>array('Ẵ','ẵ'),
            'awj'=>array('Ặ','ặ'),
            'b'=>array('B','b'),
            'c'=>array('C','c'),
            'd'=>array('D','d'),
            'dd'=>array('Đ','đ'),
            'e'=>array('E','e'),
            'es'=>array('É','é'),
            'ef'=>array('È','è'),
            'ej'=>array('Ẹ','ẹ'),
            'ex'=>array('Ẽ','ẽ'),
            'er'=>array('Ẻ','ẻ'),
            'ee'=>array('Ê','ê'),
            'ees'=>array('Ế','ế'),
            'eef'=>array('Ề','ề'),
            'eer'=>array('Ể','ể'),
            'eex'=>array('Ễ','ế'),
            'eej'=>array('Ệ','ệ'),
            'f'=>array('F','f'),
            'g'=>array('G','g'),
            'i'=>array('I','i'),
            'is'=>array('Í','í'),
            'if'=>array('Ì','ì'),
            'ir'=>array('Ỉ','ỉ'),
            'ix'=>array('Ĩ','ĩ'),
            'ij'=>array('Ị','ị'),
            'y'=>array('Y','y'),
            'ys'=>array('Ý','ý'),
            'yf'=>array('Ỳ','ỳ'),
            'yr'=>array('Ỷ','ỷ'),
            'yx'=>array('Ỹ','ỹ'),
            'yj'=>array('Ỵ','ỵ'),
            'h'=>array('H','h'),
            'j'=>array('J','j'),
            'k'=>array('K','k'),
            'l'=>array('L','l'),
            'm'=>array('M','m'),
            'n'=>array('N','n'),
            'o'=>array('O','o'),
            'os'=>array('Ó','ó'),
            'of'=>array('Ò','ò'),
            'or'=>array('Ỏ','ỏ'),
            'ox'=>array('Õ','õ'),
            'oj'=>array('Ọ','ọ'),
            'oo'=>array('Ô','ô'),
            'oos'=>array('Ố','ố'),
            'oof'=>array('Ồ','ồ'),
            'oor'=>array('Ổ','ổ'),
            'oox'=>array('Ỗ','ỗ'),
            'ooj'=>array('Ộ','ộ'),
            'ow'=>array('Ơ','ơ'),
            'ows'=>array('Ớ','ớ'),
            'owf'=>array('Ờ','ờ'),
            'owr'=>array('Ở','ở'),
            'owx'=>array('Ỡ','ỡ'),
            'owj'=>array('Ợ','ợ'),
            'p'=>array('P','p'),
            'q'=>array('Q','q'),
            'r'=>array('R','r'),
            's'=>array('S','s'),
            't'=>array('T','t'),
            'u'=>array('U','u'),
            'us'=>array('Ú','ú'),
            'uf'=>array('Ù','ù'),
            'ur'=>array('Ủ','ủ'),
            'ux'=>array('Ũ','ũ'),
            'uj'=>array('Ụ','ụ'),
            'uw'=>array('Ư','ư'),
            'uws'=>array('Ứ','ứ'),
            'uwf'=>array('Ừ','ừ'),
            'uwr'=>array('Ử','ử'),
            'uwx'=>array('Ữ','ữ'),
            'uwj'=>array('Ự','ự'),
            'v'=>array('V','v'),
            'x'=>array('X','x'),
            'z'=>array('Z','z'),
            'w'=>array('W','w'),
            ' '    =>    array('_',' ','?',':','"',')','<','>','.',',','(','}','-','{','`',',','--',':','%',']','/','[','|',"'"),
        );
        foreach ($chars as $key => $arr) 
            foreach ($arr as $val)
                $str = str_replace($val,$key,$str);
            return $str;
        }
    /////////////////////////////////
    function tieude_thuong($str) {
        $chars = array(
            'a'=>array('A'),
            'á'=>array('Á'),
            'à'=>array('À'),
            'ả'=>array('Ả'),
            'ã'=>array('Ã'),
            'ạ'=>array('Ạ'),
            'â'=>array('Â'),
            'ấ'=>array('Ấ'),
            'ầ'=>array('Ầ'),
            'ậ'=>array('Ậ'),
            'ẩ'=>array('Ẩ'),
            'ẫ'=>array('Ẫ'),
            'ă'=>array('Ă'),
            'ắ'=>array('Ắ'),
            'ằ'=>array('Ằ'),
            'ẳ'=>array('Ẳ'),
            'ẵ'=>array('Ẵ'),
            'ặ'=>array('Ặ'),
            'b'=>array('B'),
            'c'=>array('C'),
            'd'=>array('D'),
            'đ'=>array('Đ'),
            'e'=>array('E'),
            'é'=>array('É'),
            'è'=>array('È'),
            'ẹ'=>array('Ẹ'),
            'ẽ'=>array('Ẽ'),
            'ẻ'=>array('Ẻ'),
            'ê'=>array('Ê'),
            'ế'=>array('Ế'),
            'ề'=>array('Ề'),
            'ể'=>array('Ể'),
            'ễ'=>array('Ễ'),
            'ệ'=>array('Ệ'),
            'f'=>array('F'),
            'g'=>array('G'),
            'i'=>array('I'),
            'í'=>array('Í'),
            'ì'=>array('Ì'),
            'ỉ'=>array('Ỉ'),
            'ĩ'=>array('Ĩ'),
            'ị'=>array('Ị'),
            'y'=>array('Y'),
            'ý'=>array('Ý'),
            'Ỳ'=>array('Ỳ'),
            'ỷ'=>array('Ỷ'),
            'ỹ'=>array('Ỹ'),
            'ỵ'=>array('Ỵ'),
            'h'=>array('H'),
            'j'=>array('J'),
            'k'=>array('K'),
            'l'=>array('L'),
            'm'=>array('M'),
            'n'=>array('N'),
            'o'=>array('O'),
            'ó'=>array('Ó'),
            'ò'=>array('Ò'),
            'ỏ'=>array('Ỏ'),
            'õ'=>array('Õ'),
            'ọ'=>array('Ọ'),
            'ô'=>array('Ô'),
            'ố'=>array('Ố'),
            'ồ'=>array('Ồ'),
            'ổ'=>array('Ổ'),
            'ỗ'=>array('Ỗ'),
            'ộ'=>array('Ộ'),
            'ơ'=>array('Ơ'),
            'ớ'=>array('Ớ'),
            'ờ'=>array('Ờ'),
            'ở'=>array('Ở'),
            'ỡ'=>array('Ỡ'),
            'ợ'=>array('Ợ'),
            'p'=>array('P'),
            'q'=>array('Q'),
            'r'=>array('R'),
            's'=>array('S'),
            't'=>array('T'),
            'u'=>array('U'),
            'ú'=>array('Ú'),
            'ù'=>array('Ù'),
            'ủ'=>array('Ủ'),
            'ũ'=>array('Ũ'),
            'ụ'=>array('Ụ'),
            'ư'=>array('Ư'),
            'ứ'=>array('Ứ'),
            'ừ'=>array('Ừ'),
            'ử'=>array('Ử'),
            'ữ'=>array('Ữ'),
            'ự'=>array('Ự'),
            'v'=>array('V'),
            'x'=>array('X'),
            'z'=>array('Z'),
            'w'=>array('W'),
            //' '    =>    array('_',' ','?',':','"',')','<','>','.',',','(','}','-','{','`',',','--',':','%',']','/','[','|',"'"),
        );
        foreach ($chars as $key => $arr) 
            foreach ($arr as $val)
                $str = str_replace($val,$key,$str);
            return $str;
        }
    /////////////////////////////////
        function blank($str) {
            $str=str_replace('-', '', $str);
            $str=$this->link_chuan($str);
            $str=preg_replace('/([^\pL\.\0-9 ]+)/u', '', strip_tags($str));
            $chars = array(
                'a'    =>    array('ấ','ầ','ẩ','ẫ','ậ','Ấ','Ầ','Ẩ','Ẫ','Ậ','ắ','ằ','ẳ','ẵ','ặ','Ắ','Ằ','Ẳ','Ẵ','Ặ','á','à','ả','ã','ạ','â','ă','Á','À','Ả','Ã','Ạ','Â','Ă','A'),
                'e'    =>    array('ế','ề','ể','ễ','ệ','Ế','Ề','Ể','Ễ','Ệ','é','è','ẻ','ẽ','ẹ','ê','É','È','Ẻ','Ẽ','Ẹ','Ê','E'),
                'i'    =>    array('í','ì','ỉ','ĩ','ị','Í','Ì','Ỉ','Ĩ','Ị','I'),
                'o'    =>    array('ố','ồ','ổ','ỗ','ộ','Ố','Ồ','Ổ','Ô','Ộ','ớ','ờ','ở','ỡ','ợ','Ớ','Ở','Ỡ','Ợ','ó','ò','ỏ','õ','ọ','ô','ơ','Ó','Ò','Ỏ','Õ','Ọ','Ô','Ơ','O','Ờ'),
                'u'    =>    array('ứ','ừ','ử','ữ','ự','Ứ','Ừ','Ử','Ữ','Ự','ú','ù','ủ','ũ','ụ','ư','Ú','Ù','Ủ','Ũ','Ụ','Ư','U'),
                'y'    =>    array('ý','ỳ','ỷ','ỹ','ỵ','Ý','Ỳ','Ỷ','Ỹ','Ỵ','Y'),
                'b'    =>    array('b','B'),
                'c'    =>    array('c','C'),
                'f'    =>    array('f','F'),
                'g'    =>    array('g','G'),
                'h'    =>    array('h','H'),
                'j'    =>    array('j','J'),
                'k'    =>    array('k','K'),
                'l'    =>    array('l','L'),
                'm'    =>    array('m','M'),
                'n'    =>    array('n','N'),
                'p'    =>    array('p','P'),
                'q'    =>    array('q','Q'),
                'r'    =>    array('r','R'),
                's'    =>    array('s','S'),
                't'    =>    array('t','T'),
                'v'    =>    array('v','V'),
                'x'    =>    array('x','X'),
                'z'    =>    array('z','Z'),
                'd'    =>    array('đ','Đ','D'),
                '-'    =>    array('_',' ','?',':','"',')','<','>','#',';','&','*','^','@','$','!','.',',','(','}','+','-','{','`',',','--',':','%',']','/','[','|',"'","\n"),
            );
            foreach ($chars as $key => $arr) 
                foreach ($arr as $val)
                    $str = str_replace($val,$key,$str);
                return $str;
            }
    /////////////////////////////////
            function text($string) {
                $string = str_replace ( '&amp;', '&', $string );
                $string = str_replace ( "'", "'", $string );
                $string = str_replace ( '&quot;', '"', $string );
                $string = str_replace ( '&lt;', '<', $string );
                $string = str_replace ( '&gt;', '>', $string );
                $string = str_replace ( '\"', '/"', $string );
                return $string;
            }
    /////////////////////////////////
            function money($string) {
                $string = str_replace ( ' ', '', $string );
                $string = str_replace ( '.', '', $string );
                $string = str_replace ( ',', '', $string );
                return $string;
            }
    /////////////////////////////////
            function words($str,$num)
            {
                $limit = $num - 1 ;
                $str_tmp = '';
                $str = str_replace(']]>', ']]&gt;', $str);
                $str = strip_tags($str);
                $arrstr = explode(" ", $str);
                if ( count($arrstr) <= $num ) { return $str; }
                if (!empty($arrstr))
                {
                    for ( $j=0; $j< count($arrstr) ; $j++)    
                    {
                        $str_tmp .= " " . $arrstr[$j];
                        if ($j == $limit) 
                        {
                            break;
                        }
                    }
                }
                return $str_tmp."...";
            }
    /////////////////////////////////
            function words_2($str,$num)
            {
                $limit = $num - 1 ;
                $str_tmp = '';
                $str = str_replace(']]>', ']]&gt;', $str);
                $str = strip_tags($str,'<br>');
                $arrstr = explode(" ", $str);
                if ( count($arrstr) <= $num ) { return $str; }
                if (!empty($arrstr))
                {
                    for ( $j=0; $j< count($arrstr) ; $j++)    
                    {
                        $str_tmp .= " " . $arrstr[$j];
                        if ($j == $limit) 
                        {
                            break;
                        }
                    }
                }
                return $str_tmp."...";
            }
    /////////////////////////////////
            function limit_words($str,$num)
            {
                $limit = $num - 1 ;
                $str_tmp = '';
                $str = str_replace(']]>', ']]&gt;', $str);
                $str = strip_tags($str);
                $arrstr = explode(" ", $str);
                if ( count($arrstr) <= $num ) { 
                    return true; 
                }else{
                    return false;
                }
            }
    /////////////////////////////////
            function text_setting($content,$value) {
                preg_match('/"'.$value.'":"(.*?)"/is', $content,$tim_value); 
                return $tim_value[1];
            }
    /////////////////////////////////
            function replace_setting($content,$name,$value) {
                $content=preg_replace('/"'.$name.'":"(.*?)"/is','"'.$name.'":"'.$value.'"',$content); 
                return $content;
            }
    /////////////////////////////////
            function mobile_detect(){
                $useragent=$_SERVER['HTTP_USER_AGENT'];
                if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
                    return TRUE;
                }else{
                    return FALSE;
                }
            }
    /////////////////////////////////
            function tach_photo($content,$i){
                $p=0;
                $patt='/<img[^>]* src\="([^"]+)"[^>]*>/i';
                if(preg_match_all($patt,$content,$ms)){
                    $rt='';
                    foreach($ms[1] as &$link){
                        $p=$p+1;
                        if($i=="0"){
                            $rt.=$link.',';  
                        }else{
                            if($p<$i){
                                $rt.=$link.',';
                            }else{
                                $rt.='';
                            }
                        }
                    }
                    return $rt;
                }
                return '';
            }
    //////////////////////////////////////////////////////////////////
            function thay_photo($noi_dung,$ten)
            {
                $i=0;
                $patt='/<img[^>]* src\="([^"]+)"[^>]*>/i';
                if(preg_match_all($patt,$noi_dung,$ms)){
                    foreach($ms[1] as $link){
                        $duoi=$this->duoi_file($link);
                        $moi=$ten.'-'.$i.'.'.$duoi;
                        $i++;
                        @unlink(substr($link,3));
                        $noi_dung=str_replace($link, $moi, $noi_dung);
                    }
                }
                return $noi_dung;
            }
    ////////////////////////////////////////////////////////
            function link_sosanhgia($x){
                preg_match('/__jwt = "(.*?)"/is', $x,$tach_ma);
                $ma=$tach_ma[1];
                $tach_code=explode('.', $ma);
                $decode=base64_decode(str_replace('-', '+', str_replace('_', '/', $tach_code[1].'===')));
                $tach_data=json_decode($decode,true);
                $link_dich=$tach_data['data']['merchant_url'];
                if(strpos($link_dich, 'url=')!==false){
                    $tach_dich=explode('url=', $link_dich);
                    $link_goc=explode('&', $tach_dich[1]);
                    if(strpos($link_goc, 'tiki')!==false){
                        $tach_abc=explode('.html', $link_goc[0]);
                        $u=urldecode($tach_abc[0]).'.html';
                    }else{
                        $u=urldecode($link_goc[0]);
                    }   
                }else if(strpos($link_dich, 'destination:')!==false){
                    $tach_dich=explode('destination:', $link_dich);
                    $u=urldecode($tach_dich[1]);
                }else{
                    if(strpos($link_dich, 'tiki')!==false){
                        $tach_abc=explode('.html', $link_dich);
                        $u=urldecode($tach_abc[0]).'.html';

                    }else{
                        $u=urldecode($link_dich);
                    }
                }
                if(strpos($u, 'masoffer.net')!==false){
                    $tach_go=explode('go=', $u);
                    if(strpos($tach_go[1], '?')!==false){
                        $tach_ask=explode('?', $tach_go[1]);
                        $a=$tach_ask[0];
                    }else if(strpos($tach_go[1], '&')!==false){
                        $tach_and=explode('&', $tach_go[1]);
                        $a=$tach_and[0];
                    }else{
                        $a=$tach_go[1];
                    }
                }else if(strpos($u, '?')!==false){
                    $tach_ask=explode('?', $u);
                    $a=$tach_ask[0];
                }else{
                    $a=$u;
                }
                return $a;
            }
    ////////////////////////////////////////////////////////
            function link_direct($url){
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64; rv:21.0) Gecko/20100101 Firefox/21.0"); 
                curl_exec($ch);
                $response = curl_exec($ch);
                preg_match_all('/^Location:(.*)$/mi', $response, $matches);
                curl_close($ch);
                $link=!empty($matches[1]) ? trim($matches[1][0]) : 'No redirect found';
                return $response;
            }
    ////////////////////////////////////////////////////////
            function link_direct2($url){
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64; rv:21.0) Gecko/20100101 Firefox/21.0"); 
                curl_exec($ch);
                $response = curl_exec($ch);
                preg_match_all('/^Location:(.*)$/mi', $response, $matches);
                curl_close($ch);
                $link=!empty($matches[1]) ? trim($matches[1][0]) : 'No redirect found';
                return $link;
            }
    ///////////////////////////////
            function copy_img($name,$url){
                $content = $this->getpage($url,$url);
            //Store in the filesystem.
                $fp = fopen($name, "w");
                fwrite($fp, $content);
                fclose($fp);
                //$this->load_img($name);
                //$this->save_img($name); 
            }
    ///////////////////////////////
            function copy_img_resize($name,$url,$width,$height){
                $content = $this->getpage($url,$url);
            //Store in the filesystem.
                $fp = fopen($name, "w");
                fwrite($fp, $content);
                fclose($fp);
                if($height==0 OR $width==0){
                    $this->load_img($name);
                    $this->resize_img(200,200);
                }else{
                    $this->load_img($name);
                    $this->resize_img($width,$height);
                }
                $this->save_img($name); 
            }
    ////////////////////////////////
            function closetags($html) {
                preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
                $openedtags = $result[1];
                preg_match_all('#</([a-z]+)>#iU', $html, $result);

                $closedtags = $result[1];
                $len_opened = count($openedtags);

                if (count($closedtags) == $len_opened) {
                    return $html;
                }
                $openedtags = array_reverse($openedtags);
                for ($i=0; $i < $len_opened; $i++) {
                    if (!in_array($openedtags[$i], $closedtags)) {
                        $html .= '</'.$openedtags[$i].'>';
                    } else {
                        unset($closedtags[array_search($openedtags[$i], $closedtags)]);
                    }
                }
                return $html;
            }
    ////////////////////////////////
            function check_proxy_live($proxy){
                $wait=10;
                $tach_proxy=explode(':', $proxy);
                $ip=$tach_proxy[0];
                $port=$tach_proxy[1];
                if($fp=@fsockopen($ip,$port,$errCode,$errStr,$wait)){
                    $ketqua=true;
                    fclose($fp);
                }else{
                    $ketqua=false;
                }
                return $ketqua;
            }
    ////////////////////////////////
            function curl($url,$reffer=null,$proxy=null,$proxy_type=null,$timeout=null){
                $ch = @curl_init();
                $head[] = "Connection: keep-alive";
                $head[] = "Keep-Alive: 300";
                $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
                $head[] = "Accept-Language: en-us,en;q=0.5";
                $agent='Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36';
                if(!isset($timeout)){
                    $timeout=30;
                }
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_USERAGENT, $agent);
                curl_setopt($ch, CURLOPT_ENCODING, '');
                curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
                if(isset($reffer)){
                    curl_setopt($ch, CURLOPT_REFERER, $reffer);
                }else{
                    curl_setopt($ch, CURLOPT_REFERER, 'https://www.google.com.vn/');
                }
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Expect:'
                ));
                if(isset($proxy)){
                    $ketqua=$this->check_proxy_live($proxy);
                    if($ketqua==true){
                        curl_setopt($ch, CURLOPT_PROXY, $proxy);
                        if(isset($proxy_type)){
                            curl_setopt($ch, CURLOPT_PROXYTYPE, $proxy_type);
                        }
                    }
                }
                $page = curl_exec($ch);
                curl_close($ch);
                return $page;
            }
    ////////////////////////////////
            function curl_cookie($url,$reffer=null,$proxy=null,$proxy_type=null,$timeout=null){
                $ch = @curl_init();
                $head[] = "Connection: keep-alive";
                $head[] = "Keep-Alive: 300";
                $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
                $head[] = "Accept-Language: en-us,en;q=0.5";
                $agent='Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36';
                $cookie='cookie.txt';
                if(!isset($timeout)){
                    $timeout=30;
                }
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_USERAGENT, $agent);
                curl_setopt($ch, CURLOPT_ENCODING, '');
                curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
                if(isset($reffer)){
                    curl_setopt($ch, CURLOPT_REFERER, $reffer);
                }else{
                    curl_setopt($ch, CURLOPT_REFERER, 'https://www.google.com.vn/');
                }
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                curl_setopt($ch, CURLOPT_COOKIEFILE, realpath($cookie));
                //curl_setopt($ch, CURLOPT_COOKIEJAR, realpath($cookie));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Expect:'
                ));
                if(isset($proxy)){
                    $ketqua=$this->check_proxy_live($proxy);
                    if($ketqua==true){
                        curl_setopt($ch, CURLOPT_PROXY, $proxy);
                        if(isset($proxy_type)){
                            curl_setopt($ch, CURLOPT_PROXYTYPE, $proxy_type);
                        }
                    }
                }
                $page = curl_exec($ch);
                curl_close($ch);
                return $page;
            }
    ////////////////////////////////
            function getpage_mobile($link,$reffer=null,$proxy=null,$proxy_type=null,$timeout=null){
            //$ip='45.32.58.139';
                $agent = 'Mozilla/5.0 (Linux; U; Android 4.0.3; ko-kr; LG-L160L Build/IML74K) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30';
                $cookie = 'cookie.txt';
                $ch = curl_init();
                $head[] = "Connection: keep-alive";
                $head[] = "Keep-Alive: 300";
                $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
                $head[] = "Accept-Language: en-us,en;q=0.5";
                if(!isset($timeout)){
                    $timeout=30;
                }
                curl_setopt($ch, CURLOPT_URL, $link);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
                curl_setopt($ch, CURLOPT_USERAGENT, $agent);
                if(isset($reffer)){
                    curl_setopt($ch, CURLOPT_REFERER, $reffer);
                }else{
                    curl_setopt($ch, CURLOPT_REFERER, 'https://www.google.com/');
                }
                curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
                //curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                if(isset($proxy)){
                    $ketqua=$this->check_proxy_live($proxy);
                    if($ketqua==true){
                        curl_setopt($ch, CURLOPT_PROXY, $proxy);
                        if(isset($proxy_type)){
                            curl_setopt($ch, CURLOPT_PROXYTYPE, $proxy_type);
                        }
                    }
                }
                $content = curl_exec($ch);
                curl_close($ch);
                return $content;
            }
    ////////////////////////////////
            function getpage($link,$reffer=null,$proxy=null,$proxy_type=null,$timeout=null){
            //$ip='45.32.58.139';
                $agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';
                $cookie = 'cookie.txt';
                $ch = curl_init();
                $head[] = "Connection: keep-alive";
                $head[] = "Keep-Alive: 300";
                $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
                $head[] = "Accept-Language: en-us,en;q=0.5";
                if(!isset($timeout)){
                    $timeout=30;
                }
                curl_setopt($ch, CURLOPT_URL, $link);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
                curl_setopt($ch, CURLOPT_USERAGENT, $agent);
                if(isset($reffer)){
                    curl_setopt($ch, CURLOPT_REFERER, $reffer);
                }else{
                    curl_setopt($ch, CURLOPT_REFERER, 'https://www.google.com/');
                }
                curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
                //curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                if(isset($proxy)){
                    $ketqua=$this->check_proxy_live($proxy);
                    if($ketqua==true){
                        curl_setopt($ch, CURLOPT_PROXY, $proxy);
                        if(isset($proxy_type)){
                            curl_setopt($ch, CURLOPT_PROXYTYPE, $proxy_type);
                        }
                    }
                }
                $content = curl_exec($ch);
                curl_close($ch);
                return $content;
            }
    /////////////////////
            function postcurl($url,$pvars,$referer=null,$timeout=null){
                $agent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3';
                $cookie = 'cookie.txt';
                if(!isset($timeout)){
                    $timeout=30;
                }
                $curl = curl_init();
                $post = http_build_query($pvars);
                if(isset($referer)){
                    curl_setopt ($curl, CURLOPT_REFERER, $referer);
                }
                curl_setopt ($curl, CURLOPT_URL, $url);
                curl_setopt ($curl, CURLOPT_TIMEOUT, $timeout);
                curl_setopt ($curl, CURLOPT_USERAGENT, $agent);
                //curl_setopt ($curl, CURLOPT_COOKIEFILE, realpath($cookie));
                curl_setopt ($curl, CURLOPT_COOKIEJAR, realpath($cookie));
                curl_setopt ($curl, CURLOPT_HEADER, 0);
                curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt ($curl, CURLOPT_POST, 1);
                curl_setopt ($curl, CURLOPT_POSTFIELDS, $post);
                curl_setopt ($curl, CURLOPT_HTTPHEADER,array("Content-type: application/x-www-form-urlencoded"));
                $html = curl_exec ($curl);
                curl_close ($curl);
                return $html;
            }
    /////////////////////////////////
            function sendphp($name,$from,$subject,$content,$to,$reply){
           // $name = 'Trần Hải';
           // $email  = 'thongbao@vibaza.com';
           // $subject= 'Thư liên hệ gửi từ website';
           // $content= 'Xin chào, <br> Chúng tôi cần liên hệ với bạn';
            // khai báo địa chỉ nhận thư. Nếu muốn gửi cùng lúc tới nhiều người thì dùng dấu phảy phân cách các địa chỉ email
            //$to  = 'xahoigiaitri@gmail.com,vui3x.com@gmail.com,vibaza.com@gmail.com';  
            // Khai báo header dùng mã utf-8 để hiển thị tiếng việt 
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $headers .= 'From: =?UTF-8?B?'.base64_encode($name).'?= <'.$from.'>' . "\r\n";
                $headers .= 'Reply-to:'.$reply;
            //khai báo nội dung thư theo chuẩn HTML
                $message  = '<html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                </head>
                <body>
                '.$content.'
                </body>
                </html>';
            // Gửi thư bằng hàm mail của PHP với điều kiện server có hỗ trợ hàm này và có sẵn dịch vụ mail smtp cổng 25
                if(mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $headers)){
                    return 'ok';
                } else{
                    return 'false';
                }
            }
    ///////////////////////
            function file_size($url){
                $my_ch = curl_init();
                curl_setopt($my_ch, CURLOPT_URL, $url);
                curl_setopt($my_ch, CURLOPT_HEADER, true);
                curl_setopt($my_ch, CURLOPT_NOBODY, true);
                curl_setopt($my_ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($my_ch, CURLOPT_TIMEOUT, 10);
                $r = curl_exec($my_ch);
                foreach (explode("\n", $r) as $header) {
                    if (strpos($header, 'Content-Length:') === 0) {
                        return trim(substr($header, 16));
                    }
                }
                return 'false';
            }
            function getHeight($image) {
                $size = getimagesize($image);
                $height = $size[1];
                return $height;
            }
        //You do not need to alter these functions
            function getWidth($image) {
                $size = getimagesize($image);
                $width = $size[0];
                return $width;
            }
            function resizeImage($image,$width,$height,$scale) {
                list($imagewidth, $imageheight, $imageType) = getimagesize($image);
                $imageType = image_type_to_mime_type($imageType);
                $newImageWidth = ceil($width * $scale);
                $newImageHeight = ceil($height * $scale);
                $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
                switch($imageType) {
                    case "image/gif":
                    $source=imagecreatefromgif($image); 
                    break;
                    case "image/pjpeg":
                    case "image/jpeg":
                    case "image/jpg":
                    $source=imagecreatefromjpeg($image); 
                    break;
                    case "image/png":
                    case "image/x-png":
                    $source=imagecreatefrompng($image); 
                    break;
                }
                imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
                switch($imageType) {
                    case "image/gif":
                    imagegif($newImage,$image); 
                    break;
                    case "image/pjpeg":
                    case "image/jpeg":
                    case "image/jpg":
                    imagejpeg($newImage,$image,90); 
                    break;
                    case "image/png":
                    case "image/x-png":
                    imagepng($newImage,$image);  
                    break;
                }
                chmod($image, 0777);
                return $image;
            }
        //You do not need to alter these functions
            function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
                list($imagewidth, $imageheight, $imageType) = getimagesize($image);
                $imageType = image_type_to_mime_type($imageType);
                $newImageWidth = ceil($width * $scale);
                $newImageHeight = ceil($height * $scale);
                $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
                switch($imageType) {
                    case "image/gif":
                    $source=imagecreatefromgif($image); 
                    break;
                    case "image/pjpeg":
                    case "image/jpeg":
                    case "image/jpg":
                    $source=imagecreatefromjpeg($image); 
                    break;
                    case "image/png":
                    case "image/x-png":
                    $source=imagecreatefrompng($image); 
                    break;
                }
                imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
                switch($imageType) {
                    case "image/gif":
                    imagegif($newImage,$thumb_image_name); 
                    break;
                    case "image/pjpeg":
                    case "image/jpeg":
                    case "image/jpg":
                    imagejpeg($newImage,$thumb_image_name,90); 
                    break;
                    case "image/png":
                    case "image/x-png":
                    imagepng($newImage,$thumb_image_name);  
                    break;
                }
                chmod($thumb_image_name, 0777);
                return $thumb_image_name;
            }
        }
        ?>
