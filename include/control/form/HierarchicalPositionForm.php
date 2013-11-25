<?php
require_once ("Form.php");
class HierarchicalPositionForm extends Form
{
	
	function addHierarchicalPosition($name, $label, $mandatory = "off",$entity=null)
	{
		$factory=new HierarchicalPositionFieldFactory();
		$newField=$factory->create($this);

		$newField->name= $name;
		$newField->type = "hierarchicalPosition";
		$newField->label = $label;
		$newField->mandatory = $mandatory;
		$newField->entity=$entity;
		$this->elements[] = $newField;
	}
	
	function edit($entity=null)
	{
		$this->updatePositions($entity);
	}

	function add($entity=null)
	{
		$this->updatePositions($entity);
	}
	
	private function updatePositions($entity)
	{
		
		/**
		 * if the main entity was correctly updated it's time to update her relations included in the requested
		 * triggered forms (subforms).
		 */
		
		/**
		 * Searching for request hashtags in the scheme
		 * attributename_hash
		*/
		$hashesValues = array();
		foreach($this->entity->fields as $k=>$v)
		{
			foreach($_REQUEST as $requestKey=>$requestValue)
			{
				if (ereg("{$v->name}_",$requestKey) && ereg("{$this->formHash}",$requestKey)) {
					$hash=preg_replace("/{$v->name}_/","",$requestKey);
					if(!in_array($hash,$hashesValues))
					{
						$hashesValues[]=$hash;
					}
				}
			}
		}
		
		/**
		 * for every found hashtag we have a relation to update
		 */
		foreach($hashesValues as $k=>$hash)
		{
			/**
			 * preparing update value conditions, first of all the primary key of the base entity
			 */
			$values_conditions=array();
			$where_conditions=array();
		
			
			/**
			 * for every field of the entity to update
			 */
			foreach($this->entity->fields as $k=>$v)
			{	/**
				* for every element of the request
				*/
				foreach($_REQUEST as $requestKey=>$requestValue)
				{
					/**
					 * if there's an element of the request compatible with the hash and the entity field
					 */
					if (preg_match("/{$v->name}_{$hash}/",$requestKey)&&!empty($v->name)) {
						/**
						 * add it to values conditions
						 */
						if($v->name==$this->entity->fields[0]->name)
							$where_conditions[$v->name]=$requestValue;
						else
							$values_conditions[$v->name]=$requestValue;
						
						
		
					}
				}
			}
			
			/**
			 * if check is passed update the entity
			 */
			if(sizeof($where_conditions)>0 && sizeof($values_conditions)>0)
			{
				$this->entity->update($where_conditions,$values_conditions);
			}
		}
	}
}
?>