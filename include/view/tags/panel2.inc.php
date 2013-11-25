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

define("static",'static',false);
define("dynamic",'dynamic',false);


function first_comma($selector,$separator) {
	global $commas;

	if ($commas[$selector]) {
		return $separator;
	} else {
		$commas[$selector] = true;
		return "";
	}
}

Class panel extends Tag {

	function injectJS() {

	}

	function includeJS() {
		$file[] = "js/panel.js";

		return $file;
	}

	function injectStyle() {
		return ".panel {
		position: relative; 
		visibility: hidden; 
		display: none; 
		height: 0px;
		}";
	}


	function getTables($name,$data,$id,$value,$data_filtering) {

		if ($data_filtering == "*") {
			$result = "<select name=\"$name\" onChange=\"checkTable($id)\" style=\"width: 120px;\">";
		} else {
			$result = "<select name=\"$name\" onChange=\"checkTable($id)\" disabled style=\"width: 120px;\">";
		}
		$result .= "<option></option>";

		

		foreach($data as $k => $v) {

			if (($v["Tables_in_portale"] == $value) and ($data_filtering == "*")) {
				$result .= "<option selected>".$v["Tables_in_portale"]."</option>";
			} else {
				$result .= "<option>".$v["Tables_in_portale"]."</option>";
			}
		}



		$result .= "</select>";

		return $result;
	}

	function getFields($name,$id,$table,$key,$data,$data_filtering) {


		if (($table == "") or ($data_filtering != "*")) {

			$result = "<select name=\"$name\" disabled style=\"width: 120px;\">\n";
			$result .="<option></option>\n";
			$result .="</select>\n";

		} else {

			$result = "<select name=\"$name\" style=\"width: 120px;\">\n";

			foreach($data[$table] as $k => $v) {

				if ($v == $key) {
					$result .= "<option selected>$v</option><br>";
				} else {
					$result .= "<option>$v</option><br>";
				}

			}
			$result .= "</select>\n";
		}

		return $result;

		// return "name: $name<br>id: $id<br>table: $table<br>key: $key";
	}

	function getFieldArray($data) {

		foreach($data[fields] as $k => $v) {

			$result .= "var field_text_{$k} = Array(";

			foreach($v as $k1 => $v1) {
				$result .= first_comma($k,",")."'$v1'";

			}
			$result .= ");\n";
		}

		return $result;
	}

	function getGridStatic($name,$data,$pars) {

		if (isset($pars['name'])) {
			$widgetName = $pars['name'];
		} else {
			$widgetName = $name;
		}

		$n_gruppi = $pars['n_groups'];
		$n_servizi = $pars['n_services'];
		$n_servizi_tab = 5;							///regola il numero di colonne dedicate ai servizi per ogni riga
		$n_tab = ceil($n_servizi/$n_servizi_tab);

		$content .= "<script>\n";
		$content .= panel::getFieldArray($data);
		$content .= "</script>\n";

		$content .= "<table cellspacing=0 cellpadding=0 style=\"padding: 2px; border: 1px solid silver;\"  id=\"panel\">\n";

		for ($j=0; $j < $n_tab; $j++) {
			$i_inizio = $j*$n_servizi_tab;
			$i_fine = ($j+1)*$n_servizi_tab-1;

			if ($i_fine > $n_servizi - 1) {
				$i_fine = $n_servizi - 1;
			}

			/*
			1� riga: Elenco Servizi


			*/

			$content .= "<tr>\n"; //
			$content .= "<td></td>";

			for ($i=$i_inizio; $i<=$i_fine; $i++) {

///				$content .= "<td style=\"text-align:center; background-color: #F7FFBB; padding:3px; font-size: 11px; width: 80px;\" onMouseOver=\"panel_on(this);\" onMouseOut=\"panel_off(this);\" onClick=\"panel_click(this);\">";
///				modificata per una corretta visualizzazione con internet explorer
				$content .= "<td style=\"text-align:center; background-color: #F7FFBB; padding:3px; font-size: 11px; width: 120px;\" onMouseOver=\"panel_on(this);\" onMouseOut=\"panel_off(this);\" onClick=\"panel_click(this);\">";

				$content .= $data[$i]['service_name'];
				$content .= "</td>\n";

			}

			if ($j < $n_tab -1) {
				$content .= "</tr>\n";

			} else {

				$n_empty_items = ($j+1)*$n_servizi_tab-$i_fine-1;

				for ($i=0; $i<$n_empty_items;$i++) {
					$content .= "<td style=\"text-align:center; background-color: #F7FFBB; padding:3px; font-size: 11px; width:120px;\"></td>\n";
///					$content .= "<td style=\"text-align:center; background-color: #F7FFBB; padding:3px; font-size: 11px; width:80px;\"></td>\n";
///					modificata per una corretta visualizzazione con internet explorer
				}

				$content .= "</tr>\n";
			}

			/*

			2� riga: Data Filtering
			
			*/

			$content .= "<tr>\n";
			$content .= "<td style=\"text-align:center; background-color: #FFDDBB; padding: 3px; width: 120px; font-size: 11px;\">";
///			$content .= "<td style=\"text-align:center; background-color: #FFDDBB; padding: 3px; width: 80px; font-size: 11px;\">";
///			modificata per una corretta visualizzazione con internet explorer
			$content .="Data Filtering</td>\n";

			for($i=$i_inizio; $i<=$i_fine; $i++) {

				$content .= "<td style=\"text-align:center; background-color: #FFDDBB; width: 120px; font-size: 11px;\">";
///				$content .= "<td style=\"text-align:center; background-color: #FFDDBB; width: 70px; font-size: 11px;\">";
///				modificata per una corretta visualizzazione con internet explorer
				$content .= "<input type='checkbox' name='df_".$data[$i]['service_id']."' value='*' onClick=\"checkDF(".$data[$i]['service_id'].")\"";

				if ($data[$i]['data_filtering']=='*') {
					$content .=" checked=\"true\"";
				}
				$content .= "/>";
				$content .= "<br>\n";

				$content .= panel::getTables("table_df_".$data[$i]['service_id'],$data[tables],$data[$i]['service_id'],$data[$i]['table_entry'],$data[$i]['data_filtering'])."<br>";
				$content .= panel::getFields("key_df_".$data[$i]['service_id'],$data[$i]['service_id'],$data[$i]['table_entry'],$data[$i]['key_entry'],$data[fields],$data[$i]['data_filtering']);

				$content .= "</td>\n";
			}

			if ($j < $n_tab -1) {				
				$content .= "</tr>\n";
			} else {

				$n_empty_items = ($j+1)*$n_servizi_tab - $i_fine - 1;

				for ($i=0; $i<$n_empty_items;$i++) {
					$content .= "<td style=\"text-align:center; background-color: #FFDDBB; width: 120px; font-size: 11px;\"></td>\n";
///					$content .= "<td style=\"text-align:center; background-color: #FFDDBB; width: 70px; font-size: 11px;\"></td>\n";
///					modificata per una corretta visualizzazione con internet explorer

				}
				
				$content .= "</tr>\n";
			}

			/*

			3� riga: Checkboxes

			*/

///blocco che inserisce lo spazio rosa sotto le caselle combinate del data filtering///
			$span = $n_servizi_tab+1;
			$content .= "<tr>\n"; // 3� riga: Data Filtering Fields
			$content .= "<td style=\"background-color: #FFDDBB;\" colspan=1></td>";
			$content .= "<td style=\"text-align:center; background-color: #FFDDBB; padding: 3px; width: 120px; font-size: 11px; height: 20px;\" colspan=\"{$span}\">";
///			$content .= "<td style=\"text-align:center; background-color: #FFDDBB; padding: 3px; width: 80px; font-size: 11px; height: 50px;\" colspan=\"{$span}\">";
			$content .= "</td>";
			$content .= "</tr>\n";

			
			
			for ($k=0; $k<$n_gruppi; $k++) {
				$content .= "<tr>\n";
				$content .= "<td style=\"text-align:center; background-color: #EEEEEE; width: 70px; font-size: 11px;\">";
				$content .= $data[$k*$n_servizi]['group_name'];
				$content .= "</td>\n";

				for ($i=0; $i<$n_servizi_tab; $i++) {

					$index = $i + $k*$n_servizi +$j*($n_servizi_tab);

					if (($j == ($n_tab -1)) and ($i >= $n_servizi_tab - $n_empty_items)) {
						$content.= "<td style=\"text-align:center; background-color: white; \"></td>\n";
					} else {

						$checkid = $data[$index]["group_id"]."|".$data[$index]["service_id"];

						$content .= "<td style=\"text-align:center; background-color: white; \">";
						$content .= "<input type='checkbox' name='cb_$checkid' value='*'";

						if ($data[$index]['checked']) {
							$content .=" checked";
						}

						$content .= "/>";
						$content .= "</td>\n";
					}
				}


				$content .= "</tr>\n";


			}
		}
		$content .= "</table>\n";

		return $content;

	}



	function getGrid($name,$data,$pars) {

		switch ($pars['mode']) {
			case "dynamic":
			if (isset($pars['name'])) {
				$widgetName = $pars['name'];
			} else {
				$widgetName = $name;
			}

			$n_gruppi = $pars['n_groups'];
			$n_servizi = $pars['n_services'];
			$n_servizi_tab = 5;
			$n_tab = ceil($n_servizi/$n_servizi_tab);

			$content .= "<script>\n";
			$content .= panel::getFieldArray($data);
			$content .= "</script>\n";

			$content .= "<table height=0 cellspacing=0 cellpadding=0 style=\"height: 0px; padding: 2px; border: 1px solid silver;\"  id=\"panel\">\n";

			for ($j=0; $j < $n_tab; $j++) {
				$i_inizio = $j*$n_servizi_tab;
				$i_fine = ($j+1)*$n_servizi_tab-1;

				if ($i_fine > $n_servizi - 1) {
					$i_fine = $n_servizi - 1;
				}


				/*
				1� riga: Elenco Servizi


				*/

				$content .= "<tr>\n"; //
				$content .= "<td id=\"arrow_{$j}\" width=\"100px;\"><a href=# onClick=\"panelToggle({$j});\"><img border=0 src=\"img/down.jpg\"></a></td>";

				for ($i=$i_inizio; $i<=$i_fine; $i++) {

					$content .= "<td style=\"text-align:center; background-color: #F7FFBB; padding:3px; font-size: 11px; width: 120px; cursor: pointer;\" onClick=\"panelToggle({$j});\">";

					$content .= $data[$i]['service_name'];
					$content .= "</td>\n";

				}

				if ($j < $n_tab -1) {
					$content .= "</tr>\n";

				} else {

					$n_empty_items = ($j+1)*$n_servizi_tab - $i_fine - 1;

					for ($i=0; $i<$n_empty_items;$i++) {
						$content .= "<td style=\"text-align:center; background-color: #F7FFBB; padding:3px; font-size: 11px; width: 120px;\"></td>\n";
					}

					$content .= "</tr>\n";

				}

				/*

				2� riga: Data Filtering

				*/

				$span = $n_servizi_tab+1;
				$content .= "\n\n\n<tr id=\"row_{$j}\"><td colspan=\"$span\">\n";
				$content .= "<div id=\"panel_{$j}\" class=\"panel\">";

				$content .= "<table  width=\"100%\"cellspacing=0 cellpadding=0>\n";

				$content .= "<tr>\n";
				$content .= "<td style=\"text-align:center; background-color: #FFDDBB; padding: 3px; width: 80px; font-size: 11px;\">";
				$content .="Data Filtering</td>\n";

				for($i=$i_inizio; $i<=$i_fine; $i++) {

					$content .= "<td style=\"text-align:center; background-color: #FFDDBB; width: 120px; font-size: 11px;\">";
					$content .= "<input type='checkbox' name='df_".$data[$i]['service_id']."' value='*' onClick=\"checkDF(".$data[$i]['service_id'].")\"";

					if ($data[$i]['data_filtering']=='*') {
						$content .=" checked=\"true\"";
					}
					$content .= "/>";
					$content .= "<br>\n";

					$content .= panel::getTables("table_df_".$data[$i]['service_id'],$data[tables],$data[$i]['service_id'],$data[$i]['table_entry'],$data[$i]['data_filtering'])."<br>";
					$content .= panel::getFields("key_df_".$data[$i]['service_id'],$data[$i]['service_id'],$data[$i]['table_entry'],$data[$i]['key_entry'],$data[fields],$data[$i]['data_filtering']);

					$content .= "</td>\n";
				}


				if ($j < $n_tab -1) {
					$content .= "</tr>\n";

				} else {

					$n_empty_items = ($j+1)*$n_servizi_tab - $i_fine - 1;

					for ($i=0; $i<$n_empty_items;$i++) {
						$content .= "<td style=\"text-align:center; background-color: #FFDDBB; width: 120px; font-size: 11px;\"></td>\n";
					}

					$content .= "</tr>\n";

				}


				/*

				3� riga: Checkboxes

				*/






				$content .= "<tr>\n"; // 3� riga: Data Filtering Fields
				$content .= "<td style=\"background-color: #FFDDBB;\" colspan=1></td>";
				$content .= "<td style=\"text-align:center; background-color: #FFDDBB; padding: 3px; width: 80px; font-size: 11px; height: 50px;\" colspan=\"{$span}\">";
				$content .= "</td>";
				$content .= "</tr>\n";




				for ($k=0; $k<$n_gruppi; $k++) {
					$content .= "<tr>\n";
					$content .= "<td style=\"text-align:center; background-color: #EEEEEE; width: 100px; font-size: 11px;\">";
					$content .= "<a href=\"edit-group.php?id=".$data[$k*$n_servizi]['group_id']."\">".$data[$k*$n_servizi]['group_name']."</a>";
					$content .= "</td>\n";

					for ($i=0; $i<$n_servizi_tab; $i++) {

						//$index = $k*$n_servizi + $j*($n_servizi-$n_servizi_tab) + $i;
						//$index = $k*($n_servizi-$n_servizi_tab) + $j*($n_servizi-1) + $i;

						$index = $i + $k*$n_servizi +$j*($n_servizi_tab);

						if (($j == ($n_tab -1)) and ($i >= $n_servizi_tab - $n_empty_items)) {

							$content.= "<td style=\"text-align:center; background-color: white; width: 70px;\"></td>\n";
						} else {

							$checkid = $data[$index]["group_id"]."|".$data[$index]["service_id"];

							$content .= "<td style=\"text-align:center; background-color: white; width: 70px;\">";
							$content .= "<input type='checkbox' name='cb_$checkid' value='*'";

							if ($data[$index]['checked']) {
								$content .=" checked";
							}

							$content .= "/>";
							$content .= "</td>\n";
						}
					}


					$content .= "</tr>\n";



				}
				$content .= "</table></div></td></tr>\n\n\n";
			}


			$content .= "</table>\n";

			return $content;
			break;
			default:
			
			return panel::getGridStatic($name,$data,$pars);	
			           
			
			break;

		}



	}

}

?>