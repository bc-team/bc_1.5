<?php
require_once(realpath(dirname(__FILE__)) . '/../../../../include/view/widgets/FormWidget.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.view.widgets.forms
*/
class EditorField extends FormWidget {

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
		$value="";
		
		if($this->form->entity->loaded && $preload)
		{
			$entityInstance = $this->form->entity->instances[0];
			$value = $entityInstance->getFieldValue($this->name);
		}
		
		$widget = new Skinlet("widget/EditorField");
		$widget->setContent("label", $this->label);
		$widget->setContent("name",$this->name);
		$widget->setContent("rows",$this->rows);
		$widget->setContent("cols",$this->cols);
		$widget->setContent("value",$value);
		
		return $widget->get();
	}
}

/**
 * Factory for the checkbox widget
 * @author nicola
 *
 */

class EditorFieldFactory implements FormWidgetFactory
{
	public function create($form)
	{
		return new EditorField($form);
	}
}
?>