<?php
require_once(realpath(dirname(__FILE__)) . '/../../../../include/view/widgets/FormWidget.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.view.widgets.forms
 */
class PositionField extends FormWidget {

	/**
	 * @access public
	 * @param v
	 * @param preload
	 * @ParamType v 
	 * @ParamType preload 
	 */
	public function build($preload) {
		
		
		
		if($this->form->entity->loaded && preload)
		{
			$entityId=$this->form->entity->instances[0]->getFieldValue($this->name);
		}
		
		/**
		 * finding presentation fields of this entity
		 */
		$presentation = $this->form->entity->getPresentation();
		$presentation = explode(", ", $presentation['fields'] );
		
		/**
		 * retrieving other instances of the same entity in order to retrieve a list of other positions
		 */
		if($this->form->entity->retrieveOnly())
		{
			
			foreach($this->form->entity->instances as $instanceKey => $instance)
			{
				$key=md5(microtime())."_".$this->form->formHash;
				$text="";
				foreach($presentation as $a=>$v)
					$text=$instance->getFieldValue($v);
				
				$content.='<div class="child-item">
				            <span>'.$text.'</span>
				            <input type="hidden" id="'.$this->name.'_'.$key.'" name="'.$this->name.'_'.$key.'" value="'.$instance->getFieldValue($this->name).'" >  </input>
				            </div>';
				$hiddenIds.='<input type="hidden" name="'.$this->form->entity->name.'_'.$this->form->entity->fields[0]->name.'_'.$key.'" value="'.$instance->getFieldValue($this->name).'"></input>';
		}
		if(!$this->form->entity->loaded || !$preload)
		{
			$newPosition = sizeof($this->form->entity->instances)+1;
			$content.= '<div class="editing-item"> <span id="editing-item-name">Nuovo Valore</span> <input type="hidden" name="'.$this->name.'" value="'.$newPosition.'" />';
		}
		
		$positionSkinlet = new Skinlet("widget/Position");
		$positionSkinlet->setContent("label",$this->label);
		$positionSkinlet->setContent("AttributeName",$this->name);
		$positionSkinlet->setContent("AttributeValue",$entityId);
		$positionSkinlet->setContent("instances",$content);
		$positionSkinlet->setContent("ids",$hiddenIds);
		return $positionSkinlet->get();
	}
}
}

/**
 * Factory for the checkbox widget
 * @author nicola
 *
 */

class PositionFieldFactory implements FormWidgetFactory
{
	public function create($form)
	{
		return new PositionField($form);
	}
}