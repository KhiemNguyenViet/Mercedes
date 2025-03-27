	<?php
	class class_skin_cpanel
	{
		// Load skin with input
		function skin_replace($skin_name,$input)
		{
			$contents = $this->skin_load($skin_name);
			$contents = $this->_replace($contents, $input);
			return $contents;			
		}
		// Load skin without input
		function skin_normal($skin_name)
		{
			$contents = $this->skin_load($skin_name);
			return $contents;
		}
		// function replace skin
		function _replace($contents, $input)
		{
			foreach($input as $key => $value){
				$contents = str_replace('{'. $key .'}', $value, $contents);
			}
			return $contents;
		}
		// Function load skin contents
		function skin_load($skin_name)
		{       
			ob_start();
			$file = '../'.$skin_name.'.tpl';
			if(!file_exists($file)){
				return FALSE;
				//return $skin_name.skin_ext.' Not Found';
			}
			include($file);
			$contents = ob_get_contents();
			ob_end_clean();
			return $contents;
		}
	}
?>