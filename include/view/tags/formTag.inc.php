<?php

 Class formTag extends Tag {
 	
 	function lista($name,$data,$pars){
 		
 		
 		$x=0;
 		while ($x<count($data)) {
 			$content.="<table>";
 		 	$content.="<tr>";
 			$content.="<td colspan=2 style=\"padding-top: 20px;\" valign=\"top\">{$data[$x][0][$pars['field']]}</td>\n";
 			$content.= "<td colspan=2 style=\"padding-top: 20px;\"><table>\n";
 		
 			if (is_array($data[$x])) {
 		 		foreach ($data[$x] as $i=>$v){
 					
 					$content .= "  <tr>  <td style=\"padding-left: 10px;\">\n";
 					$content .= "<input class='clear' type=\"checkbox\" name=\"check_-{$v[$pars['field']]}_-{$v[$pars['name']]}\" value=\"{$v[$pars['value']]}\"";
 					if($v[$pars['checked']]==1) {
	 					$content .="CHECKED";
 					}
	 				$content .= "></td><td> {$v[$pars['text']]}&nbsp;&nbsp;";
 					$content .= "</td>\n";
 					$content .= "</tr>\n";			
 		 		}
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
 	
		
		 function link_list($name,$data,$pars) 
		 {
			
			if (is_array($data)) 
			{
			 $content = "<ul";
			 if(isset($pars['class']))
			 {
			   $content.=" class=\"{$pars['class']}\"";
			 }
			 $content.="><br />\n";
			 foreach($data as $id => $value) 
			  {
				 $content .= "<li>";
				 $content .= "<a href=\"rss.php?id={$value[$pars['id']]}\">{$value[$pars['text']]} ";
				 if(isset($pars['imgFo'])) $content .= "<img src=\"{$pars['imgFo']}/{$pars['image']}\">";
				 $content.="</a>";
				 if(isset($pars['descrizione']))
				 	$content .="<p>{$value[$pars['descrizione']]}</p>";
				 $content .= "</li><br />\n";	
			  }
			
				$content .= "</ul><br />\n";
			}
		
		
			return $content;
		}
		
		
	
			
	}

?>