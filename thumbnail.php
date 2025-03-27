<?php
    function duoi_file($filename){
        return strtolower(substr(basename($filename), strrpos(basename($filename), ".") + 1));
    }
    function print_thumb($src, $desired_width = 215){
        /* read the source image */
        $duoi=duoi_file($src);
		if ($duoi == 'gif'){
			$source_image = imagecreatefromgif($src);
		}elseif($duoi=='png'){
			$source_image = imagecreatefrompng($src);
		}else{
			$source_image = imagecreatefromjpeg($src);
		}
        $width = imagesx($source_image);
        $height = imagesy($source_image);

        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_height = floor($height * ($desired_width / $width));

        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

        /* copy source image at a resized size */
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
        // Set the content type header - in this case image/jpeg
        // Output the image
		if ($duoi == 'gif'){
			header('Content-Type: image/gif');
			imagegif($virtual_image);
		}elseif($duoi=='png'){
			header('Content-Type: image/png');
			imagepng($virtual_image);
		}else{
			header('Content-Type: image/jpeg');
			imagejpeg($virtual_image);
		}

    }
    print_thumb($_REQUEST['img'],$_REQUEST['w']);
?>