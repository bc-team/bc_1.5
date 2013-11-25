<?php
require_once(realpath(dirname(__FILE__)) . '/../../../../include/view/widgets/FormWidget.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.view.widgets.forms
*/
class TitleField extends FormWidget {

	/**
	 * @access public
	 * @param v : values for this field in the form
	 * @param preload
	 * @ParamType v
	 * @ParamType preload
	 */
	public function build($preload) {
        if(Settings::getOperativeMode() == 'debug'){
            echo '<br />debug TitleField widget';
            var_dump($this->name);
        }
        $content = '<div class="page_heading">';
		$content .='<h1 class="text_uppercase">'.$this->name.'</h1></div>';
		return $content;
	}
}
/**
 * Factory for the checkbox widget
 * @author nicola
 *
 */

class TitleFieldFactory implements FormWidgetFactory
{
	public function create($form)
	{
		return new TitleField($form);
	}
}
?>