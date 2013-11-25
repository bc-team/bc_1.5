<?php
require_once(realpath(dirname(__FILE__)) . '/../../../../include/view/widgets/FormWidget.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.view.widgets.forms
*/
class HierarchicalPositionField extends FormWidget {

	/**
	 * @access public
	 * @param v
	 * @param preload
	 * @ParamType v
	 * @ParamType preload
	 */
	public function build($preload) {

		if($this->form->entity->loaded && $preload)
		{
			$preloadedParentId = $this->form->entity->instances[0]->getFieldValue($this->name);
			$editingId = $this->form->entity->instances[0]->getKeyFieldValue();
		}
		else
			$editingId = 0;

		/**
		 * finding presentation fields of this entity
		 */
		$presentation = $this->form->entity->getPresentation();
		$presentation = explode(", ", $presentation['fields'] );

		/**
		 * inserting an empty field in order to offer null attribute
		 */
		if($this->mandatory!=MANDATORY)
			$parents.="<option value=\"\"> Nessun padre</option>";
		
		/**
		 * retrieving other instances of the same entity in order to retrieve a list of other positions
		*/
		if($this->entity->retrieveOnly())
		{
			foreach($this->entity->instances as $instanceKey => $instance)
			{
				$key=md5(microtime())."_".$this->form->formHash;
				$text="";
				foreach($presentation as $a=>$v)
					$text=$instance->getFieldValue($v);

				if($preloadedParentId==$instance->getKeyFieldValue())
					$selected="SELECTED";
				else 
					$selected="";
				
				$parents.="<option value=\"{$instance->getKeyFieldValue()}\" {$selected}>{$text}</option>";
			} 
		}
		
		$positionSkinlet=new Skinlet("widget/HierarchicalPosition");
		$positionSkinlet->setContent("label",$this->label);
		$positionSkinlet->setContent("editing_id",$editingId);
		$positionSkinlet->setContent("entity_name",$this->form->entity->name);
		$positionSkinlet->setContent("parent_name",$this->name);
		$positionSkinlet->setContent("parents_list",$parents);
		$positionSkinlet->setContent("form_hash",$this->form->formHash);
		
		return $positionSkinlet->get();
	}
}

/**
 * Factory for the checkbox widget
 * @author nicola
 *
 */

class HierarchicalPositionFieldFactory implements FormWidgetFactory
{
	public function create($form)
	{
		return new HierarchicalPositionField($form);
	}
}
?>