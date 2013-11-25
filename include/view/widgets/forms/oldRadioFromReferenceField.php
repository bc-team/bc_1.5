<?php
require_once(realpath(dirname(__FILE__)) . '/../../../../include/view/widgets/FormWidget.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.view.widgets.forms
 */
class RadioFromReferenceField extends FormWidget {

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
		unset($data);
		if (isset($v['condition'])) {
			$data = $v["entity"]->getReferenceWithCondition($v['condition']);
		} else {
			$data = $v["entity"]->getReference();
		}
		$content .= "<label class=\"cells\">{$v["label"]} </label>";
		if (isset($this->form->helpers[$v['name']])) {
			$content .= "<a href=# title=\"{$this->form->helpers[$v['name']]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> ";
		}
		for($i=0;$i<count($data);$i++) {
			if ($preload) {
				if ($field_to_modify->value == $data[$i]['value']) {
					$content .= "      <input type=\"radio\" name=\"{$v['name']}\" value=\"{$data[$i]["value"]}\" CHECKED> {$data[$i]["text"]} &nbsp;&nbsp;>\n";
				} else {
					$content .= " <input type=\"radio\" name=\"{$v['name']}\" value=\"{$data[$i]["value"]}\"> {$data[$i]["text"]} &nbsp;&nbsp;\n";
				}
			} else {
				if (($v['mandatory'] == "yes") and ($i == 0)) {
					$content .= "      <input type=\"radio\" name=\"{$v['name']}\" value=\"{$data[$i]["value"]}\" CHECKED> {$data[$i]["text"]} &nbsp;&nbsp;<br/>\n";
				} else {
					$content .= "<input type=\"radio\" name=\"{$v['name']}\" value=\"{$data[$i]["value"]}\" > {$data[$i]["text"]} &nbsp;&nbsp;\n";
				}
			}
		}
		return $content;
	}
}

/**
 * Factory for the checkbox widget
 * @author nicola
 *
 */

class RadioFromReferenceFieldFactory implements FormWidgetFactory
{
	public function create($form)
	{
		return new RadioFromReferenceField($form);
	}
}
?>