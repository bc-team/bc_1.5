<?php
require_once(realpath(dirname(__FILE__)) . '/../../../../include/view/widgets/FormWidget.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.view.widgets.forms
*/
class PasswordField extends FormWidget {

	/**
	 * @access public
	 * @param v
	 * @param preload
	 * @ParamType v
	 * @ParamType preload
	 */
	public function build($preload) {
// 		$content="";
// 		if (isset($this->form->helpers[$this->name])) {
// 			$content .= "    <td>{$this->label} <a href=# title=\"{$this->form->helpers[$this->name]}\"><img src=\"img/form/help.gif\"  class=\"helper\"></a> </td>\n";
// 		} else {
// 			//$content .= "<label class=\"cells\">{$this->label}</label>\n";
// 		}
// 		if ($this->maxlength) {
// 			$content .= " <input class=\"cells mb20\" type=\"{$this->type}\" name=\"{$this->name}\" size=\"{$this->size}\">\n";
// 		} else {
// 			$content .= " <input class=\"cells mb20\" type=\"{$this->type}\" name=\"{$this->name}\" size=\"{$this->size}\" maxlength=\"{$this->maxlength}\">\n";
// 		}
		
		$widget = new Skinlet("widget/PasswordField");
		$widget->setContent("label", $this->label);
		$widget->setContent("name",$this->name);
		$widget->setContent("maxlength", $this->maxlength);
		$widget->setContent("type", $this->type);
		$widget->setContent("size", $this->size);
		
		return $widget->get();
	}
}

/**
 * Factory for the checkbox widget
 * @author nicola
 *
 */

class PasswordFieldFactory implements FormWidgetFactory
{
	public function create($form)
	{
		return new PasswordField($form);
	}
}
?>