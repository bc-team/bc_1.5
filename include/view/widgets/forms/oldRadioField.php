<?php
require_once(realpath(dirname(__FILE__)) . '/../../../../include/view/widgets/FormWidget.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.view.widgets.forms
 */
class RadioField extends FormWidget {

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
		if ($preload) {
		for($i=2;$i<count($v['values']);$i++) {
			$value = explode(":",$v[values][$i]);
			if ($value[1] == $field_to_modify->value) {
			$content .= "<input type=\"radio\" name=\"{$v['name']}\" value=\"{$value[1]}\" CHECKED style=\"border: 0px;\"> {$value[0]} &nbsp;&nbsp;";
			} else {
			$content .= "<input type=\"radio\" name=\"{$v['name']}\" value=\"{$value[1]}\" style=\"border: 0px;\"> {$value[0]} &nbsp;&nbsp;";
			}
			}
			} else {
			for($i=2;$i<count($v['values']);$i++) {
			$value = explode(":",$v[values][$i]);
			if ($value[2]) {
			$content .= "<input type=\"radio\" name=\"{$v['name']}\" value=\"{$value[1]}\" CHECKED  style=\"border: 0px;\"> {$value[0]} &nbsp;&nbsp;";
			} else {
			$content .= "<input type=\"radio\" name=\"{$v['name']}\" value=\"{$value[1]}\" style=\"border: 0px;\"> {$value[0]} &nbsp;&nbsp;";
			}
			}
			}
			$content .= "    </td>";
			return $content;
	}
}
/**
 * Factory for the checkbox widget
 * @author nicola
 *
 */

class RadioFieldFactory implements FormWidgetFactory
{
	public function create($form)
	{
		return new RadioField($form);
	}
}
?>