<?php
session_start();
// Config
error_reporting(1);
include('config.php');
// class gold ly
include('class_manage.php');
// Class manage Variable
$tlca_do = new class_manage;
// Template Variable
$tlca_skin = $tlca_do->skin;
$class_member = $tlca_do->load('class_member');
$class_member->check_login();
?>