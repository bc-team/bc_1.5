<?php
require_once(realpath(dirname(__FILE__)) . '/../../../../include/view/widgets/FormWidget.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.view.widgets.forms
 */
class LinkField extends FormWidget {

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
		
		$onChange = "";
		if ($position = $this->getPositionFromController($v['name'])) {
			if ($preload) {
				$onChange = " onChange=\"my_updatePosition_preload('{$this->name}', '{$position['name']}', this, '{$this->entity->fields[0]->name}');\"";
			} else {
				$onChange = " onChange=\"my_updatePosition('{$this->name}', '{$position['name']}', this);\"";
			}
		}
		if ($v['mandatory']) {
			$mandatory = "";
		} else {
			$mandatory = "";
		}
		if (isset($this->helpers[$v['name']])) {
			$content .= "    <td>{$v["label"]} <a href=\"javascript:showHelper(this,'{$this->helpers[$v['name']]}')\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
		} else {
			$content .= "<label class=\"cells\">{$v["label"]} {$mandatory}</label>\n";
		}
		if ($preload) {
			if (($this->entity->addslashes) && (isset($field_to_modify->value))) {
				$field_to_modify->value = stripslashes($field_to_modify->value);
			}
			/* HTML ENTITIES DECODE ? */
			#$field_to_modify->value = html_entity_decode($field_to_modify->value);
			if (isset($v['maxlength'])) {
				if (!isset($field_to_modify->value)) {
					$field_to_modify->value = "";
				}
				$content .= "    <td><input type=\"{$v['type']}\" id=\"{$v['name']}\" name=\"{$v['name']}\" value=\"{$field_to_modify->value}\" size=\"{$v['size']}\" {$onChange} {$disabled}></td>\n";
			} else {
				if (!isset($field_to_modify->value)) {
					$field_to_modify->value = '';
				}
				$content .= "    <td><input type=\"{$v['type']}\" id=\"{$v['name']}\" name=\"{$v['name']}\" value=\"{$field_to_modify->value}\" size=\"{$v['size']}\" maxlength=\"{$v[maxlength]}\" {$onChange} {$disabled}></td>\n";
			}
		} else {
			if ($v['maxlength']) {
				$content .= "    <td><input type=\"{$v['type']}\" id=\"{$v['name']}\" name=\"{$v['name']}\" size=\"$v[size]\" {$onChange} {$disabled}></td>\n";
			} else {
				$content .= "    <td><input type=\"{$v['type']}\" id=\"{$v['name']}\" name=\"{$v['name']}\" size=\"{$v['size']}\" maxlength=\"{$v['maxlength']}\" {$onChange} {$disabled}></td>\n";
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

class LinkFieldFactory implements FormWidgetFactory
{
	public function create($form)
	{
		return new LinkField($form);
	}
}

?>