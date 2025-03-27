<?php

	$tlca_data = array();

	$tlca_data['server'] = 'localhost';

	$tlca_data['dbuser'] = 'root';

	$tlca_data['dbpassword'] = '';

	$tlca_data['dbname'] = 'phimhh';

	date_default_timezone_set('Asia/Saigon');

	 //Connect 

	$conn = mysqli_connect($tlca_data['server'],$tlca_data['dbuser'],$tlca_data['dbpassword'],$tlca_data['dbname']);
	//mysqli_set_charset($conn,"utf8");
	// Template config

	//@define(skin_name,'skin'); 

	//@define(skin_ext,'.tpl');

?>