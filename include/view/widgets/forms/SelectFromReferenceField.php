<?php
require_once(realpath(dirname(__FILE__)) . '/../../../../include/view/widgets/FormWidget.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.view.widgets.forms
*/
class SelectFromReferenceField extends FormWidget {

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
		$field_to_modify=$this->form->entity->getField($v->name);

		if($this->mandatory!=MANDATORY)
		/**
		 * if this field isn't mandatory, create an empty option
		 */
		$content.="<option value=\"\" >  </option>\n";
		
		/**
		 * retrieve the instances that has to be inserted in select options
		 */
		if($this->entity->retrieveAndLink())
			foreach($this->entity->instances as $instanceKey=>$instance)
			{
				/**
				 * not selected (default)
				 */
				$selected="";
				/**
				 * Preload check, if the entity of the main form was loaded and preload was requested
				 */
				if($this->form->entity->loaded && $preload)
				{
					/**
					 * if the entity of the main form has a field with this widget name
					 */
					if($this->form->entity->existsField($this->name))
					{
						/**
						 * if the field value of the retrieved instance of the main form entity is the same of the key of the actual instance we're considering
						 * for this option
						 */
						if($this->form->entity->instances[0]->getFieldValue($this->name)==$instance->getKeyFieldValue())
							/**
							 * mark it as selected
						*/
							$selected="SELECTED";
					}
				}
					
				/**
				 *retrieve the presentation for the entity we're considering
				 */
				$presentation = $this->entity->getPresentation();
				$presentation = explode(", ", $presentation['fields'] );
				$text="";
				foreach($presentation as $a=>$v)
					$text.=" ".$instance->getFieldValue($v);
					
					
				$content.="<option value=\"{$instance->getKeyFieldValue()}\" {$selected} > {$text} </option>\n";
			}

			$selectSkinlet=new Skinlet("widget/SelectFromReference");
			$selectSkinlet->setContent("options", $content);
			$selectSkinlet->setContent("label", $this->label);
			$selectSkinlet->setContent("name", $this->name);
			return $selectSkinlet->get();
	}
}

/**
 * Factory for the checkbox widget
 * @author nicola
 *
 */

class SelectFromReferenceFieldFactory implements FormWidgetFactory
{
	public function create($form)
	{
		return new SelectFromReferenceField($form);
	}
}
?>