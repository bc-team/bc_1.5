<?php
require_once(realpath(dirname(__FILE__)) . '/../../../../include/view/widgets/FormWidget.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.view.widgets.forms
 */
class ColorField extends FormWidget {

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
		$field_to_modify=$this->form->entity->getField($this->name);
		if (isset($this->form->helpers[$this->name])) {
			$content .= "    <td valign=\"top\">{$this->label} <a href=# title=\"{$this->form->helpers[$this->name]}\"><img src=\"img/form/help.gif\" class=\"helper\"></a> </td>\n";
		} else {
			$content .= "    <td valign=\"top\">{$this->label}</td>\n";
		}
		if ($preload) {
			$content .= "<input type='hidden' name='{$this->name}' value='{$field_to_modify->value}'>\n";
			$content .= "    <td valign=\"top\"><div id=\"plugin\" onmousedown=\"HSVslide('drag','plugin',event)\">
			<div id=\"plugHEX\" onmousedown=\"stop=0; setTimeout('stop=1',100);\">{$field_to_modify->value}</div>
			<div id=\"SV\" onmousedown=\"HSVslide('SVslide','plugin',event)\" title=\"Saturation + Value\">
			<div id=\"SVslide\" ><br /></div>
			</div>
			<div id=\"H\" onmousedown=\"HSVslide('Hslide','plugin',event)\" title=\"Hue\">
			<div id=\"Hslide\" style=\"TOP: -7px; LEFT: -8px;\"></div>
			<div id=\"Hmodel\"></div>
			<br/>
			<br/>
			<br/>
			</div>
			</div></td>\n";
			$content .= "<script type=\"text/javascript\"> function mkColor(v) {  }
			loadSV(); updateH('{$field_to_modify->value}');
			</script>";
		} else {
			$content .= "<input type='hidden' name='{$this->name}' value='{$this->preset}'>\n";
			$content .= "    <td valign=\"top\"><div id=\"plugin\" onmousedown=\"HSVslide('drag','plugin',event)\">
			<div id=\"plugHEX\" onmousedown=\"stop=0; setTimeout('stop=1',100);\">{$this->preset}</div>
			<div id=\"SV\" onmousedown=\"HSVslide('SVslide','plugin',event)\" title=\"Saturation + Value\">
			<div id=\"SVslide\" ><br /></div>
			</div>
			<div id=\"H\" onmousedown=\"HSVslide('Hslide','plugin',event)\" title=\"Hue\">
			<div id=\"Hslide\" style=\"TOP: -7px; LEFT: -8px;\"></div>
			<div id=\"Hmodel\"></div>
			<br/>
			<br/>
			<br/>
			</div>
			</div></td>\n";
			$content .= "<script type=\"text/javascript\"> function mkColor(v) {  }
			loadSV(); updateH('{$this->preset}');
			</script>";
		}
		return $content;
	}
}

/**
 * Factory for the color picker widget
 * @author nicola
 *
 */

class ColorFieldFactory implements FormWidgetFactory
{
	public function create($form)
	{
		return new ColorField($form);
	}
}
?>