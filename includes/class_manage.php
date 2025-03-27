<?php
	class class_manage
		{	
			/*========================================/*
			*| construcs function
			*| Xay dung doi tuong can thiet
			*| Dinh nghia $data va $skin
			/*========================================*/
			public $data;
			public $skin;
			public $userid;
			function __construct()
				{
					$this->skin = $this->load('class_skin');
				}
			/*========================================/*
			*|
			*| Class load
			*| Chi input class name , ko .php
			/*========================================*/
			function load($class_name)
				{
					if(!class_exists($class_name))
					{
					$class_file = $class_name.'.php';
					include($class_file);
					$load = new $class_name;
					return $load;
					}
					$load = new $class_name();
					return $load;
				}
		}
?>