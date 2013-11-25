<?php
require_once ("Form.php");

class RelationForm extends Form
{
	public $attributesNames;
	
	function edit($entity=null)
	{
		return $this->saveRelations($entity);
	}

	function add($entity=null)
	{
		return $this->saveRelations($entity);
	}

	function setAttributeLabel($attributeName,$attributeLabel)
    {
		$this->attributesNames[$attributeName]=$attributeLabel;
	}
	
	/**
	 * this method automatically executes the savings for the triggered forms during edit or add methods
	 * @param unknown_type $baseEntity
	 */
	protected function saveRelations($baseEntity)
	{
		$baseEntityPrimaryKeyName=$baseEntity->fields[0]->name;
		$baseEntityPrimaryKeyValue=$_REQUEST[$baseEntity->fields[0]->name];

		/**
		 * if the main entity was correctly updated it's time to update her relations included in the requested
		 * triggered forms (subforms).
		 */

		/**
		 * preparing update conditions, first of all the primary key of the base entity
		 */
		$values_conditions=array("{$baseEntityPrimaryKeyName}_{$baseEntity->name}"=>$baseEntityPrimaryKeyValue);

		/**
		 * after it remove all occurences of the relations , they will be reinserted
		*/
		$this->entity->delete($values_conditions);

		/**
		 * Searching for request hashtags in the scheme
		 * attributename_hash
		*/
		$hashesValues=array();
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
			$values_conditions=array("{$baseEntityPrimaryKeyName}_{$baseEntity->name}"=>$baseEntityPrimaryKeyValue);
			/**
			 * security check to prevent errors in $_REQUEST
			*/
			$doInsert=false;
			/**
			 * for every field of the entity to update
			 */
			foreach($this->entity->fields as $k=>$v)
			{	
				if($v->name!="id")
				{
					/**
					* for every element of the request
					*/
					foreach($_REQUEST as $requestKey=>$requestValue)
					{
						/**
						 * if there's an element of the request compatible with the hash and the entity field
						 */
						if (preg_match("/{$v->name}_{$hash}/",$requestKey) &&
                            !empty($v->name) && $requestValue!=null && $requestValue!=0) {
							/**
							 * add it to values conditions
							 */
							$values_conditions[$v->name]=$requestValue;
							$doInsert=true;
						}
					}
				}
			}
			/**
			 * if check is passed update the entity
			 */
			if($doInsert==true)
			{
				$this->entity->save($values_conditions);
			}
		}
	}
}