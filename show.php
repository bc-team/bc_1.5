<?php

require "include/beContent.inc.php";

function getExtension($name) {
	
	if (ereg("\.([[:alnum:]]*)$", $name, $token)) {
		return $token[1];
	} else {
		return false;
	}
	
}



if (!isset($_REQUEST['token'])) {
	
	print_r(beContent::getInstance()->files);
	exit;
}


if (file_exists("{Config::getInstance()->getConfigurations()['cache_folder']}/".md5($_SERVER['QUERY_STRING']).".jpg")) {
	
	Header("Location: {Config::getInstance()->getConfigurations()['cache_folder']}/".md5($_SERVER['QUERY_STRING']).".jpg");
	exit;
}

$table = beContent::getInstance()->files[$_REQUEST['token']]['table'];
$field = beContent::getInstance()->files[$_REQUEST['token']]['field'];

$entity = DB::getInstance()->getEntityByName($table);

$f = $entity->getField($field);
$type = $f['type'];


if (isset($_REQUEST['id'])) {

	$oid = mysql_query("SELECT * 
    	                  FROM {$table} 
        	             WHERE {$entity->fields[0]['name']} = '{$_REQUEST['id']}'");



} 

if (!$oid) {
	echo "Error!";
	exit;
}

$data = mysql_fetch_assoc($oid);

if ((mysql_num_rows($oid) == 0) or ($data[$field."_size"] == 0)) {
	
	
	
	Header("Location: img/trasparent.gif");
	exit;	
}

if ($type == FILE2FOLDER) {
	
	$filename = "{Config::getInstance()->getConfigurations()['upload_folder']}/{$data[$field."_reference"]}";
	
	if (file_exists($filename)) {
		$fp = @fopen($filename, "r");
		
        $buffer .= fread($fp, filesize($filename));
    	
		fclose($fp);
		
	} else {
		$buffer = "";
	}

	
} else {
	$buffer = $data[$field];
}

if ($_REQUEST['attachment'] == true) {
	Header("Content-Disposition: attachment; filename=\"".$data[$field."_filename"]."\"");
} else {
	Header("Content-Disposition: filename=\"".$data[$field."_filename"]."\"");
}

Header("Content-type: ".$data["{$field}_type"]);


switch ($data["{$field}_type"]) {
	case "image/jpeg":
	case "image/gif":
		$fp = fopen("{Config::getInstance()->getConfigurations()['cache_folder']}/".md5($_SERVER['QUERY_STRING']).".jpg", "w");
		break;
}


if (isset($_REQUEST['thumb'])) {
	
	/* THUMBNAIL */
	
	$im = imagecreatefromstring($buffer);
	$width_orig = imageSX($im);
	$height_orig = imageSY($im);
	
	$width = $_REQUEST['width'];
	$height = $_REQUEST['height'];
	
	if (true) {
		if ($_REQUEST['width'] < $_REQUEST['height']) {
		
		
		
			$width2 = round(($height*$width_orig)/$height_orig);
			$height2 = $height;
		
			if ($width2 < $width) {
			
				$width2 = $width;
				$height2 = round(($width2*$height_orig)/$width_orig);
			
			}
		
			$offset_height = 0;
			$offset_weight = ($width2 - $width);
		
		} else {
			$height2 = round(($width*$height_orig)/$width_orig);
			$width2 = $width;
		
			if ($height2 < $height) {
				$height2 = $height;
				$width2 = round(($height2*$width_orig)/$height_orig);
			}
		
			$offset_height = ($height2 - $height);
			$offset_weight = 0;
		}
		$thumb = imagecreatetruecolor($width, $height);
	
		#imagecopyresized($thumb, $im, 0, 0, 0, $offset_height, $width2, $height2, $width_orig, $height_orig);
		imagecopyresampled($thumb, $im, 0, 0, 0, $offset_height, $width2, $height2, $width_orig, $height_orig);

	} 
	
	imagejpeg($thumb);
	imagejpeg($thumb, "{Config::getInstance()->getConfigurations()['cache_folder']}/".md5($_SERVER['QUERY_STRING']).".jpg");
		
} else {
	if (isset($_REQUEST['width']) or isset($_REQUEST['height'])) {
	
		$im = imagecreatefromstring($buffer);
		$old_x=imageSX($im);
		$old_y=imageSY($im);
		
		if (isset($_REQUEST['width']) and !isset($_REQUEST['height'])) {
			$new_x = $_REQUEST['width'];
			$new_y = round(($new_x*$old_y)/$old_x);
		} elseif (!isset($_REQUEST['width']) and isset($_REQUEST['height'])) {
			$new_y = $_REQUEST['height'];
			$new_x = round(($new_y*$old_x)/$old_y);
		} else {
			$new_x = $_REQUEST['width'];
			$new_y = $_REQUEST['height'];
		}
		
		
		$thumb = imagecreatetruecolor($new_x, $new_y);
		imagecopyresized($thumb, $im, 0, 0, 0, 0, $new_x, $new_y, $old_x, $old_y);
		imagejpeg($thumb);
		imagejpeg($thumb, "{Config::getInstance()->getConfigurations()['cache_folder']}/".md5($_SERVER['QUERY_STRING']).".jpg");
	} else {
		
		/* AS-IS OUTPUT (valid for any kind of MIME types */
		
		echo $buffer;
		
		fwrite($fp, $buffer);
		fclose($fp);
	}
}


?>