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

 Class rss extends Tag {
 	
 	function injectStyle() {
		
		$css = new Template("include/tags/rss.css");		
		return $css->get();
		
	}
 	
 	function lista($name,$data,$pars){
 		
 		
 		$x=0;
 		while ($x<count($data)) {
 			$content.="<table>";
 		 	$content.="<tr>";
 			$content.="<td colspan=2 style=\"padding-top: 20px;\" valign=\"top\">{$data[$x][0][$pars['field']]}</td>\n";
 			$content.= "<td colspan=2 style=\"padding-top: 20px;\"><table>\n";
 		
 		 	foreach ($data[$x] as $i=>$v){
 			//print($i);
 			//print_r($v);			
 				$content .= "  <tr>  <td style=\"padding-left: 10px;\">\n";
 				$content .= "<input class='clear' type=\"checkbox\" name=\"check_-{$v[$pars['field']]}_-{$v[$pars['name']]}\" value=\"{$v[$pars['value']]}\"";
 				if($v[$pars['checked']]==1) 
 					$content .="CHECKED";
 				$content .= "></td><td> {$v[$pars['text']]}&nbsp;&nbsp;";
 				$content .= "</td>\n";
 				$content .= "</tr>\n";			
 		 	}
 		 	 $content .= "</table>\n";
 			 $content .= "</td>\n";
 		 	 $content .= "</tr>\n";
 			 $content .= "<tr>\n";
 		 	 $content .= "<td colspan=2 style=\"padding-top: 20px;\" valign=\"top\">Modality</td>\n";
 			 $content .= "<td>\n";
 		  	 $content .= "<table>\n";
 		  		   
 		  	 $message=Message::getInstance()->getMessage(MODALITY1);			
 		  	 $content.="<tr>\n";
 		  	 $content.="<td style=\"padding-left: 10px; padding-top: 20px;\">\n";
 		  	 if($data[$x][0][$pars['mod']]==MOD1)
 		  	 	$content.="<input type=\"radio\" name=\"MOD_-{$data[$x][0][$pars['field']]}\" value=\"MOD1\" CHECKED> </td><td style=\"padding-top: 20px;\">{$message}</td>\n";
 		     else
 		    	$content.="<input type=\"radio\" name=\"MOD_-{$data[$x][0][$pars['field']]}\" value=\"MOD1\"></td><td style=\"padding-top: 20px;\"> {$message}</td>\n";	
 		    		
 		     $content.="</tr>\n";
 		     $message=Message::getInstance()->getMessage(MODALITY2);
 		     $content.="<tr>\n";
 		     $content.="<td style=\"padding-left: 10px;\">\n";
 		  	 if($data[$x][0][$pars['mod']]==MOD2)
 		  		$content.="<input type=\"radio\" name=\"MOD_-{$data[$x][0][$pars['field']]}\" value=\"MOD2\" CHECKED> </td><td>{$message}</td>\n";
 		  	 else
 		    	$content.="<input type=\"radio\" name=\"MOD_-{$data[$x][0][$pars['field']]}\" value=\"MOD2\"></td><td> {$message}</td>\n";
 		     $content.="</tr>\n";
 		     $message=Message::getInstance()->getMessage(MODALITY3);
 		     $content.="<tr>\n";
 		     $content.="<td style=\"padding-left: 10px;\">\n";
 		  	 if($data[$x][0][$pars['mod']]==MOD3)
 		  		$content.="<input type=\"radio\" name=\"MOD_-{$data[$x][0][$pars['field']]}\" value=\"MOD3\" CHECKED></td><td> {$message}</td>\n";
 		  	 else
 		      	$content.="<input type=\"radio\" name=\"MOD_-{$data[$x][0][$pars['field']]}\" value=\"MOD3\"></td><td> {$message}</td>\n";	
 		    	
 		    	$content.="</tr>\n";
				$content.="</table>\n";
				$content.="</td>\n</tr>\n</table>\n";
				$content.="<br>";
 				$x++;
 		}			
    	    	
 	   
 		return $content;
		
 	}
 	
		
	function link_list($name,$data,$pars) {
			
		if (is_array($data)) {
				
			$content = "";
			foreach($data as $id => $value) {
				$content .= "<div class=\"rss\">\n";
			 	$content .= "<a href=\"rss.php?id={$value[$pars['id']]}\"><img src=\"img/rss/rss-large.gif\"></a>\n";
				$content .= "<h4>{$value[$pars['text']]}</h4>\n";
				$content .= "<p>{$value[$pars['descrizione']]}</p>\n";
				$content .= "</div>\n";
				$content .= "<div class=\"rss-bottom\"></div>";	
			}		
		}
				
		return $content;
	}
			
}

?>