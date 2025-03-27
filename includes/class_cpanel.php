 <?php
 class class_cpanel extends class_manage
 {
    ///////////////////
    function list_menu($conn,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $i=$start;
        $thongtin=mysqli_query($conn,"SELECT * FROM menu ORDER BY menu_vitri ASC,menu_main ASC, menu_thutu ASC LIMIT $start,$limit");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $r_tt['blank']=$check->blank($r_tt['post_tieude']);
            $i++;
            $r_tt['i']=$i;
            if($r_tt['menu_main']==0){
                $r_tt['menu_main']='Menu chính';
            }else{
                $thongtin_main=mysqli_query($conn,"SELECT * FROM menu WHERE menu_id='{$r_tt['menu_main']}'");
                $r_m=mysqli_fetch_assoc($thongtin_main);
                $r_tt['menu_main']=$r_m['menu_tieude'];
            }
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_menu',$r_tt);
        }
        return $list;
    }
    ////////////////////
    function list_category($conn,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $i=$start;
        $thongtin=mysqli_query($conn,"SELECT * FROM category ORDER BY cat_main ASC, cat_thutu ASC LIMIT $start,$limit");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $r_tt['blank']=$check->blank($r_tt['post_tieude']);
            $i++;
            $r_tt['i']=$i;
            if($r_tt['cat_icon']==''){
                $r_tt['cat_icon']='<span class="icon"><i class="icon icon-movie"></i></span>';
            }
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_category',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_tacgia($conn,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $i=$start;
        $thongtin=mysqli_query($conn,"SELECT * FROM tac_gia ORDER BY tacgia_name ASC LIMIT $start,$limit");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $r_tt['blank']=$check->blank($r_tt['post_tieude']);
            $i++;
            $r_tt['i']=$i;
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_tacgia',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_tap($conn,$phim,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $i=$start;
        $thongtin=mysqli_query($conn,"SELECT list_tap.*,phim.link FROM list_tap LEFT JOIN phim ON list_tap.phim=phim.id WHERE list_tap.phim='$phim' ORDER BY list_tap.thu_tu DESC LIMIT $start,$limit");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_tap',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_kq_timkiem_chap($conn,$truyen,$key){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $i=$start;
        $thongtin=mysqli_query($conn,"SELECT chap.*,truyen.link AS truyen_link FROM chap LEFT JOIN truyen ON chap.truyen=truyen.id WHERE chap.truyen='$truyen' AND chap.tieu_de LIKE '%$key%' ORDER BY chap.thu_tu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_chap',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_lich($conn,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $i=$start;
        $thongtin=mysqli_query($conn,"SELECT lich_chieu.*,phim.tieu_de,phim.minh_hoa FROM lich_chieu INNER JOIN phim ON lich_chieu.phim=phim.id ORDER BY id DESC LIMIT $start,$limit");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $tach_thu=explode(',', $r_tt['thu']);
            foreach ($tach_thu as $key => $value) {
                if($value=='8'){
                    $list_thu.='Chủ nhật, ';
                }else{
                    $list_thu.='Thứ '.$value.', ';
                }
            }
            $r_tt['thu']=substr($list_thu,0,-2);
            unset($list_thu);
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_lichchieu',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_timkiem($conn,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $i=$start;
        $thongtin=mysqli_query($conn,"SELECT * FROM timkiem ORDER BY id ASC LIMIT $start,$limit");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            if(strpos($r_tt['ip_address'], ',')!==false){
                $tach_ip=explode(',', $r_tt['ip_address']);
                $r_tt['total_ip']=count($tach_ip);
            }else{
                $r_tt['total_ip']=1;
            }
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_timkiem',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_option_category($conn,$id){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM category ORDER BY cat_thutu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $r_tt['blank']=$check->blank($r_tt['post_tieude']);
            $i++;
            if($r_tt['cat_id']==$id){
                $list.='<option value="'.$r_tt['cat_id'].'" selected>'.$r_tt['cat_tieude'].'</option>';
            }else{
                $list.='<option value="'.$r_tt['cat_id'].'">'.$r_tt['cat_tieude'].'</option>';
            }
        }
        return $list;
    }
    ///////////////////
    function list_option_category_kienthuc($conn,$id){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM category_kienthuc ORDER BY cat_thutu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            if($r_tt['cat_id']==$id){
                $list.='<option value="'.$r_tt['cat_id'].'" selected>'.$r_tt['cat_tieude'].'</option>';
            }else{
                $list.='<option value="'.$r_tt['cat_id'].'">'.$r_tt['cat_tieude'].'</option>';
            }
        }
        return $list;
    }
    ///////////////////
    function list_option_tacgia($conn,$id){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM tac_gia ORDER BY tacgia_name ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            if($r_tt['tacgia_id']==$id){
                $list.='<option value="'.$r_tt['tacgia_id'].'" selected>'.$r_tt['tacgia_name'].'</option>';
            }else{
                $list.='<option value="'.$r_tt['tacgia_id'].'">'.$r_tt['tacgia_name'].'</option>';
            }
        }
        return $list;
    }
    //////////////////////////////////////////////////////////////////
    function list_div_category($conn,$category){
        $tach_category=explode(',', $category);
        $thongtin=mysqli_query($conn,"SELECT * FROM category ORDER BY cat_thutu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            if(in_array($r_tt['cat_id'], $tach_category)==true){
                $list.='<div class="li_input" id="input_'.$r_tt['cat_id'].'"><input type="checkbox" name="category[]" value="'.$r_tt['cat_id'].'" checked> '.$r_tt['cat_tieude'].'</div>';
            }else{
                $list.='<div class="li_input" id="input_'.$r_tt['cat_id'].'"><input type="checkbox" name="category[]" value="'.$r_tt['cat_id'].'"> '.$r_tt['cat_tieude'].'</div>';
            }
        }
        return $list;
    }
    //////////////////////////////////////////////////////////////////
    function list_div_category_tintuc($conn,$category){
        $tach_category=explode(',', $category);
        $thongtin=mysqli_query($conn,"SELECT * FROM category_tintuc ORDER BY cat_thutu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            if(in_array($r_tt['cat_id'], $tach_category)==true){
                $list.='<div class="li_input" id="input_'.$r_tt['cat_id'].'"><input type="checkbox" name="category[]" value="'.$r_tt['cat_id'].'" checked> '.$r_tt['cat_tieude'].'</div>';
            }else{
                $list.='<div class="li_input" id="input_'.$r_tt['cat_id'].'"><input type="checkbox" name="category[]" value="'.$r_tt['cat_id'].'"> '.$r_tt['cat_tieude'].'</div>';
            }
        }
        return $list;
    }
    ///////////////////
    function list_option_main_menu($conn,$id){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM menu WHERE menu_main='0' AND menu_vitri='top' ORDER BY menu_thutu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $thongtin_sub=mysqli_query($conn,"SELECT * FROM menu WHERE menu_main='{$r_tt['menu_id']}' ORDER BY menu_thutu ASC");
            $total_sub=mysqli_num_rows($thongtin_sub);
            if($total_sub==0){
                $list_sub='';
            }else{
                while($r_s=mysqli_fetch_assoc($thongtin_sub)){
                    if($r_s['menu_id']==$id){
                        $list_sub.='<option value="'.$r_s['menu_id'].'" disabled selected>-- '.$r_s['menu_tieude'].'</option>';
                    }else{
                        $list_sub.='<option value="'.$r_s['menu_id'].'" disabled>-- '.$r_s['menu_tieude'].'</option>';
                    }
                }
            }
            $i++;
            if($r_tt['menu_id']==$id){
                $list.='<option value="'.$r_tt['menu_id'].'" selected>'.$r_tt['menu_tieude'].'</option>'.$list_sub;
            }else{
                $list.='<option value="'.$r_tt['menu_id'].'">'.$r_tt['menu_tieude'].'</option>'.$list_sub;
            }
            unset($list_sub);
        }
        return $list;
    }
    ///////////////////
    function list_option_tintuc($conn,$id){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM category_tintuc WHERE cat_main='0' ORDER BY cat_thutu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $thongtin_sub=mysqli_query($conn,"SELECT * FROM category_tintuc WHERE cat_main='{$r_tt['cat_id']}' ORDER BY cat_thutu ASC");
            $total_sub=mysqli_num_rows($thongtin_sub);
            if($total_sub==0){
                $list_sub='';
            }else{
                while($r_s=mysqli_fetch_assoc($thongtin_sub)){
                    $thongtin_sub_sub=mysqli_query($conn,"SELECT * FROM category_tintuc WHERE cat_main='{$r_s['cat_id']}' ORDER BY cat_thutu ASC");
                    $total_sub_sub=mysqli_num_rows($thongtin_sub_sub);
                    if($total_sub_sub==0){
                        $list_sub_sub='';
                    }else{
                        while($r_ss=mysqli_fetch_assoc($thongtin_sub_sub)){
                            if($r_ss['cat_id']==$id){
                                $list_sub_sub.='<option value="'.$r_ss['cat_id'].'" selected>---- '.$r_ss['cat_tieude'].'</option>';
                            }else{
                                $list_sub_sub.='<option value="'.$r_ss['cat_id'].'">---- '.$r_ss['cat_tieude'].'</option>';
                            }
                        }
                    }
                    if($r_s['cat_id']==$id){
                        $list_sub.='<option value="'.$r_s['cat_id'].'" selected>-- '.$r_s['cat_tieude'].'</option>'.$list_sub_sub;
                    }else{
                        $list_sub.='<option value="'.$r_s['cat_id'].'">-- '.$r_s['cat_tieude'].'</option>'.$list_sub_sub;
                    }
                    unset($list_sub_sub);
                }
            }
            $i++;
            if($r_tt['cat_id']==$id){
                $list.='<option value="'.$r_tt['cat_id'].'" selected>'.$r_tt['cat_tieude'].'</option>'.$list_sub;
            }else{
                $list.='<option value="'.$r_tt['cat_id'].'">'.$r_tt['cat_tieude'].'</option>'.$list_sub;
            }
            unset($list_sub);
        }
        return $list;
    }
    ///////////////////
    function list_option_sanpham($conn,$id){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM category_sanpham WHERE cat_main='0' ORDER BY cat_thutu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $thongtin_sub=mysqli_query($conn,"SELECT * FROM category_sanpham WHERE cat_main='{$r_tt['cat_id']}' ORDER BY cat_thutu ASC");
            $total_sub=mysqli_num_rows($thongtin_sub);
            if($total_sub==0){
                $list_sub='';
            }else{
                while($r_s=mysqli_fetch_assoc($thongtin_sub)){
                    $thongtin_sub_sub=mysqli_query($conn,"SELECT * FROM category_sanpham WHERE cat_main='{$r_s['cat_id']}' ORDER BY cat_thutu ASC");
                    $total_sub_sub=mysqli_num_rows($thongtin_sub_sub);
                    if($total_sub_sub==0){
                        $list_sub_sub='';
                    }else{
                        while($r_ss=mysqli_fetch_assoc($thongtin_sub_sub)){
                            if($r_ss['cat_id']==$id){
                                $list_sub_sub.='<option value="'.$r_ss['cat_id'].'" selected>---- '.$r_ss['cat_tieude'].'</option>';
                            }else{
                                $list_sub_sub.='<option value="'.$r_ss['cat_id'].'">---- '.$r_ss['cat_tieude'].'</option>';
                            }
                        }
                    }
                    if($r_s['cat_id']==$id){
                        $list_sub.='<option value="'.$r_s['cat_id'].'" selected>-- '.$r_s['cat_tieude'].'</option>'.$list_sub_sub;
                    }else{
                        $list_sub.='<option value="'.$r_s['cat_id'].'">-- '.$r_s['cat_tieude'].'</option>'.$list_sub_sub;
                    }
                    unset($list_sub_sub);
                }
            }
            $i++;
            if($r_tt['cat_id']==$id){
                $list.='<option value="'.$r_tt['cat_id'].'" selected>'.$r_tt['cat_tieude'].'</option>'.$list_sub;
            }else{
                $list.='<option value="'.$r_tt['cat_id'].'">'.$r_tt['cat_tieude'].'</option>'.$list_sub;
            }
            unset($list_sub);
        }
        return $list;
    } 
    ///////////////////
    function list_option_main($conn,$id){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM category WHERE cat_main='0' ORDER BY cat_thutu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $thongtin_sub=mysqli_query($conn,"SELECT * FROM category WHERE cat_main='{$r_tt['cat_id']}' ORDER BY cat_thutu ASC");
            $total_sub=mysqli_num_rows($thongtin_sub);
            if($total_sub==0){
                $list_sub='';
            }else{
                while($r_s=mysqli_fetch_assoc($thongtin_sub)){
                    $thongtin_sub_sub=mysqli_query($conn,"SELECT * FROM category WHERE cat_main='{$r_s['cat_id']}' ORDER BY cat_thutu ASC");
                    $total_sub_sub=mysqli_num_rows($thongtin_sub_sub);
                    if($total_sub_sub==0){
                        $list_sub_sub='';
                    }else{
                        while($r_ss=mysqli_fetch_assoc($thongtin_sub_sub)){
                            if($r_ss['cat_id']==$id){
                                $list_sub_sub.='<option value="'.$r_ss['cat_id'].'" selected disabled>---- '.$r_ss['cat_tieude'].'</option>';
                            }else{
                                $list_sub_sub.='<option value="'.$r_ss['cat_id'].'" disabled>---- '.$r_ss['cat_tieude'].'</option>';
                            }
                        }
                    }
                    if($r_s['cat_id']==$id){
                        $list_sub.='<option value="'.$r_s['cat_id'].'" selected>-- '.$r_s['cat_tieude'].'</option>'.$list_sub_sub;
                    }else{
                        $list_sub.='<option value="'.$r_s['cat_id'].'">-- '.$r_s['cat_tieude'].'</option>'.$list_sub_sub;
                    }
                    unset($list_sub_sub);
                }
            }
            $i++;
            if($r_tt['cat_id']==$id){
                $list.='<option value="'.$r_tt['cat_id'].'" selected>'.$r_tt['cat_tieude'].'</option>'.$list_sub;
            }else{
                $list.='<option value="'.$r_tt['cat_id'].'">'.$r_tt['cat_tieude'].'</option>'.$list_sub;
            }
            unset($list_sub);
        }
        return $list;
    }
    ///////////////////
    function list_option_main_auto($conn,$id){
        $tach_id=explode(',', $id);
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM category WHERE cat_main='0' ORDER BY cat_thutu ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $thongtin_sub=mysqli_query($conn,"SELECT * FROM category WHERE cat_main='{$r_tt['cat_id']}' ORDER BY cat_thutu ASC");
            $total_sub=mysqli_num_rows($thongtin_sub);
            if($total_sub==0){
                $list_sub='';
                if($r_tt['cat_id']==$id){
                    $list.='<option value="'.$r_tt['cat_id'].'" selected>'.$r_tt['cat_tieude'].'</option>'.$list_sub;
                }else{
                    $list.='<option value="'.$r_tt['cat_id'].'">'.$r_tt['cat_tieude'].'</option>'.$list_sub;
                }
            }else{
                while($r_s=mysqli_fetch_assoc($thongtin_sub)){
                    $thongtin_sub_sub=mysqli_query($conn,"SELECT * FROM category WHERE cat_main='{$r_s['cat_id']}' ORDER BY cat_thutu ASC");
                    $total_sub_sub=mysqli_num_rows($thongtin_sub_sub);
                    if($total_sub_sub==0){
                        $list_sub_sub='';
                        if($r_s['cat_id']==$tach_id[0]){
                            $list_sub.='<option value="'.$r_s['cat_id'].'" selected>-- '.$r_s['cat_tieude'].'</option>'.$list_sub_sub;
                        }else{
                            $list_sub.='<option value="'.$r_s['cat_id'].'">-- '.$r_s['cat_tieude'].'</option>'.$list_sub_sub;
                        }
                    }else{
                        while($r_ss=mysqli_fetch_assoc($thongtin_sub_sub)){
                            if($r_ss['cat_id']==$tach_id[0]){
                                $list_sub_sub.='<option value="'.$r_ss['cat_id'].'" selected>---- '.$r_ss['cat_tieude'].'</option>';
                            }else{
                                $list_sub_sub.='<option value="'.$r_ss['cat_id'].'">---- '.$r_ss['cat_tieude'].'</option>';
                            }
                        }
                        if($r_s['cat_id']==$tach_id[0]){
                            $list_sub.='<option value="'.$r_s['cat_id'].'" selected>-- '.$r_s['cat_tieude'].'</option>'.$list_sub_sub;
                        }else{
                            $list_sub.='<option value="'.$r_s['cat_id'].'">-- '.$r_s['cat_tieude'].'</option>'.$list_sub_sub;
                        }
                    }
                    unset($list_sub_sub);
                }
                if($r_tt['cat_id']==$tach_id[0]){
                    $list.='<option value="'.$r_tt['cat_id'].'" selected>'.$r_tt['cat_tieude'].'</option>'.$list_sub;
                }else{
                    $list.='<option value="'.$r_tt['cat_id'].'">'.$r_tt['cat_tieude'].'</option>'.$list_sub;
                }
            }
            unset($list_sub);
        }
        return $list;
    }
    ///////////////////
    function list_option_post($conn,$link){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM post ORDER BY id DESC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            if($r_tt['link']==$link){
                $list.='<option value="'.$r_tt['link'].'" selected>'.$r_tt['tieu_de'].'</option>';
            }else{
                $list.='<option value="'.$r_tt['link'].'">'.$r_tt['tieu_de'].'</option>';
            }
        }
        return $list;
    }
    ///////////////////
    function list_option_chap($conn,$chap,$truyen){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM chap WHERE chap_truyen='$truyen' ORDER BY chap_sort ASC");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            if($r_tt['chap_id']==$chap){
                $list.='<option value="'.$r_tt['chap_id'].'" selected>'.$r_tt['chap_tieude'].'</option>';
            }else{
                $list.='<option value="'.$r_tt['chap_id'].'">'.$r_tt['chap_tieude'].'</option>';
            }
        }
        return $list;
    }
    ///////////////////
    function list_audio($conn,$truyen,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM audio WHERE truyen='$truyen' ORDER BY thu_tu DESC LIMIT $start,$limit");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_audio',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_video($conn,$truyen,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM video WHERE truyen='$truyen' ORDER BY thu_tu DESC LIMIT $start,$limit");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_video',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_baiviet($conn,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM post ORDER BY id DESC LIMIT $start,$limit");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_baiviet',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_chat($conn,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT chat.*,user_info.username FROM chat LEFT JOIN user_info ON chat.user_id=user_info.user_id ORDER BY chat.id DESC LIMIT $start,$limit");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['date_post']=date('H:i:s d/m/Y',$r_tt['date_post']);
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_chat',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_comment($conn,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT comment.*,user_info.username,phim.tieu_de,phim.link FROM comment LEFT JOIN user_info ON comment.user_id=user_info.user_id LEFT JOIN phim ON phim.id=comment.phim ORDER BY comment.id DESC LIMIT $start,$limit");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['date_post']=date('H:i:s d/m/Y',$r_tt['date_post']);
            $r_tt['truyen']='<a href="/thong-tin-phim/'.$r_tt['link'].'-'.$r_tt['phim'].'.html" target="_blank">'.$r_tt['tieu_de'].'</a>';
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_comment',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_block($conn,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM block_ip ORDER BY id DESC LIMIT $start,$limit");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['date_post']=date('H:i:s d/m/Y',$r_tt['date_post']);
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_block',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_napcoin($conn,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT nap.*, user_info.username FROM nap LEFT JOIN user_info ON user_info.user_id=nap.user_id ORDER BY nap.id DESC LIMIT $start,$limit");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['coin']=number_format($r_tt['coin']);
            $r_tt['date_post']=date('H:i:s d/m/Y',$r_tt['date_post']);
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_napcoin',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_donate($conn,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT donate.*, user_info.username, truyen.tieu_de FROM donate LEFT JOIN user_info ON user_info.user_id=donate.user_id LEFT JOIN truyen ON truyen.id=donate.truyen ORDER BY donate.id DESC LIMIT $start,$limit");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['coin']=number_format($r_tt['coin']);
            $r_tt['date_post']=date('H:i:s d/m/Y',$r_tt['date_post']);
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_donate',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_muachap($conn,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT muachap.*, user_info.username, truyen.tieu_de, truyen.link, chap.link AS link_chap, chap.tieu_de AS tieude_chap FROM muachap LEFT JOIN user_info ON user_info.user_id=muachap.user_id LEFT JOIN truyen ON truyen.id=muachap.truyen LEFT JOIN chap ON muachap.chap=chap.id ORDER BY muachap.id DESC LIMIT $start,$limit");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['coin']=number_format($r_tt['coin']);
            $r_tt['date_post']=date('H:i:s d/m/Y',$r_tt['date_post']);
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_muachap',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_report($conn,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT baoloi.*, phim.tieu_de, phim.link, user_info.username,list_tap.tieu_de AS tap_tieude FROM baoloi LEFT JOIN phim ON phim.id=baoloi.phim LEFT JOIN list_tap ON list_tap.id=baoloi.tap LEFT JOIN user_info ON user_info.user_id=baoloi.user_id ORDER BY baoloi.id DESC LIMIT $start,$limit");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['date_post']=date('d/m/Y',$r_tt['date_post']);
            if($r_tt['tinh_trang']==1){
                $r_tt['tinh_trang']='Đã xác nhận';
            }else if($r_tt['tinh_trang']==2){
                $r_tt['tinh_trang']='Đã fix';
            }else if($r_tt['tinh_trang']==3){
                $r_tt['tinh_trang']='Báo sai';
            }else{
                $r_tt['tinh_trang']='Mới';
            }
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_report',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_history($conn,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT history.*, truyen.tieu_de AS truyen_tieude, truyen.link AS truyen_link, chap.tieu_de AS chap_tieude, chap.link AS chap_link, user_info.username FROM history LEFT JOIN truyen ON truyen.id=history.truyen LEFT JOIN user_info ON user_info.user_id=history.user_id LEFT JOIN chap ON chap.id=history.chap ORDER BY history.id DESC LIMIT $start,$limit");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            if(strlen($r_tt['chap_tieude'])>1){
                $r_tt['tieu_de']=$r_tt['truyen_tieude'].' - '.$r_tt['chap_tieude'];
                $r_tt['link_truyen']='/truyen-tranh/'.$r_tt['truyen_link'].'/'.$r_tt['chap_link'].'.html';
            }else{
                $r_tt['tieu_de']=$r_tt['truyen_tieude'];
                $r_tt['link_truyen']='/truyen-tranh/'.$r_tt['truyen_link'].'.html';
            }
            $r_tt['thoigian']=$check->time_online($r_tt['date_end'] - $r_tt['date_post']);
            $r_tt['date_post']=date('H:i:s d/m/Y',$r_tt['date_post']);
            $r_tt['date_end']=date('H:i:s d/m/Y',$r_tt['date_end']);
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_history',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_thanhvien($conn,$active,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        if($active=='all'){
            $thongtin=mysqli_query($conn,"SELECT * FROM user_info ORDER BY user_id DESC LIMIT $start,$limit");
        }else{
            $thongtin=mysqli_query($conn,"SELECT * FROM user_info WHERE active='$active' ORDER BY user_id DESC LIMIT $start,$limit");
        }
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['user_money']=number_format($r_tt['user_money']);
            $r_tt['user_donate']=number_format($r_tt['user_donate']);
            $r_tt['created']=date('d/m/Y',$r_tt['created']);
            if($r_tt['active']==2){
                $r_tt['tinh_trang']='Tạm khóa';
            }else if($r_tt['active']==3){
                $r_tt['tinh_trang']='Khóa vĩnh viễn';
            }else{
                $r_tt['tinh_trang']='Bình thường';
            }
            if($active==2){
                $list.=$skin->skin_replace('skin_cpanel/box_action/tr_thanhvien_khoa',$r_tt);
            }else if($active==3){
                $list.=$skin->skin_replace('skin_cpanel/box_action/tr_thanhvien_khoa_vinhvien',$r_tt);
            }else{
                $list.=$skin->skin_replace('skin_cpanel/box_action/tr_thanhvien',$r_tt);
            }
        }
        return $list;
    }
    ///////////////////
    function list_phim($conn,$page,$limit){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit - $limit;
        $thongtin=mysqli_query($conn,"SELECT * FROM phim ORDER BY id DESC LIMIT $start,$limit");
        $i=$start;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['luot_xem']=number_format($r_tt['truyen_view']);
            $r_tt['update_post']=date('H:i:s d/m/Y',intval($r_tt['truyen_update']));
            if($r_tt['truyen_hot']==1){
                $r_tt['truyen_hot']='Có';
            }else{
                $r_tt['truyen_hot']='Không';
            }
            if($r_tt['truyen_status']==1){
                $r_tt['truyen_status']='Có';
            }else{
                $r_tt['truyen_status']='Chưa';
            }
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_phim',$r_tt);
        }
        return $list;
    }
    ///////////////////
    function list_kq_timkiem($conn,$key){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        if(strpos($key, ' ')!==false){
            $thongtin=mysqli_query($conn,"SELECT * FROM phim WHERE tieu_de LIKE '%$key%' OR ten_khac LIKE '%$key%' ORDER BY tieu_de ASC");
        }else{
            $tach_key=explode(' ', $key);
            $x=0;
            foreach ($tach_key as $key => $value) {
                if($value!=''){
                    $x++;
                    if($x==1){
                        $where.="(tieu_de LIKE '%$value%' OR ten_khac LIKE '%$value%')";
                    }else{
                        $where.="AND (tieu_de LIKE '%$value%' OR ten_khac LIKE '%$value%')";

                    }
                }
            }
            $thongtin=mysqli_query($conn,"SELECT * FROM phim WHERE $where ORDER BY tieu_de ASC");
        }
        $i=0;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['luot_xem']=number_format($r_tt['truyen_view']);
            $r_tt['update_post']=date('H:i:s d/m/Y',intval($r_tt['truyen_update']));
            if($r_tt['truyen_hot']==1){
                $r_tt['truyen_hot']='Có';
            }else{
                $r_tt['truyen_hot']='Không';
            }
            if($r_tt['truyen_status']==1){
                $r_tt['truyen_status']='Có';
            }else{
                $r_tt['truyen_status']='Chưa';
            }
            $list.=$skin->skin_replace('skin_cpanel/box_action/tr_phim',$r_tt);
        }
        mysqli_free_result($thongtin);
        if($i==0){
            $list='<center>Không có kết quả</center>';
        }
        return $list;
    }
    ///////////////////
    function list_kq_timkiem_member($conn,$key){
        $skin=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $thongtin=mysqli_query($conn,"SELECT * FROM user_info WHERE username LIKE '%$key%' OR name LIKE '%key%' OR email LIKE '%$key%' OR user_id='$key' ORDER BY name ASC");
        $i=0;
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['user_money']=number_format($r_tt['user_money']);
            $r_tt['user_donate']=number_format($r_tt['user_donate']);
            $r_tt['created']=date('d/m/Y',$r_tt['created']);
            if($r_tt['active']==2){
                $r_tt['tinh_trang']='Tạm khóa';
            }else if($r_tt['active']==3){
                $r_tt['tinh_trang']='Khóa vĩnh viễn';
            }else{
                $r_tt['tinh_trang']='Bình thường';
            }
            if($active==2){
                $list.=$skin->skin_replace('skin_cpanel/box_action/tr_thanhvien_khoa',$r_tt);
            }else if($active==3){
                $list.=$skin->skin_replace('skin_cpanel/box_action/tr_thanhvien_khoa_vinhvien',$r_tt);
            }else{
                $list.=$skin->skin_replace('skin_cpanel/box_action/tr_thanhvien',$r_tt);
            }
        }
        mysqli_free_result($thongtin);
        if($i==0){
            $list='<center>Không có kết quả</center>';
        }
        return $list;
    }
