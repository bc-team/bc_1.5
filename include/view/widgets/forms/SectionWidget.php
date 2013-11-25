<?php
require_once(realpath(dirname(__FILE__)) . '/../../../../include/view/widgets/FormWidget.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.view.widgets.forms
*/
class SectionField extends FormWidget {

	/**
	 * @access public
	 * @param v : values for this field in the form
	 * @param preload
	 * @ParamType v
	 * @ParamType preload
	 */
	public function build($preload) {
		$content = '<!--section widget--><div class="title-section">'.$this->name.'</div>';
		return $content;
	}
}
/**
 * Factory for the checkbox widget
 * @author nicola
 *
 */

class SectionFieldFactory implements FormWidgetFactory
{
	public function create($form)
	{
		return new SectionField($form);
	}
}
?>