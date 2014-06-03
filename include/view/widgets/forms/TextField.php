<?php
require_once(realpath(dirname(__FILE__)) . '/../../../../include/view/widgets/FormWidget.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.view.widgets.forms
 */
class TextField extends FormWidget {

	/**
	 *
	 * (non-PHPdoc)
	 * @see FormWidget::build()
	 * @access public
	 * @param v
	 * @param preload
	 * @param entity
	 * @ParamType v
	 * @ParamType preload
	 * @ParamType entity
	 */
	public function build($preload) {
		
		$mandatory="";
		/**
		 * Mandatory text
		 */
		if ($this->mandatory==MANDATORY) {
			$mandatory = 'required';
		} 		
		
		if ($this->mainEntry == true)
		{
			$id="mainEntry";	
		}
		else{
			$id=$this->name;
		}

		/**
		 * Max length of text
		 */
		if ($this->maxlength != null){
			$maxLength = 'maxlength="'.$this->maxlength.'"';
		}
		else{
			$maxLength="";
		}

		/**
		 * See definition of $loaded attribute in entity.inc.php, it defines if data was correctly retrieved from db
		 * Deprecating the use of everywhere queries, limit use to Entity class in order to add multi-dbms support
		 */
		$value="";
		if ($preload && $this->form->entity->loaded==true)
        {
			$field_to_modify=$this->form->entity->instances[0]->getFieldValue($this->name);
			if (($this->form->entity->addslashes) && (isset($field_to_modify))){
				$value = stripslashes($field_to_modify);
			}
			else{
				$value=$field_to_modify;
            }
		}

		$widget = new Skinlet("widget/TextField");
		$widget->setContent("label", $this->label);
		$widget->setContent("name",$this->name);
		$widget->setContent("mandatory", $mandatory);
		$widget->setContent("type", $this->type);
		$widget->setContent("value", $value);
		$widget->setContent("id", $id);

		return $widget->get();
	}
}

/**
 * Factory for the checkbox widget
 * @author nicola
 *
 */

class TextFieldFactory implements FormWidgetFactory
{
	public function create($form)
	{
		return new TextField($form);
	}
}
?>