//////////////////////////////////////////////////////////////////
    function list_setting($conn,$page,$limit){
        $tlca_skin_cpanel=$this->load('class_skin_cpanel');
        $check=$this->load('class_check');
        $start=$page*$limit-$limit;
        $i=$start;
        $thongtin=mysqli_query($conn,"SELECT * FROM index_setting ORDER BY name DESC LIMIT $start,$limit");
        while($r_tt=mysqli_fetch_assoc($thongtin)){
            $i++;
            $r_tt['i']=$i;
            $r_tt['value']=$check->words($r_tt['value'],200);
            $list.=$tlca_skin_cpanel->skin_replace('skin_cpanel/box_action/tr_setting',$r_tt);
        }
        return $list;
    }
    ///////////////////////
    function phantrang($page, $total, $link) {
        if ($total <= 1) {
            return '';
        } else {
            if($total==2){
                if($page<$total){
                    return '<div class=pagination><div class="pagination-custom"><span>1</span><a href="'.$link.'?page=2">2</a><a href="'.$link.'?page=2">Next</a></div></div>';
                }else if($page==$total){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=1">Prev</a><a href="'.$link.'?page=1">1</a><span>2</span></div></div>';
                }else{
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=1">1</a><a href="'.$link.'?page=2">2</a></div></div>';
                }
            }else if($total==3){
                if($page==1){
                    return '<div class=pagination><div class="pagination-custom"><span>1</span><a href="'.$link.'?page=2">2</a><a href="'.$link.'?page=3">3</a><a href="'.$link.'?page=2">Next</a></div></div>';
                }else if($page==2){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=1">Prev</a><a href="'.$link.'?page=1">1</a><span>2</span><a href="'.$link.'?page=3">3</a><a href="'.$link.'?page=3">Next</a></div></div>';
                }else if($page==3){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=2">Prev</a><a href="'.$link.'?page=1">1</a><a href="'.$link.'?page=2">2</a><span>3</span></div></div>';
                }else{
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=1">1</a><a href="'.$link.'?page=2">2</a><a href="'.$link.'?page=3">3</a></div></div>';
                }
            }else if($total==4){
                if($page==1){
                    return '<div class=pagination><div class="pagination-custom"><span>1</span> . . . <a href="'.$link.'?page=4">4</a><a href="'.$link.'?page=2">Next</a></div></div>';
                }else if($page==2){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=1">Prev</a><a href="'.$link.'?page=1">1</a><span>2</span> . . . <a href="'.$link.'?page=4">4</a><a href="'.$link.'?page=3">Next</a></div></div>';
                }else if($page==3){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=2">Prev</a><a href="'.$link.'?page=1">1</a> . . . <span>3</span><a href="'.$link.'?page=4">4</a><a href="'.$link.'?page=4">Next</a></div></div>';
                }else if($page==4){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=3">Prev</a><a href="'.$link.'?page=1">1</a> . . . <span>4</span></div></div>';
                }else{
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=1">1</a><a href="'.$link.'?page=2">2</a><a href="'.$link.'?page=3">3</a><a href="'.$link.'?page=4">4</a></div></div>';
                }
            }else{
                if($page==1){
                    return '<div class=pagination><div class="pagination-custom"><span>1</span> . . . <a href="'.$link.'?page='.$total.'">'.$total.'</a><a href="'.$link.'?page=2">Next</a></div></div>';
                }else if($page==2){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=1">Prev</a><a href="'.$link.'?page=1">1</a><span>2</span> . . . <a href="'.$link.'?page='.$total.'">'.$total.'</a><a href="'.$link.'?page=3">Next</a></div></div>';
                }else if($page==3){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=2">Prev</a><a href="'.$link.'?page=1">1</a> . . . <span>3</span><a href="'.$link.'?page='.$total.'">'.$total.'</a><a href="'.$link.'?page=4">Next</a></div></div>';
                }else if($page<=$total - 2){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page='.$back.'">Prev</a><a href="'.$link.'?page=1">1</a> . . . <span>'.$page.'</span> . . . <a href="'.$link.'?page='.$total.'">'.$total.'</a><a href="'.$link.'?page='.$next.'">Next</a></div></div>';
                }else if($page<$total - 1){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page='.$back.'">Prev</a><a href="'.$link.'?page=1">1</a> . . . <span>'.$page.'</span><a href="'.$link.'?page='.$total.'">'.$total.'</a><a href="'.$link.'?page='.$next.'">Next</a></div></div>';
                }else if($page==$total - 1){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page='.$back.'">Prev</a><a href="'.$link.'?page=1">1</a> . . . <span>'.$page.'</span><a href="'.$link.'?page='.$total.'">'.$total.'</a><a href="'.$link.'?page='.$next.'">Next</a></div></div>';
                }else if($page==$total){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page='.$back.'">Prev</a><a href="'.$link.'?page=1">1</a> . . . <a href="'.$link.'?page='.$back.'">'.$back.'</a><span>'.$page.'</span></div></div>';
                }else{
                    $k=$total-1;
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'?page=1">1</a><a href="'.$link.'?page=2">2</a> . . . <a href="'.$link.'?page='.$k.'">'.$k.'</a><a href="'.$link.'?page='.$total.'">'.$total.'</a></div></div>';
                }
            }
        }
    }
    ///////////////////////
    function phantrang_timkiem($page, $total, $link) {
        if ($total <= 1) {
            return '';
        } else {
            if($total==2){
                if($page<$total){
                    return '<div class=pagination><div class="pagination-custom"><span>1</span><a href="'.$link.'&page=2">2</a><a href="'.$link.'&page=2">Next</a></div></div>';
                }else if($page==$total){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=1">Prev</a><a href="'.$link.'&page=1">1</a><span>2</span></div></div>';
                }else{
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=1">1</a><a href="'.$link.'&page=2">2</a></div></div>';
                }
            }else if($total==3){
                if($page==1){
                    return '<div class=pagination><div class="pagination-custom"><span>1</span><a href="'.$link.'&page=2">2</a><a href="'.$link.'&page=3">3</a><a href="'.$link.'&page=2">Next</a></div></div>';
                }else if($page==2){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=1">Prev</a><a href="'.$link.'&page=1">1</a><span>2</span><a href="'.$link.'&page=3">3</a><a href="'.$link.'&page=3">Next</a></div></div>';
                }else if($page==3){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=2">Prev</a><a href="'.$link.'&page=1">1</a><a href="'.$link.'&page=2">2</a><span>3</span></div></div>';
                }else{
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=1">1</a><a href="'.$link.'&page=2">2</a><a href="'.$link.'&page=3">3</a></div></div>';
                }
            }else if($total==4){
                if($page==1){
                    return '<div class=pagination><div class="pagination-custom"><span>1</span> . . . <a href="'.$link.'&page=4">4</a><a href="'.$link.'&page=2">Next</a></div></div>';
                }else if($page==2){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=1">Prev</a><a href="'.$link.'&page=1">1</a><span>2</span> . . . <a href="'.$link.'&page=4">4</a><a href="'.$link.'&page=3">Next</a></div></div>';
                }else if($page==3){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=2">Prev</a><a href="'.$link.'&page=1">1</a> . . . <span>3</span><a href="'.$link.'&page=4">4</a><a href="'.$link.'&page=4">Next</a></div></div>';
                }else if($page==4){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=3">Prev</a><a href="'.$link.'&page=1">1</a> . . . <span>4</span></div></div>';
                }else{
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=1">1</a><a href="'.$link.'&page=2">2</a><a href="'.$link.'&page=3">3</a><a href="'.$link.'&page=4">4</a></div></div>';
                }
            }else{
                if($page==1){
                    return '<div class=pagination><div class="pagination-custom"><span>1</span> . . . <a href="'.$link.'&page='.$total.'">'.$total.'</a><a href="'.$link.'&page=2">Next</a></div></div>';
                }else if($page==2){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=1">Prev</a><a href="'.$link.'&page=1">1</a><span>2</span> . . . <a href="'.$link.'&page='.$total.'">'.$total.'</a><a href="'.$link.'&page=3">Next</a></div></div>';
                }else if($page==3){
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=2">Prev</a><a href="'.$link.'&page=1">1</a> . . . <span>3</span><a href="'.$link.'&page='.$total.'">'.$total.'</a><a href="'.$link.'&page=4">Next</a></div></div>';
                }else if($page<=$total - 2){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page='.$back.'">Prev</a><a href="'.$link.'&page=1">1</a> . . . <span>'.$page.'</span> . . . <a href="'.$link.'&page='.$total.'">'.$total.'</a><a href="'.$link.'&page='.$next.'">Next</a></div></div>';
                }else if($page<$total - 1){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page='.$back.'">Prev</a><a href="'.$link.'&page=1">1</a> . . . <span>'.$page.'</span><a href="'.$link.'&page='.$total.'">'.$total.'</a><a href="'.$link.'&page='.$next.'">Next</a></div></div>';
                }else if($page==$total - 1){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page='.$back.'">Prev</a><a href="'.$link.'&page=1">1</a> . . . <span>'.$page.'</span><a href="'.$link.'&page='.$total.'">'.$total.'</a><a href="'.$link.'&page='.$next.'">Next</a></div></div>';
                }else if($page==$total){
                    $back=$page-1;
                    $next=$page+1;
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page='.$back.'">Prev</a><a href="'.$link.'&page=1">1</a> . . . <a href="'.$link.'&page='.$back.'">'.$back.'</a><span>'.$page.'</span></div></div>';
                }else{
                    $k=$total-1;
                    return '<div class=pagination><div class="pagination-custom"><a href="'.$link.'&page=1">1</a><a href="'.$link.'&page=2">2</a> . . . <a href="'.$link.'&page='.$k.'">'.$k.'</a><a href="'.$link.'&page='.$total.'">'.$total.'</a></div></div>';
                }
            }
        }
    }
//////////////////////////////////////////////////////////////////
    function thanhvien_info($conn,$id){
        $thongtin=mysqli_query($conn,"SELECT * FROM user_info WHERE user_id='$id'");
        $total=mysqli_num_rows($thongtin);
        if($total=="0"){
            $r_tt='';
        }else{
            $r_tt=mysqli_fetch_assoc($thongtin);
        }
        return $r_tt;
    }
//////////////////////////////////////////////////////////////////
    function my_info($conn){
        $thongtin=mysqli_query($conn,"SELECT * FROM e_min WHERE username='{$_SESSION['e_name']}'");
        $r_tt=mysqli_fetch_assoc($thongtin);
        return $r_tt;
    }   
//////////////////////////////////////////////////////////////////
}
?>
