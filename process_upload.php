<?php
  include('./includes/tlca_world.php');
  $check=$tlca_do->load('class_check');
/*  $total=count((array)$_FILES['file']['name']);
  $k=0;
  for ($i=0; $i < $total ; $i++) { 
    $filename = $_FILES['file']['name'][$i];
    $duoi = $check->duoi_file($_FILES['file']['name'][$i]);
    if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp','mp4')) == true) {
      $folder_name = '/uploads/test/';

      if (!file_exists('.'.$folder_name)) {
          mkdir('.'.$folder_name, 0777);
      } else {
      }
      $minh_hoa = $folder_name.''. $filename. '-' . time() . '.' . $duoi;
      move_uploaded_file($_FILES['file']['tmp_name'][$i], '.' . $minh_hoa);
      //$minh_hoa = $index_setting['link_img'] . '' . $minh_hoa;
      //$list.=$index_setting['link_domain'] . '' . substr($minh_hoa,1)."\n";
      $k++;
    }
  }*/
  $filename = $_FILES['file']['name'];
  $duoi = $check->duoi_file($_FILES['file']['name']);
  if (in_array($duoi, array('jpg', 'jpeg', 'png', 'gif','webp','mp4')) == true) {
    $folder_name = '/uploads/test/';

    if (!file_exists('.'.$folder_name)) {
        mkdir('.'.$folder_name, 0777);
    } else {
    }
    $minh_hoa = $folder_name.''. $check->blank($filename). '-' . time() . '.' . $duoi;
    move_uploaded_file($_FILES['file']['tmp_name'], '.' . $minh_hoa);
  }
/*  $link_video='https://phimhh.net'.$minh_hoa;
  $api_key='10256k872ft4dxxjd51bx';
  $link_upload='https://doodapi.com/api/upload/url?key=340992hgnb8ymboqmdbq95&url='.$link_video;
  $xxx=$check->getpage($link_upload,$link_upload);
  echo $xxx;*/
?>