<?php
require_once(realpath(dirname(__FILE__)) . '/../../../../include/view/widgets/FormWidget.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.view.widgets.forms
 */
class DateField extends FormWidget {

	/**
	 * @access public
	 * @param v
	 * @param preload
	 * @ParamType v 
	 * @ParamType preload 
	 */
	public function build($preload) {
        $field_to_modify = $this->form->entity->getField($this->name);

        if ($preload && $this->form->entity->loaded) {
            $dateObj =new  DateTime($this->form->entity->instances[0]->getFieldValue($this->name));
            $date = $dateObj->format("d/m/Y");
        } else {
            if ($this->mandatory == MANDATORY) {
                $date = date("d/m/Y");
            } else {
                $date = "";
            }
        }

        $widgetSkinlet = new Skinlet("widget/Date");
        $widgetSkinlet->setContent("widget",$content);
        $widgetSkinlet->setContent("label", $this->label);
        $widgetSkinlet->setContent("name", $this->name);
        $widgetSkinlet->setContent("date", $date);
        //$widgetSkinlet->setContent("disabled", $disabled);

        return $widgetSkinlet->get();
	}
}

/**
 * Factory for the date widget
 * @author dipompeodaniele@gmail.com, n.sacco.88.dev@gmail.com
 *
 */

class DateFieldFactory implements FormWidgetFactory
{
	public function create($form)
	{
		return new DateField($form);
	}
}