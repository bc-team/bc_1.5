<?php

Class widgets extends Tag { 
	
	function injectJS() {
		
		$content = "
		
function my_updatePosition() {
		var form = document.forms['dataEntry'];
		
		var trovato;
		
		for (var i=0; i<form.position.options.length; i++) {
			if (form.position.options[i].value == 0) {
	     		trovato = i;
			}
		}
		form.position.options[trovato].text = form.name.value;
		form.position.options[trovato].value = 0;
		form.position.selectedIndex = trovato;
		
	}

	
	function my_up() {
	var form = document.forms['dataEntry'];
	
	if (form.position.selectedIndex > 0) {
		
		var text = form.position.options[form.position.selectedIndex-1].text;
		var value = form.position.options[form.position.selectedIndex-1].value;
		form.position.options[form.position.selectedIndex-1].text = 
		 	form.position.options[form.position.selectedIndex].text;
		form.position.options[form.position.selectedIndex-1].value = 
		 	form.position.options[form.position.selectedIndex].value;
		form.position.options[form.position.selectedIndex].text = text;
		form.position.options[form.position.selectedIndex].value = value;	
		form.position.selectedIndex--;
	}
	
}

function my_down() {
	var form = document.forms['DataEntry'];
	
	if (form.position.selectedIndex < form.position.options.length-1) {
		
		var text = form.position.options[form.position.selectedIndex+1].text;
		var value = form.position.options[form.position.selectedIndex+1].value;
		form.position.options[form.position.selectedIndex+1].text = 
		 	form.position.options[form.position.selectedIndex].text;
		form.position.options[form.position.selectedIndex+1].value = 
		 	form.position.options[form.position.selectedIndex].value;
		form.position.options[form.position.selectedIndex].text = text;
		form.position.options[form.position.selectedIndex].value = value;	
		form.position.selectedIndex++;
	}
}
		
";
		
		return $content;
		
		
	}
	
	
	function positionPicker($name, $data, $pars) {
		return "POSITION PICKER";
	}

	
	function link($name, $data, $pars) {
		
		if ($data['link'] != "") {
			
			return "<a href=\"{$data['link']}\">{$data['name']}</a>";
			
		} else {
			return "{$data['name']}";
		}
		
	}
	
	function listaValori($name, $data, $pars) {
		
		$content = "<input type=\"text\" name=\"{$name}\" size=\"{$pars['size']}\">\n";
		
		return $content;
	}
	
	function getPayoff($name, $data, $pars) {
	    
	    $oid = mysql_query("SELECT *
	                          FROM generaldata
	                         WHERE id = {$pars['id']}");
	    
	    $data = mysql_fetch_assoc($oid);
	    
	    return $data['payoff'];
	    
	}
}