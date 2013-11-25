<?php

	/*
	
	This file is part of beContent.

    Foobar is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Foobar is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with beContent.  If not, see <http://www.gnu.org/licenses/>.
    
    http://www.becontent.org
    
    */

$tableColor = false;
	
Class becontentTags extends Tag {
	
	
	
	function injectStyle() {
		
		$css = new Template("include/tags/becontent-tags.css");		
		return $css->get();
		
	}
	
	
	function getcomments($name, $data, $pars) {
		
		$entity = DB::getInstance()->getEntityByName($pars['entity']);
		$comments = beContent::getInstance()->comments[$entity->name];
		
		return $comments->getComments($data);
	}
	
	function addcomment($name, $data, $pars) {
		
		
		
		#if ($pars['comments'] == "*") {
		
			$entity = DB::getInstance()->getEntityByName($pars['entity']);
			$comments = beContent::getInstance()->comments[$entity->name];
		
			if (isset($_REQUEST['action_comment']) and ($_REQUEST['action_comment'] == "add")) {
			
				if ($comments->moderated) {
					$active = '';
				
				} else {
					$active = '';
				}
				
				$newComment = '*';
			
				$oid = mysql_query("INSERT INTO comments 
			                         VALUES (NULL,
			                                 '{$_SESSION['user']['username']}',
			                                 '".date("YmdHi")."',
			                                 '',
			                                 '{$entity->name}',
			                                 '{$data}',
			                                 '{$_REQUEST['body']}',
			                                 '',
			                                 '',
			                                 '{$active}',
			                                 '{$newComment}')");
				$add = true;
			
			} else {
				$add = false;
			}
		
			return $comments->addComment($data, $add);
		#} else {
		#	return "";
		#}
	}
	
	
	function lastupdate($name, $data, $pars) {
		
		$update = Parser::getResult("
		
			SELECT date
			  FROM {$GLOBALS['logEntity']->name}
			 WHERE entity = '{$GLOBALS['newsEntity']->name}' 
			   AND (operation = 'ADD' or operation = 'EDIT')
		  ORDER BY date DESC
		     LIMIT 1
		");
		
		return Parser::formatDate($update[0]['date'], EXTENDED);
	}
	
	function formatdate($name, $data, $pars) {
		
		return Parser::formatDate($data, $pars['mode']);
		
	}
	
	function subtext($name, $data, $pars) {
		
		return Parser::subtext($data, $pars['length']);
	}
	
	function strtolower($name, $data, $pars) {
		return strtolower($data);
	}
	
	function seo_url($name, $data, $pars) {
		return Parser::seo_url($data);
	}
	
	function email($name, $data, $pars) {
		return Parser::email($data, $pars);
	}
	
	function phone($name, $data, $pars) {
		
		if ($data != "") {
			$result = $pars['prefix']." ".Parser::phone($data);
		} else {
			$result = "";
		}
		
		return $result;
	}
	
	function ifnotempty($name, $data, $pars) {
		
		if ($data != "") {
			$result = $pars['true'].$data;
		} else {
			$result = $pars['false'];
		}
		
		return $result;
	}
	
	function urlappend($name, $data, $pars) {
		
		$query_string = $_SERVER['QUERY_STRING'];
		
		if ($query_string == "") {
			$result = basename($_SERVER['SCRIPT_NAME'])."?{$pars['parameter']}";
		} else {
			
			$query_string = ereg_replace("&tab=news$", "", $query_string);
			$query_string = ereg_replace("\?tab=news$", "", $query_string);
			$query_string = ereg_replace("&tab=events$", "", $query_string);
			$query_string = ereg_replace("\?tab=events$", "", $query_string);
					
			$result = basename($_SERVER['SCRIPT_NAME'])."?{$query_string}&{$pars['parameter']}";
		}
		
		return $result;
	}
	
	function corner($name, $data, $pars) {
		
		switch($pars['mode']) {
			case "round":
			case "ROUND":
				
				$result = "<div class=\"corner-leftup\">&nbsp;</div>
    				<div class=\"corner-leftdw\">&nbsp;</div>
    				<div class=\"corner-rightup\">&nbsp;</div>
    				<div class=\"corner-rightdw\">&nbsp;</div>";
		}
		
		return $result;
		
	}
	
	function tablecolor($name, $data, $pars) {
		
		if ($GLOBALS['tableColor']) {
			$GLOBALS['tableColor'] = false;
			return "on";
		} else {
			$GLOBALS['tableColor'] = true;
			return "off";
		}
			
	}
	
	function show($name, $data, $pars) {
		
		$query_string = "token={$pars['token']}&id={$data}";
		
		if (isset($pars['width'])) {
			$query_string .= "&width={$pars['width']}";
		}
		if (isset($pars['height'])) {
			$query_string .= "&height={$pars['height']}";
		}
		if (isset($pars['thumb'])) {
			$query_string .= "&thumb";
		}
				
			
		
		
		/* 
		
			<img src="show.php?token=6551f2d74314eb0e077f12d1e38b420b&id=<[users_username_2]>&width=50&height=50&thumb" alt="">
			
		*/
		
		
			
		$filename = "{$config['cache_folder']}/".md5($query_string).".jpg";
		
		#echo filemtime($filename) + $config['cache_timeout'], "<br>", time();exit;
		
		if (!(file_exists($filename)) or (filemtime($filename) + $config['cache_timeout'] < time())) {
		#if (!(file_exists($filename))) {
			
			return "<img src=\"show.php?{$query_string}\" alt=\"\"><!-- normal img ".md5($query_string)."-->";
			#return "<img src=\"{$config['cache_folder']}/".md5($query_string).".jpg\" alt=\"\" /><!-- cached img -->";
		} else {
			return "<img src=\"{$config['cache_folder']}/".md5($query_string).".jpg\" alt=\"\" /><!-- cached img -->";
		}
		
		
	}
	
}

?>
