<?php
require_once(realpath(dirname(__FILE__)) . '/../../../../include/view/widgets/FormWidget.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.view.widgets.forms
 */
class SelectOldField extends FormWidget {

	/**
	 * @access public
	 * @param v
	 * @param preload
	 * @ParamType v 
	 * @ParamType preload 
	 */
	public function build($preload) {
		/**
		 * retrieving the field that has the same name of the graphic element that we're creating
		 */
		$field_to_modify=$this->form->entity->getField($v['name']);
		if (isset($this->form->helpers[$v['name']])) {
			$content .= "    <td valign=\"TOP\">{$v["label"]} <a href=# title=\"{$this->form->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
		} else {
			$content .= "    <label class=\"cells\">{$v["label"]}</label>\\n";
		}
		#$content .= "    <label class=\"cells\">{$v["label"]}</label>\\n";
		$content .= "    <td>";
		$content .= "<select class=\"becontent\" name=\"{$v['name']}\" disabled=\"disabled\" >\n";
		$content .= "<option></option>\n";
		if ($preload) {
			for($i=2;$i<count($v['values']);$i++) {
				$value = explode(":",$v[values][$i]);
				if ($_REQUEST[$v['name']] == $value[1]) {
					$content .= "<option value=\"{$value[1]}\" SELECTED> {$value[0]} </option>\n";
				} else {
					$content .= "<option value=\"{$value[1]}\" > {$value[0]} </option>\n";
				}
			}
		} else {
			for($i=2;$i<count($v['values']);$i++) {
				$value = explode(":",$v[values][$i]);
				if ($value[2]) {
					$content .= "<option value=\"{$value[1]}\" SELECTED> {$value[0]} </option>\n";
				} else {
					$content .= "<option value=\"{$value[1]}\" > {$value[0]} </option>\n";
				}
			}
		}
		$content .= "</select>\n";
		$content .= "    </td>\n";
		return $content;
	}
}
?>