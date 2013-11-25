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


Class hiermenu extends Tag {

	private $first = true;

	/* function injectJS() {

	}

	function includeJS() {

	} */

	function injectStyle() {

		$css = new Template("include/tags/hiermenu.css");
		return $css->get();

	}

	function mkIndent($level) {
		global $globalLevel;
			
		$globalLevel = 0;
		$result = "";

		if ($globalLevel < $level) {
			$result .= "<ul>\n";
		}

		if ($globalLevel > $level) {
			$result .= "</ul>\n";
		}

		$result .= "<li>";


		return $result;
	}

	function FindChildren ($parent, $level) {
		global
		$menu_flag,
		$menu_data,
		$menu_tree,
		$menu_tree_text,
		$menu_tree_value,
		$menu_tree_link,
		$menu_tree_level,
		$menu_tree_page,

		$menu_undef_flag;

		 

		for ($i=0;$i<count($menu_data);$i++) {

			if (($menu_data[$i]['parent_id'] == $parent) and (!isset($menu_flag[$i]))) {

				$menu_tree[] = $menu_data[$i];
				 
				$menu_tree_value[] = $menu_data[$i]['id'];
				$menu_tree_text[] = $menu_data[$i]['entry'];
				$menu_tree_link[] = $menu_data[$i]['link'];
				$menu_tree_page[] = $menu_data[$i]['page_id'];
				 
				$menu_tree_level[] = $level;
				 
				$menu_flag[$i]=true;
				 
				hiermenu::FindChildren($menu_data[$i]['id'],$level+1);

			}
		}
	}


	function link($link) {

		if (ereg("^\{([[:alnum:]]*)\}\?([[:alnum:]]*)$", $link, $token)) {
				
			switch ($token[1]) {
				case "urlappend":
						
					$query_string = $_SERVER['QUERY_STRING'];

					if ($query_string == "") {
						$result = basename($_SERVER['SCRIPT_NAME'])."?{$token[2]}";
					} else {

							
						$query_string = ereg_replace("&{$token[2]}$", "", $query_string);
						$query_string = ereg_replace("\?{$token[2]}$", "", $query_string);
						$result = basename($_SERVER['SCRIPT_NAME'])."?{$query_string}&{$token[2]}";
					}
						
					break;
				default:
					$result = $link;
					break;
			}

		} else {
				
			$result = $link;
		}

		return $result;
	}

	

	function menu($name,$data,$pars) {
		global
		$menu_flag,
		$menu_data,
		$menu_tree,
		$menu_tree_text,
		$menu_tree_value,
		$menu_tree_link,
		$menu_tree_level,
		$menu_tree_page,

		$menu_undef_flag;
		 

		if (!isset($pars['depth'])) {
			$pars['depth'] = 100;
		}
		 
		if (!isset($pars['parent'])) {
			$pars['parent'] = 0;
		}



		$oid = mysql_query("SELECT menu.id,
				menu.entry AS entry,
				menu.link,
				menu.page_id,
				menu.parent_id
				FROM menu
				ORDER BY position");

		if (!$oid) {
			echo "Error";
			exit;
		}

		do {
			$data = mysql_fetch_assoc($oid);
			if ($data) {
				$menu_data[] = $data;

			}
				
		} while ($data);

		hiermenu::FindChildren($pars['parent'],0);

		if(first){
				
			$content = "<div id=\"sidemenu\">\n";
				
			$id = uniqid(time());

			$level = 0;
			for($i=0; $i<count($menu_tree_value); $i++) {
					
				if (($menu_tree_level[$i] > $level) && ($menu_tree_level[$i] < $pars['depth'])) {

					/* if ($pars['mode'] == "inline") {
					 $content .= "";
					} else { */
					$content .= "<ul id=\"sub-menu-{$i}\">\n";
					//}

					$level = $menu_tree_level[$i];
				}
					
				// usato se ci sono due entry nello stesso livello con sotto livelli
				if ($menu_tree_level[$i] < $level) {
					for($j=$menu_tree_level[$i]; $j<$level; $j++) {
							
						/* if ($pars['mode'] == "inline") {
						 $content .= "";
						} else { */
						$content .= "</ul>\n";
						//}
					}
					$level = $menu_tree_level[$i];
				}
					
				$preamble = "";
				if ($menu_tree_level[$i] > 0) {
					$preamble = "";
				}
					
				if ($menu_tree_level[$i] < $pars['depth']) {

					if ($menu_tree_link[$i] != "") {
							
						$link = $this->link($menu_tree_link[$i]);
							
						/* if ($pars['mode'] == "inline") {
						 $content .= Parser::first_comma($id," | ")."{$preamble} {$preamble} <a href=\"{$link}\">{$menu_tree_text[$i]}</a>";
						} else { */
						$content .= "<li id=\"sub-menu-{$i}-{$i}\">{$preamble} <a href=\"{$link}\">{$menu_tree_text[$i]}</a></li>";
						//}
					}
					else {
							
						if ($menu_tree_page[$i] == 0) {

							/* if ($pars['mode'] == "inline") {
							 $content .= Parser::first_comma($id," | ")."{$preamble} {$menu_tree_text[$i]}";
							} else { */
							$content .= "<h3>{$preamble} {$menu_tree_text[$i]}</h3>";
							//}
						}
						else {
							/* if ($pars['mode'] == "inline") {
							 $content .= Parser::first_comma($id," | ")."{$preamble} {$preamble} <a href=\"page.php?page_id={$menu_tree_page[$i]}\">{$menu_tree_text[$i]}</a>";
							} else { */
							$content .= "<li>{$preamble} <a href=\"page.php?page_id={$menu_tree_page[$i]}\">{$menu_tree_text[$i]}</a> </li>";
							//}
						}
					}

					if (! ( ($menu_tree_level[$i+1] > $level) && ($menu_tree_level[$i+1] < $pars['depth']) ) ) {
							
						/* if ($pars['mode'] == "inline") {
						 $content .= "";
						} else { */
						//$content .= "</li>\n";
						//}
					}
				}
			}

			for($j=0; $j<$level; $j++) {
					
				/* if ($pars['mode'] == "inline") {
				 $content .= "";
				} else { */
				$content .= "</ul></li>\n";
				//}
			}

			if ($pars['mode'] == "inline") {
				$content .= "";
			} else {
				$content .= "</div>\n";
			}

			unset($GLOBALS['menu_flag']);
			unset($GLOBALS['menu_data']);
			unset($GLOBALS['menu_tree']);
			unset($GLOBALS['menu_tree_text']);
			unset($GLOBALS['menu_tree_value']);
			unset($GLOBALS['menu_tree_link']);
			unset($GLOBALS['menu_tree_page']);
			unset($GLOBALS['menu_tree_level']);
			unset($GLOBALS['menu_undef_flag']);
			 
			$this->first=false;
			 
			return $content;
		}
	}

	
	
	function getFather($instances, $child_father_id, $tree_array)
	{
		if($child_father_id!=0)
			foreach($instances as $k=>$instance_data_array)
			{
				
				if($instance_data_array["id"]==$child_father_id)
				{
					$tree_array=$this->getFather($instances,$instance_data_array["father"],$tree_array);
					$tree_array[]=$instance_data_array;
					break;
				}
			}

			
		
		return $tree_array;
	}
	
	function sitemap($name,$data,$pars)
	{
		
		$oid = mysql_query("SELECT page.id AS id,
				page.title AS title,
				page.father AS father,
				page.link AS link
				FROM page");
		
		if($oid)
		{
			do {
				$data = mysql_fetch_assoc($oid);
				if ($data) {
					$page_data[] = $data;
				}
			
			} while ($data);
		}
		
		$id=0;
		foreach($page_data as $k=>$v)
		{
			if($v["link"]==preg_replace("/\//","",$_SERVER["SCRIPT_NAME"]))
				$id=$v["id"];
		}
		
		
		
		$tree_array=array();
		
		//navigates father to the root with recursive function
		$tree_array=$this->getFather($page_data,$id,$tree_array);
		
		
		foreach($tree_array as $k=>$node)
		{
			$content.=
			"
							<a class=\"bc\" href=\"{$node["link"]}\"><span>
									{$node["title"]}</span></a>
			";
			
		}
		
		return $content;
	}
		
	
	function path($name,$data,$pars) {


		if ($data != "") {

			$content = "";
			$id_menu = $data;
			do {

				$item = Parser::getResult("SELECT menu.*,
						pages.title,
						pages.id AS pages_id
						FROM menu
						LEFT JOIN pages
						ON pages.id = menu.page_id
						WHERE menu.id = {$id_menu}
				ORDER BY position");
					
					
				$id_menu = $item[0]['parent_id'];

				if ($item[0]['link'] != "") {
					$content = "<a href=\"{$item[0]['link']}\">{$item[0]['entry']}</a>".Parser::first_comma("path", " &raquo; ").$content;
				} else {
					$content = "<a href=\"page/".Parser::seo_url($item[0]['title'])."/{$item[0]['pages_id']}-{$item[0]['id']}.htm\">{$item[0]['entry']}</a>".Parser::first_comma("path", " > ").$content;
				}
					
					
			} while ($item[0]['parent_id'] != 0);

			return $content;
		}
	}

	function administrationMenu2($name, $data, $pars) {
	  
		$content = "<div id=\"administrationMenu\">\n";
		$content .= "<ul>\n";
		$category = "";
	  
		if (is_array($_SESSION['user']['services'])) {
			 
			foreach($_SESSION['user']['services'] as $service) {
				if ($category != $service['category']) {
						
					$content .= Parser::first_comma("hiermenu", "</ul>\n");
					$content .= "<li><strong>{$service['category']}</strong></li>\n";
					$content .= "<ul>\n";
					$category = $service['category'];
				}
	    
				if (ereg("manager", $service['script'])) {
					 
					$content .= "<li><a href=\"{$service['script']}?action=list\">{$service['serviceName']}</a> |<a href=\"{$service['script']}?action=emit\" title=\"Add\"><img src=\"img/add.png\"></a></li>\n";
				} else {
					$content .= "<li><a href=\"{$service['script']}\">{$service['serviceName']}</a></li>\n";
				}
			}
		}
		$content .= "</ul>\n";
		$content .= "</div>\n";
		$content .= "<div id=\"administrationMenuBottom\"></div>\n";
	  
	  
		return $content;
	  
	}

	function administrationmenu($name, $data, $pars) {
	  
		$content = "";

		#$content .= "<div id=\"administrationMenu\">\n";
		$content .= "<ul id=\"adminMenu\">\n";
	  
	  
		if (is_array($_SESSION['user']['services'])) {
			 
			foreach($_SESSION['user']['services'] as $service) {
				if ($service['visible'] == "*") {
						
						
					$items[$service['script']] = $service;
				}
			}

			$category = "";
			$first_one=false;
			foreach($items as $v) {

				if ($category != $v['category']) {



					$content .= Parser::first_comma("hiermenu", "</ul>\n</li>\n");
					$content .= "<li><strong>{$v['category']}</strong>";
					$content .= "<ul>\n";
					$category = $v['category'];
				}
	    
				if (ereg("manager", $v['script'])) {

					$content .= "<li><a href=\"{$v['script']}?action=report\">{$v['serviceName']}</a> <a href=\"{$v['script']}?action=emit\" title=\"Add\"><img src=\"img/add.png\"></a></li>\n";
				} else {
					$content .= "<li><a href=\"{$v['script']}\">{$v['serviceName']}</a></li>\n";
				}
			}
		}
		$content .= "</ul></ul>\n";
		#$content .= "</div>\n";
		#$content .= "<div id=\"administrationMenuBottom\"></div>\n";
	  
	  
		return $content;
	  
	}


}

?>
