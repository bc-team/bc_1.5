<?php
require_once(realpath(dirname(__FILE__)) . '/../../../../include/view/widgets/FormWidget.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.view.widgets.forms
 */
class CheckBoxField extends FormWidget {

	/**
	 * @access public
	 * @param preload
	 * @ParamType v 
	 * @ParamType preload 
	 */
	public function build($preload) {

		$value="";
		$checked="";
		
		if($this->form->entity->loaded && $preload)
		{
			$entityInstance=$this->form->entity->instances[0];
			$value=$entityInstance->getFieldValue($this->name);
			if($value=="*")
			{
				$checked="checked";
			}
		}
		
		$widget = new Skinlet("widget/CheckBox");
		$widget->setContent("label", $this->label);
		$widget->setContent("name",$this->name);
		$widget->setContent("value",$value);
		$widget->setContent("checked",$checked);
		
		return $widget->get();
	}
}

/**
 * Factory for the checkbox widget
 * @author nicola
 *
 */
class CheckBoxFieldFactory implements FormWidgetFactory
{
	public function create($form)
	{
		return new CheckBoxField($form);
	}
}
?>