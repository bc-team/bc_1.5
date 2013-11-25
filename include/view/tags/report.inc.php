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

Class report extends Tag { 
	
	function injectjs() {
		
		$content = "
var backup_color;
		
function my_mouseOver(arg) {

   backup_color = arg.style.background;
   arg.style.background = '#eeeeff';
   arg.style.cursor = 'pointer';

}	

function my_mouseOut(arg) {

   arg.style.background = backup_color;

}

function my_jump(first,second) {
	window.location = '".basename($_SERVER['SCRIPT_NAME'])."?action=edit&page=1&'+first+'='+second;
}
		
";
		
		return $content;
		
		
	}

	function report2($name, $data, $pars) {
		
		
		
		$content = "<div class=\"report\">\n"; 
		
		
		$heading = true;

		if ((count($data) > 0) and ($data != '')){
			$content .= "<table cellspacing=0>\n";
			
			foreach($data as $k => $v) {
			
			
				if ($heading) {
					$heading = false;
					$content .= "<tr id=\"heading\">\n";
					foreach($v as $k1 => $v1) {
						$content .= "<th>{$k1}</th>";
					}
				} 
				
			/*
			$content .= "<tr class=\"datarow\" onClick=\"my_jump('value','{$v['value']}');\">\n";
			*/
			
				$content .= "<tr onMouseOver=\"my_mouseOver(this);\"
				              onMouseOut=\"my_mouseOut(this);\"
				              onClick=\"my_jump('value','{$v['value']}');\">\n";
		
				
				       
			          
				foreach($v as $k1 => $v1) {
					if ($k1 == "text") {
						$v1 = substr($v1,0,50);
					}
					$content .= "<td>{$v1}</td>";
				}
			
			
			
				$keys = array_keys($v);
				$keyName = $keys[0];
				$keyValue = $v[$keyName];
			
			#$content .= "<td><a href=\"".basename($_SERVER['SCRIPT_NAME'])."?page=1&{$keyName}={$keyValue}\">edit</a></td>\n";
				$content .= "</tr>\n";
			}
			$content .= "</table>\n";
		} else {
			$content .= Message::getInstance()->getMessage(MSG_REPORT_EMPTY);
		}
		
		$content .= "</div>\n";
		
		return $content;
		
	}
	
	function liveReport22($name, $entityName, $pars) {
		
		$item = new Template(Settings::getSkin()."/liveReport.html");
		
		$length = $pars['length'];
		
		$index = false;
		foreach($_SESSION['user']['services'] as $k => $v) {
			if ($v['script'] == basename($_SERVER['SCRIPT_FILENAME'])) {
				$index = $k;
				break;
			}
		}
		
		if (!$index) { 
			$item->setContent("title", "Report");
		} else {
			$item->setContent("title", $_SESSION['user']['services'][$index]['serviceName']);
		}
		
		
		$data = Parser::getResult("SELECT COUNT(*) AS count FROM {$entityName}");
		$item->setContent("length", $length);
		$item->setContent("total", $data[0]['count']);
		$item->setContent("entity", $entityName);
		$item->setContent("script", basename($_SERVER['SCRIPT_FILENAME']));
		
		return $item->get();
				
	}
	
	 
	
	function liveReport2($name, $entityName, $pars) {
		
		$item = new Template(Settings::getSkin()."/liveReport2.html");
		
		$length = $pars['length'];
		
		$index = false;
		foreach($_SESSION['user']['services'] as $k => $v) {
			if ($v['script'] == basename($_SERVER['SCRIPT_FILENAME'])) {
				$index = $k;
				break;
			}
		}
		
		if (!$index) { 
			$item->setContent("title", "Report");
		} else {
			$item->setContent("title", $_SESSION['user']['services'][$index]['serviceName']);
		}
		
		
		$data = Parser::getResult("SELECT COUNT(*) AS count FROM {$entityName}");
		
		$item->setContent("length", $length);
		$item->setContent("total", $data[0]['count']);
		$item->setContent("entity", $entityName);
		$item->setContent("script", basename($_SERVER['SCRIPT_FILENAME']));
		
		$item->setContent("query", Parser::encrypt($GLOBALS['currentform']->reportQuery));
		
		
		return $item->get();
				
	}
	
	function livereport($name, $entityName, $pars) {
		$item = new Template(Settings::getSkin()."/liveReport.html");
		
		$length = $pars['length'];
		
		$index = false;
		foreach($_SESSION['user']['services'] as $k => $v) {
			if ($v['script'] == basename($_SERVER['SCRIPT_FILENAME'])) {
				$index = $k;
				break;
			}
		}
		
		if (!$index) { 
			$item->setContent("title", "Report");
		} else {
			$item->setContent("title", $_SESSION['user']['services'][$index]['serviceName']);
		}
		
		$entity = DB::getInstance()->getEntityByName($entityName);
		
		/* echo "var dump di COUNT in report.inc <br>";
		var_dump(COUNT); */
		
		$count = $entity->getReference(COUNT);
		
		#$data = Parser::getResult("SELECT COUNT(*) AS count FROM {$entityName}");
		
		$item->setContent("length", $length);
		#$item->setContent("total", $data[0]['count']);
		$item->setContent("total", $count);
		$item->setContent("entity", $entityName);
		$item->setContent("script", basename($_SERVER['SCRIPT_FILENAME']));
		
		$item->setContent("query", Parser::encrypt($GLOBALS['currentform']->reportQuery));
		
		
		return $item->get();
				
	}
}
