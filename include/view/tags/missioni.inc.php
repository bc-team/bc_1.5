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


Class missioni extends Tag {
	
	
	
	function injectStyle() {
		
		#$css = new Template("include/tags/becontent-tags.css");		
		#return $css->get();
		
	}
	
	function check($name, $data, $pars) {
		
		switch ($name) {
			case "missioni_proprietariomezzoaltrui":
			case "missioni_categoria":
			case "missioni_capitolo":
			case "missioni_fondi":
				
				if ($data != "") {
					return $data;
				} else {
					return "____________";
				}
			break;
			case "missioni_mezzo_aereo":
			case "missioni_mezzo_altrui":
			case "missioni_mezzo_ordinario":
			case "missioni_mezzo_proprio":
				
				if ($data != "") {
					return "X";
				} else {
					return " ";
				}
				break;
			
			case "missioni_stato_direttore":
			case "missioni_stato_responsabilefondi":
				
				switch ($data) {
					case 1:
						return "";
						break;
					case 2:
						return "*non* ";
						break;
				}
				break;
			
		}
		
		
	}
	
	
	
}

?>