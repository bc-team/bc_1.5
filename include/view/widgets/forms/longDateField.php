<?php
require_once(realpath(dirname(__FILE__)) . '/../../../../include/view/widgets/FormWidget.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.view.widgets.forms
 */
class longDateField extends FormWidget {

	public $time, $date, $disabled;
	
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
		$field_to_modify = $this->form->entity->getField($this->name);

		if ($preload && $this->form->entity->loaded) {
			$dateObj =new  DateTime($this->form->entity->instances[0]->getFieldValue($this->name));
			$date = $dateObj->format("d/m/Y");
			$time = $dateObj->format("H:i");
		} else {
			if ($this->mandatory == MANDATORY) {
				$date = date("d/m/Y");
				$time= date("H:i");
			} else {
				$date = "";
				$time = "";
			}
		}

		$widgetSkinlet = new Skinlet("widget/LongDate");

		$widgetSkinlet->setContent("widget",$content);
		$widgetSkinlet->setContent("label", $this->label);
		$widgetSkinlet->setContent("name", $this->name);
		$widgetSkinlet->setContent("date", $date);
		$widgetSkinlet->setContent("time", $time);
		//$widgetSkinlet->setContent("disabled", $disabled);

		return $widgetSkinlet->get();
	}
}

/**
 * Factory for the checkbox widget
 * @author nicola
 *
 */

class LongDateFieldFactory implements FormWidgetFactory
{
	public function create($form)
	{
		return new LongDateField($form);
	}
}
?>