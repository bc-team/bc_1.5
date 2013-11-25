<?php

session_start();

require "include/beContent.inc.php";

require "include/auth.inc.php";

/* LOCAL START */

/* LOCAL END */

$main = new Skin("handling"); 

$form = new Form("dataEntry",$logEntity);


Class myPager extends becontentPager {
	
	function myPager() {
		beContentPager::beContentPager(19);
	}
	
	function display($k,$v) {
		switch($k) {
			case "date": 
				
				if (substr($v,0,8) == date("Ymd")) {
					return "oggi ".Parser::formatDate($v,TIME);
					
				} elseif (substr($v,0,8) == Parser::yesterday()) {
					return "ieri ".Parser::formatDate($v,TIME);
				} else {
					return Parser::formatDate($v, STANDARD)." ".Parser::formatDate($v,TIME);
				}
				break;
				
			case "link":
				if (ereg("manager", $v)) {
					return "<a href=\"{$v}\">item</a>";
				} else {
					return "";
				}
				break;
			default:
				return beContentPager::display($k,$v);
				break;
		
		}
				
		return $v;
	}	
	
	function displayItem($item) {
		
		if ($item['operation'] == 'DELETE') {
			$item['link'] = "";
		}
		
		beContentPager::displayItem($item);
		
	}
}

$pager = new myPager();
$pager->setQuery("
	SELECT logs.id,
		   logs.operation,
		   logs.entity,
		   logs.itemid,
		   logs.service,
		   logs.username,
		   logs.date,
		   logs.ip,
		   CONCAT(service,'?action=edit&page=1&value=',logs.itemid) as link
      FROM logs");

$pager->setOrder("date DESC");

if ($_SESSION['user']['admin']) {
	$pager->setFilter("(logs.username LIKE '%[search]%' OR logs.operation LIKE '%[search]%' OR logs.entity LIKE '%[search]%')");
} else {
	
	$pager->setFilter("(logs.username LIKE '%[search]%' OR logs.operation LIKE '%[search]%' OR logs.entity LIKE '%[search]%') AND logs.username = '{$_SESSION['user']['username']}'");
	#$pager->setFilter("logs.username = '{$_SESSION['user']['username']}'");
	
}
$pager->setOrder("logs.date DESC");
$pager->setTemplate( Settings::getSkin()."/report-logs.html");
$form->setPager($pager); 



$_REQUEST['action'] = "edit";
$_REQUEST['page'] = "0";


switch($_REQUEST['action']) {
	case "edit":
		$main->setContent("body",$form->editItem());
		break;
}

$main->close();

?> 