<?php
require_once(realpath(dirname(__FILE__)) . '/../../../../include/view/widgets/FormWidget.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.view.widgets.forms
*/
class TextAreaField extends FormWidget {

	/**
	 *
	 * (non-PHPdoc)
	 * @see FormWidget::build()
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
			$content .= "    bingo<td class=\"rw-td-label\" valign=\"TOP\">{$v["label"]}</td>\n";
		}
		if ($preload) {
			if ($this->form->entity->addslashes) {
				if (isset($field_to_modify->value)) {
					$field_to_modify->value = stripslashes($field_to_modify->value);
				} else {
					$field_to_modify->value = '';
				}
			}

			if (!isset($field_to_modify->value)) {
				$content .= "    <td><textarea name=\"{$v['name']}\" cols=\"{$v['cols']}\" rows=\"{$v['rows']}\"></textarea></td>\n";
			} else {
				$content .= "   <td><textarea name=\"{$v['name']}\" cols=\"{$v['cols']}\" rows=\"{$v['rows']}\">{$field_to_modify->value}</textarea></td>\n";
			}
		} else {
			$content .= "    <td><textarea name=\"{$v['name']}\" cols=\"{$v['cols']}\" rows=\"{$v['rows']}\"></textarea></td>\n";
		}
		return $content;
	}
}

/**
 * Factory for the checkbox widget
 * @author nicola
 *
 */

class TextAreaFieldFactory implements FormWidgetFactory
{
	public function create($form)
	{
		return new TextAreaField($form);
	}
}
?>