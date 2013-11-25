<?php
require_once(realpath(dirname(__FILE__)) . '/../../../../include/view/widgets/FormWidget.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.view.widgets.forms
 */
class SelectField extends FormWidget {

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
		$content .= "    <td>";
		$content .= "<select class=\"becontent\" name=\"{$v['name']}\">\n";
		$content .= "<option></option>\n";
		if ($preload) {
			$values = explode(",", $v['values']);
			foreach($values as $k => $value) {
				$items = explode(":", $value);
				if ($field_to_modify->value == $items[1]) {
					$content .= "<option value=\"{$items[1]}\" SELECTED> {$items[0]} </option>\n";
				} else {
					$content .= "<option value=\"{$items[1]}\" > {$items[0]} </option>\n";
				}
			}
		} else {
			$values = explode(",", $v['values']);
			foreach($values as $k => $value) {
				$items = explode(":", $value);
				if ($items[2] == "CHECKED") {
					$content .= "<option value=\"{$items[1]}\" SELECTED> {$items[0]} </option>\n";
				} else {
					$content .= "<option value=\"{$items[1]}\" > {$items[0]} </option>\n";
				}
			}
		}
		$content .= "</select>\n";
		$content .= "    </td>\n";
		return $content;
	}
}

/**
 * Factory for the checkbox widget
 * @author nicola
 *
 */

class SelectFieldFactory implements FormWidgetFactory
{
	public function create($form)
	{
		return new SelectField($form);
	}
}
?>