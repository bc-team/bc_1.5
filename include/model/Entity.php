<?php
require_once(realpath(dirname(__FILE__)) . '/../../include/model/baseType.php');
require_once(realpath(dirname(__FILE__)) . '/../../include/model/Instance.php');
require_once(realpath(dirname(__FILE__)) . '/../../include/settings.inc.php');
require_once(realpath(dirname(__FILE__)) . '/../../include/view/template/createTemplate.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.model
*/
class Entity {
	public $fieldRepository;
	public $database;
	public $name;
	public $lastFieldIndex;
	public $presentation;
	public $standardKey;
	public $noKey;
	public $owner;
	public $addslashes;
	public $reload;
	public $referredBy;
	public $relations;
	public $positions;
	public $filterRelation;
	public $referenceOrder;
	public $rss;
	public $rssPresentation;
	public $rssFilter;
	public $searchFields;
	public $searchRelations;
	public $searchHead;
	public $searchBody;
	public $searchHandler;
	public $comments;
	public $moderated = true;
	public $debugmode = false;
	public $loaded = false;
	public $instances;
	public $indexedInstances;
	public $entityName;
	public $occurrences;
	public $searchTextScript;

	/**
	 * @AssociationType include.model.baseType
	 * @AssociationKind Aggregation
	 */
	public $fields;

	/**
	 * @access public
	 * @param database
	 * @param name
	 * @param owner
	 * @ParamType database
	 * @ParamType name
	 * @ParamType owner
	 */
	public function __construct($database, $name, $owner = "") {
		global
		$entitiesEntity;

		/**
		 * the preset of entityName is required in order to apply inheritance
		 */
		if(empty($this->entityName))
		{
			$this->entityName=$name;
		}


		$this->owner = ($owner == WITH_OWNER);
		$this->addslashes = (!get_magic_quotes_gpc());
		$this->database = $database;
		$this->name = $name;
		$this->standardKey = true;
		$this->noKey = false;
		$this->reload = false;
		$this->referenceOrder = false;
		$this->fields[0] = TypeBuilder::getInstance()->create("id", "ID", false, true, 0, true);

		/**
		 * ownership relationship
		*/
		if ($this->owner) {
			$this->addReference($GLOBALS['usersEntity'], "owner");
		}

		$GLOBALS[$this->entityName] = $this;
		$this->moderated = true;
	}

	/**
	 *
	 * This method is the responsible of the saving in the database of a new entity
	 * All fields values has to be written in the $query_conditions with the scheme
	 * "attribute_name"=>"attribute_value"
	 *
	 * @access public
	 * @param query_conditions
	 * @ParamType query_conditions
	 */
	public function save($query_conditions)
    {
		$uniqueIdForNames=md5(uniqid(mt_rand()));
		$uniqueIdForValues=md5(uniqid(mt_rand()));
		$query="INSERT INTO {$this->name}";
		$field_names_subquery=" ("; // parameters list
		$field_values_subquery=" VALUES ("; // values list
		if($query_conditions!=null)
		{
			if(sizeof($query_conditions)>0)
			{
				foreach($query_conditions as $k=>$v)
				{
					if($this->existsField($k))
					{
						$field=$this->getField($k);
						$field->value=$v;
						$field_names_subquery.=Parser::first_comma($uniqueIdForNames,", ")."{$field->name}";
						$field_values_subquery.=$field->save($uniqueIdForValues);
					}
				}
			}
		}
		$field_names_subquery.=")";
		$field_values_subquery.=")";
		$query.=$field_names_subquery.$field_values_subquery.";";



        if(Settings::getOperativeMode() == 'debug')  {
            echo '<br /><br />method save in Entity: ';
            echo'<br />var_dump query <br>';
            var_dump($query);
            echo'<br />var_dump query_condition '.$this->name.'<br>';
            var_dump($query_conditions);
        }

		$oid = mysql_query($query);

		$last_created_conditions=array();

		if(isset($query_conditions[$this->fields[0]->name]))
			$last_created_conditions[$this->fields[0]->name]=$query_conditions[$this->fields[0]->name];
		else
			$last_created_conditions[$this->fields[0]->name]=mysql_insert_id();

		$this->retrieveOnly($last_created_conditions);


		return $oid;
	}

	public function search($search_conditions=null, $join_entities=null, $order_conditions=null, $limit_condition=null)
	{
		unset($this->instances);
		unset($this->indexedInstances);
			
		$this->loaded=false;
		$query=$this->generateSelectQuery(null, $join_entities, $order_conditions, $limit_condition,"OR");
			
			
		if($this->debugmode)
			echo "Entity::retrieve ". $query. " for ".$this->name;
			
		$oid = mysql_query($query);
		if (!$oid) {
			echo Message::getInstance()->getMessage(MSG_ERROR_DATABASE_QUERY)." {$this->name} at line ",__LINE__;
			echo "<hr>", $query;
			exit;
		}
			
			
		while($query_result=mysql_fetch_array($oid,MYSQL_ASSOC))
		{
			$this->buildInstance($query_result);
			if(isset($join_entities))
			{
				foreach($join_entities as $k=>$v)
				{
					$v->buildInstance($query_result);
				}
			}
		}
			
			
		foreach($this->instances as $k=>$instance)
		{
			$instanceIsCorrect=true;
			$conditionWasSatisfied=false;
			foreach($search_conditions as $kwKey=>$keyword)
			{
				$conditionWasSatisfied=false;
				foreach($this->searchFields["TEXT"] as $fieldKey=>$fieldName)
				{
					$keyword=strtolower($keyword);
					$testingValue=strtolower($instance->getFieldValue($fieldName));
					
					if(preg_match("/({$keyword})/i",$testingValue))
					{
						$conditionWasSatisfied=true;
					}
				}
				if(!$conditionWasSatisfied)
				{
					$instanceIsCorrect=false;
				}
			}
			if(!$instanceIsCorrect)
				unset($this->instances[$k]);

		}
			
		return $this->loaded;
	}
	/**
	 *
	 * This method retrieves one or more entities according to the conditions passed through parameters
	 * with the scheme
	 *
	 * * $where_conditions
	 *
	 * * "attribute_clause"=>"attribute_desired_value"
	 *
	 * * means
	 *
	 * * where attribute_clause = attribute_desired_value
	 *
	 * ****************************************************
	 *
	 * * $join_conditions
	 *
	 * * "joint_entity_index"=>"join_entity_name"
	 *
	 * * means
	 * for example "1"=>$entity_a,"2"=>$entity_b
	 *
	 * * .... JOIN {$entity_a->name} as entity_a1 ON ... ...JOIN {$entity_b->name} as entity_b2 ON....
	 *
	 * ****************************************************
	 *
	 * * $order_conditions
	 *
	 * * "order_condition_index"=>"order_condition_name"
	 *
	 * * means
	 * for example "1"=>"name","2"=>"surname"
	 *
	 * * .... ORDER BY name , surname
	 *
	 * *****************************************************
	 *
	 *
	 *
	 *
	 *
	 * @access public
	 * @param where_conditions
	 * @param join_entities
	 * @param order_conditions
	 * @param limit_condition
	 * @ParamType where_conditions
	 * @ParamType join_entities
	 * @ParamType order_conditions
	 * @ParamType limit_condition
	 */
	public function retrieveAndLink($where_conditions=null, $join_entities=null, $order_conditions=null, $limit_condition=null) {

		$this->retrieveOnly($where_conditions, $join_entities, $order_conditions, $limit_condition);

		$this->linkInstances($join_entities);

		if(isset($join_entities))
		{
			foreach($join_entities as $k=>$v)
			{
				$v->linkInstances($join_entities);
			}
		}
		return $this->loaded;
	}

	/**
	 *
	 * @param unknown_type $where_conditions
	 * @param unknown_type $join_entities
	 * @param unknown_type $order_conditions
	 * @param unknown_type $limit_condition
	 */
	public function retrieveOnly($where_conditions=null, $join_entities=null, $order_conditions=null, $limit_condition=null) {

		unset($this->instances);
		unset($this->indexedInstances);

		$this->loaded=false;
		$query=$this->generateSelectQuery($where_conditions, $join_entities, $order_conditions, $limit_condition);


		if($this->debugmode)
			echo "Entity::retrieve ". $query. " for ".$this->name;

		$oid = mysql_query($query);
		if (!$oid) {
			echo Message::getInstance()->getMessage(MSG_ERROR_DATABASE_QUERY)." {$this->name} at line ",__LINE__;
			echo "<hr>", $query;
			exit;
		}


		while($query_result=mysql_fetch_array($oid,MYSQL_ASSOC))
		{
			$this->buildInstance($query_result);
			if(isset($join_entities))
			{
				foreach($join_entities as $k=>$v)
				{
					$v->buildInstance($query_result);
				}
			}
		}

		return $this->loaded;
	}

	/**
	 * this method is used to filter results in query_result in order to recognize
	 * postfixes and occurrences of this entity in query_result
	 * @param unknown $query_result
	 */
	private function filterQueryResult($query_result)
	{
		$this->occurrences=array();
		foreach($query_result as $k=>$value)
		{
			if(preg_match("/({$this->name})([0-9]*)\_([\w]+)/",$k,$matches))
			{
				$this->occurences[]=$this->name.$matches[2]."_";
			}
		}
	}

	/**
	 * Construct an instance of an entity with no deep linking
	 *
	 * Observation, maximum consumption o(n*2*n)
	 * @param unknown $query_result
	 */
	protected function buildInstance($query_result)
	{
		/**
		 * Finds all occurrences of this entity in query result
		 */
		$this->filterQueryResult($query_result);
			
		foreach($this->occurences as $occurrenceNumber=>$occurrenceHash)
		{

			/**
			 * suppose that the instance wasn't yet created
			 * @var unknown_type
			 */
			$instanceExists=false;
				
			/**
			 * Search for an instance with key equal to query_result value
			 */
			if(isset($query_result[$occurrenceHash.$this->fields[0]->name]))
			{
				$instanceKeyValue=$query_result[$occurrenceHash.$this->fields[0]->name];
					
				if(isset($this->instances) && isset($this->indexedInstances[$instanceKeyValue]))
					$instanceExists=true;
			}
			/**
			 * if instance doesn't exists and the key field in query result is different from null
			 * then build an instance
			 */
			if(!$instanceExists && isset($query_result[$occurrenceHash.$this->fields[0]->name]))
			{
				$entityInstance=new Instance($this);
					
				foreach($this->fields as $fieldKey=>$field)
				{
					if(isset($query_result[$occurrenceHash.$field->name]))
					{
						$entityInstance->setFieldValue($field->name,$query_result[$occurrenceHash.$field->name]);
					}
				}

				$presentation = $this->getPresentation();
				$presentation = explode(", ", $presentation['fields'] );
				$text="";

				foreach($presentation as $a=>$v)
					$text.=" ".$entityInstance->getFieldValue($v);

				$entityInstance->presentation=$text;

				$this->instances[]=$entityInstance;
				$this->indexedInstances[$entityInstance->getKeyFieldValue()]=$entityInstance;
			}
				
			$this->loaded=true;

		}

	}


	/**
	 *
	 * @param unknown_type $instanceKey
	 */
	public function getInstance($instanceKey)
	{
		$turnback=null;
		if(isset($this->indexedInstances[$instanceKey]))
			$turnback= $this->indexedInstances[$instanceKey];
		return $turnback;
	}

	/**
	 * Performs a deep linking between retrieved instances
	 * @param unknown $join_entities
	 */
	protected function linkInstances($join_entities)
	{
		if(isset($this->instances))
		{
			foreach($this->instances as $instanceKey=>$instance)
				$instance->link();
		}
	}

	/**
	 *
	 * This method is responsible for the generation of the query
	 *
	 *
	 *
	 *
	 *
	 *
	 * Manual:
	 * * * $where_conditions
	 *
	 * * "attribute_clause"=>"attribute_desired_value"
	 *
	 * * means
	 *
	 * * where attribute_clause = attribute_desired_value
	 *
	 * ****************************************************
	 *
	 * * $join_conditions
	 *
	 * * "joint_entity_index"=>"join_entity_name"
	 *
	 * * means
	 * for example "1"=>$entity_a,"2"=>$entity_b
	 *
	 * * SELECT ... FROM $this->name ..... JOIN {$entity_a->name} as entity_a1 ON ... ...JOIN {$entity_b->name} as entity_b2 ON....
	 *
	 * ****************************************************
	 *
	 * * $order_conditions
	 *
	 * * "order_condition_index"=>"order_condition_name"
	 *
	 * * means
	 * for example "1"=>"name","2"=>"surname"
	 *
	 * * .... ORDER BY name , surname
	 *
	 * *****************************************************
	 *
	 * @access public
	 * @param where_conditions
	 * @param join_entities
	 * @param order_conditions
	 * @param limit_condition
	 * @ParamType where_conditions
	 * @ParamType join_entities
	 * @ParamType order_conditions
	 * @ParamType limit_condition
	 */
	public function generateSelectQuery($where_conditions, $join_entities=null, $order_conditions=null, $limit_condition=null,$conditionType="AND") {

		$select_clause="";
		$join_clause="";
		$where_clause="";
		$order_clause="";
		$limit_clause="";


		$select_clause="SELECT {$this->selectGenerator($join_entities)} FROM {$this->name}";

		if(isset($order_conditions))
			$order_clause.=" ".$this->orderGenerator($order_conditions,$join_entities);

		if(isset($limit_condition))
			$limit_clause.=" ".$this->limitGenerator($limit_condition);


		if(isset($join_entities))
			$join_clause.=" ".$this->joinGenerator($join_entities);



		if($where_conditions!=null)
		{
			$postfix;
			$where_clause="";
			$uniqueId=md5(uniqid(mt_rand()));
			if(sizeof($where_conditions)>0)
			{
				/**
				 * search for compatible conditions in $this entity
				 */
				foreach($where_conditions as $k=>$v)
				{
					if($this->existsField($k))
					{
						$where_clause.=$this->getField($k)->generateSelectQueryPart($v,$this->name,$uniqueId,"",$conditionType);
						unset($where_conditions[$k]);
					}
				}
				/**
				 * search for compatible conditions in actually joining entities
				 */

				if(isset($join_entities))
				{


					$i=0;
					foreach($join_entities as $entitykey=>$entity)
					{
						$postfix = $i;
						foreach($where_conditions as $k=>$v)
						{
							$converted_field=preg_replace("/({$entity->name})([0-9]*)\_/", "", $k);
							if($entity->existsField($converted_field))
							{
								preg_match("/({$entity->name})([0-9]*)\_([\w]+)/",$k,$matches);
								$where_clause.=$entity->getField($converted_field)->generateSelectQueryPart($v,$entity->name.$matches[2],$uniqueId,$postfix,$conditionType);
								unset($where_conditions[$k]);
							}
						}
						$i++;
					}
				}
			}
			if(!empty($where_clause))
				$where_clause=" WHERE ".$where_clause;
		}


		/**
		 * compiling query
		 */
		$query=$select_clause.$join_clause.$where_clause.$order_clause.$limit_clause.";";

		if($this->debugmode)
			echo "Entity::generateSelectQuery for {$this->name}<br>".$query."<br>";


		return $query;
	}

	/**
	 *
	 * This method is responsible for the generation of the select clause in the query
	 * it's used to convert fields in template-compatible namespace
	 *
	 * @access private
	 * @param join_entities
	 * @ParamType join_entities
	 */
	private function selectGenerator($join_entities=null) {
		$id = md5(uniqid(mt_rand()));
		$select_clause="";
		$notChecked=false;
		foreach($this->fields as $k=>$value)
		{
			$select_clause.=Parser::first_comma($id, ", ")."{$this->name}.{$value->name} AS {$this->name}_{$value->name}";
		}
		if(isset($join_entities))
			foreach($join_entities as $entity_key=>$entity )
			foreach($entity->fields as $k=>$value)
			{
				$select_clause.=Parser::first_comma($id, ", ")."{$entity->name}{$entity_key}.{$value->name} AS {$entity->name}{$entity_key}_{$value->name}";
			}
			return $select_clause;
	}

	/**
	 *
	 * This method is responsible for the generation of the limit clause in the query
	 *
	 * @access private
	 * @param limit_condition
	 * @ParamType limit_condition
	 */
	private function limitGenerator($limit_condition) {
		if ($limit_condition) {
			$limit_clause = "LIMIT {$limit_condition}";
		} else {
			$limit_clause = "";
		}
		return $limit_clause;
	}

	/**
	 *
	 * This method is responsible for the generation of the order clause in the query
	 *
	 * @access private
	 * @param order_conditions
	 * @ParamType order_conditions
     *
	 */
	private function orderGenerator($order_conditions,$join_entities) {
		$id = md5(uniqid(mt_rand()));
		$order_clause = "";

        if($this->debugmode){
            echo '<br />Entity->orderGenerator: ';
            var_dump($order_conditions);
        }

		if (count($order_conditions) > 0) {

			foreach($order_conditions as $k=>$v) {


				$addCondition=false;


				if(preg_match("/ DESC/",$v))
				{
					$direction="DESC";
					$v=preg_replace("/ DESC/", "", $v);
				}
				else
				{
					$direction="";
				}

				$filteredKey=preg_replace("/{$this->name}./", "", $v);

                if($this->debugmode){
                    echo '<br />filteredKey';
                    var_dump($filteredKey);
                }

				if($this->existsField($filteredKey))
				{
					$addCondition=true;
					$entityName=$this->name;
				}
				else
				{
					foreach($join_entities as $entityKey=>$entity)
					{
						$filteredKey=preg_replace("/({$entity->name})([0-9]*)\_/", "", $v);
						if($entity->existsField($filteredKey))
						{
							$addCondition=true;
							$entityName=$entity->name."{$entityKey}";
						}
					}
				}

				if($addCondition)
					$order_clause .= Parser::first_comma($id, ", ")."{$entityName}.{$filteredKey} {$direction}";
                if($this->debugmode){
                    echo '<br />Entity->orderGenerator $order_clause: ';
                    var_dump($addCondition);
                }

			}
		}
		if($addCondition)
			$order_clause="ORDER BY ".$order_clause;
		else
			$order_clause="";
		return $order_clause;
	}

	/**
	 *
	 * This method is responsible for the generation of the autonavigating join clause of the query
	 *
	 * @access private
	 * @param join_entities
	 * @ParamType join_entities
	 */
	private function joinGenerator($join_entities) {
		$join_clause="";
		/**
		 * Every foreach iteration has an entity that you're considering in the join navigation
		 * @var unknown_type
		 */
		$actual_entity;
		/**
		 * Every foreach iteration has an entity that was the last one considered in the join navigation
		 * initialized to $this entity, the starting point of the join
		 */
		$last_entity=$this;
		if (count($join_entities) > 0)
		{
			foreach($join_entities as $k=>$actual)
			{
				$actual_entity=$actual;
				/**
				 * Postfix for duplicated entities in join navigation
				 *
				 */

				$postfix=$k;
				$postfix_string="{$k}";
				$last_postfix_string="";
				/**
				 * Last Postfix , in order to retrieve last postfix
				 */
				if($k>0)
				{
					$last_postfix=$k-1;
					$last_postfix_string="{$last_postfix}";
				}
				else
					$last_postfix="";
				/**
				 * First of all recognize the foreign key
				 */
				$foreign_key = "";
					
				/**
				 * First of all, we are trying to join two entities,
				 * trying to find, in the last joined entity, an attribute refered to the actual joining entity
				 * @var unknown_type
				 */
				$check=false;
				foreach ($actual_entity->fields as $v) {

					if(isset($v->reference))
						if ($v->reference->name == $last_entity->name)
						{
							/**
							 * An attribute has been found so we add a JOIN CLAUSE
							 * @var unknown_type
							 */
							$check=true;
							$join_clause .= " LEFT JOIN {$actual_entity->name} ";
								


							$join_clause .= "AS {$actual_entity->name}{$postfix_string} ";

								
							$foreign_key = $v;
							$join_clause .= "ON {$actual_entity->name}{$postfix_string}.{$foreign_key->name}={$last_entity->name}{$last_postfix_string}.{$last_entity->fields[0]->name}";
						}
				}
				/**
				 * In the case that no compatible attributes were found we try to find, in the actual joining entity, an attribute refered to the last joined entity
				 * navigating the relation in the other side
				 */
				if($check==false)
				{
					foreach ($last_entity->fields as $v) {

						if(isset($v->reference))
							if ($v->reference->name == $actual_entity->name)
							{
								/**
								 * An attribute has been found so we add a JOIN CLAUSE
								 * @var unknown_type
								 */

								$join_clause .= " LEFT JOIN {$actual_entity->name} ";

								$join_clause .= "AS {$actual_entity->name}{$postfix_string} ";

								$foreign_key = $v;
								$join_clause .= "ON {$last_entity->name}{$last_postfix_string}.{$foreign_key->name}={$actual_entity->name}{$postfix_string}.{$actual_entity->fields[0]->name}";
							}
					}
				}
				/**
				 * switching to the next couple
				 */
				unset ($last_entity);
				$last_entity=$actual_entity;
			}
		}
		/**
		 * returning the join clause in order to put it in a query
		 */
		return $join_clause;
	}

	/**
	 *
	 * this method is responsible to update parameters of an entity
	 *
	 *
	 * @access public
	 * @param where_conditions
	 * @param set_parameters
	 * @ParamType where_conditions
	 * @ParamType set_parameters
	 */
	public function update($where_conditions, $set_parameters) {

        if(Settings::getOperativeMode() == 'release')
        {
            echo '<br> Entity->update var_dump set_parameters<br>';
            var_dump($set_parameters);
        }

		$query="UPDATE {$this->name}";
		$set_clause="";
		$where_clause="";
		$set_check=false;
		$setId = md5(uniqid(mt_rand()));
		foreach($set_parameters as $k=>$v)
		{
			if($this->existsField($k))
			{
				$set_clause.=$this->getField($k)->update($setId,$v);
				$set_check=true;
			}
		}
		$whereId= md5(uniqid(mt_rand()));
		$where_check=false;
		foreach($where_conditions as $k=>$v)
		{
			if($this->existsField($k))
			{
				$where_clause.=$this->getField($k)->generateSelectQueryPart($v,$this->name,$whereId);
				$where_check=true;
			}
		}
		if($set_check)
		{
			$query.=" SET ".$set_clause;
		}
		if($where_check)
		{
			$query.=" WHERE ".$where_clause;
		}
		$query.=" ;";
			
		if(!$this->debugmode)
			echo "Entity::update for ".$this->name.", query= <br>".$query."<br>";

		if($set_check)
		{
			$turnback = mysql_query($query);
		}
		else
		{
			$turnback=$set_check;
		}
		return $turnback;
	}

	/**
	 * @access public
	 * @param where_conditions
	 * @ParamType where_conditions
	 */
	public function delete($where_conditions) {
		$query="DELETE FROM {$this->name}";

		$where_clause="";
		$whereId=md5(uniqid(mt_rand()));
		$where_check=false;
		foreach($where_conditions as $k=>$v)
		{

			if($this->existsField($k))
			{
				$where_clause.=$this->getField($k)->generateSelectQueryPart($v,$this->name,$whereId);
				$where_check=true;
			}
		}

		if($where_check)
		{
			$query.=" WHERE ".$where_clause.";";
		}
		if($where_check)
		{
			$turnback = mysql_query($query);
		}
		else
		{
			$turnback=$set_check;
		}
		return $turnback;


	}

	/**
	 *
	 * Adds a field requesting it to the TypeBuilder ( responsible of the constructino of baseType objects)
	 * as standard the field isn't a primary or foreign key but it could be imposed after this operation
	 *
	 *
	 *
	 *
	 * @access public
	 * @param name
	 * @param type
	 * @param length
	 * @param mandatory
	 * @ParamType name
	 * @ParamType type
	 * @ParamType length
	 * @ParamType mandatory
	 */
	public function addField($name, $type, $length = "", $mandatory = "no") {
		$this->fields[]=TypeBuilder::getInstance()->create($name, $type, false, false, $length, $mandatory);
	}

	/**
	 *
	 * Returns the baseType object that's contained in fields array with the name specified in $name
	 * if exists
	 *
	 *
	 * @access public
	 * @param name
	 * @return boolean
	 * @ParamType name
	 * @ReturnType boolean
	 */
	public function getField($name) {
		$field = false;
		foreach($this->fields as $k => $f) {
			if ($f->name == $name) {
				$field = $this->fields[$k];
			}
		}
		return $field;
	}

	/**
	 *
	 *
	 * Sets the value of a field
	 *
	 *
	 * @access public
	 * @param name
	 * @param value
	 * @return boolean
	 * @ParamType name
	 * @ParamType value
	 * @ReturnType boolean
	 */
	public function setFieldValue($name, $value) {
		$field = false;
		foreach($this->fields as $k => $f) {
			if ($f->name == $name) {
				$this->fields[$k]->value=$value;
				$field=true;
			}
		}
		return $field;
	}

	/**
	 *
	 * Removes the baseType object that's contained in fields array with the name specified in $name
	 * if exists
	 *
	 * @access public
	 * @param name
	 * @ParamType name
	 */
	public function removeField($name) {
		foreach($this->fields as $k => $f) {
			if ($f->name == $name) {
				array_splice($this->fields, $k);
				//unset($f);
			}
		}
	}

	/**
	 *
	 * Returns a boolean that indicates the presence of the field with the name specified in $field
	 *
	 *
	 * @access public
	 * @param field
	 * @return integer number
	 * @ParamType string field
	 * @ReturnType integer number
	 */
	public function existsField($field) {
		if($this->debugmode)
			echo "<br /> Entity::existsField";
		$i = 0;
		$trovato = 0;
		while ((!$trovato) and ($i<count($this->fields))) {
			if ($this->fields[$i]->name == $field) {
				$trovato = 1;
			}
			$i++;
		}
		return $trovato;
	}

	/**
	 * @access public
	 * @param name
	 * @param exts
	 * @ParamType name
	 * @ParamType exts
	 */
	public function setExtension($name, $exts) {
		$index = false;
		foreach($this->fields as $k => $v) {
			if ($v->name == $name) {
				$this->fields[$k]->exts= $exts;
			}
		}
	}

	/**
	 * @access public
	 */
	public function getKeyName() {
		if ($this->noKey) {
			return false;
		} else {
			return $this->fields[0]->name;
		}
	}

	/**
	 * @access public
	 */
	public function getKeyType() {
		if ($this->noKey) {
			return false;
		} else {
			return $this->fields[0]->type;
		}
	}

	/**
	 * @access public
	 */
	public function getKeyLength() {
		if ($this->noKey) {
			return false;
		} else {
			return $this->fields[0]->length;
		}
	}

	/**
	 * @access public
	 */
	public function standardKey() {
		return $this->standardKey;
	}

	/**
	 * @access public
	 * @param string name
	 * @param type
	 * @param length
	 * @ParamType name
	 * @ParamType type
	 * @ParamType length
	 */
	public function addPrimaryKey($name, $type, $length = "") {
		$primaryKey = $this->getField($name);
		if (!$primaryKey)
			$this->fields[0] = TypeBuilder::getInstance()->create($name, $type, false, true, $length, MANDATORY);
		else {
			$primaryKey->primary_key= true;
			$this->removeField($name);
			$this->fields[0] = $primaryKey;
		}
		$this->standardKey = false;
	}

	/**
	 * @access public
	 */
	public function noKey() {
		$this->noKey = true;
		unset($this->fields);
	}

	/**
	 * @access public
	 * @param field
	 * @ParamType field
	 */
	public function setReferenceOrder($field) {
		$this->referenceOrder = $field;
	}


	/**
	 * @access public
	 * @param entity
	 * @param name
	 * @ParamType entity
	 * @ParamType name
	 */
	public function addReference($entity, $name = "") {

		if ($name == "") {
			$name = "id_{$entity->name}";
		}

		$type = $entity->fields[0]->type;
		$length = (isset($entity->fields[0]->length) ? $entity->fields[0]->length : '');

		if ($this->name == $entity->name) {
			$selfRelation = true;
		} else {
			$selfRelation = false;
		}

		$referenceField=TypeBuilder::getInstance()->create($name, $type, true, false, $length,"off");
		$referenceField->referenceTo($this, $entity, $selfRelation);


		$this->fields[]=$referenceField;


		$entity->referred[$this->name][] = $this;
		$entity->referredBy[$this->name]['entity'][] = $this;
		$entity->referredBy[$this->name]['foreign key'][] = $name;


		if ($this->name == $entity->name) {
			beContent::getInstance()->selfrefs[md5($this->name.$name)]['table'] = $this->name;
			beContent::getInstance()->selfrefs[md5($this->name.$name)]['field'] = $name;
		}
		$this->lastFieldIndex = count($this->fields)-1;
	}

	/**
	 * @access public
	 * @param name
	 * @param value
	 * @ParamType name
	 * @ParamType value
	 */
	public function setFieldParameter($name, $value) {
		$this->fields[$this->lastFieldIndex]->$name= $value;
	}

	/**
	 * @access public
	 */
	public function setPresentation() {
		
		$this->presentation = func_get_args();
	}

	/**
	 * this fields will be used by the search engine
	 * @access public
	 */
	public function setTextSearchFields() {
		$this->searchFields['TEXT'] = func_get_args();
	}

	/**
	 * this script will be connected to the link retrieved by research
	 * @access public
	 */
	public function setTextSearchScript($script) {
		$this->searchTextScript = $script;
	}

	/**
	 * this script will be connected to the link retrieved by research
	 * @access public
	 */
	public function getTextSearchScript() {
		return $this->searchTextScript;
	}
	/**
	 * @access public
	 * @param name
	 * @param label
	 * @ParamType name
	 * @ParamType label
	 */
	public function setCheckSearchField($name, $label) {
		$this->searchFields['CHECK'][] = $name;
		$this->searchFields['CHECKLABEL'][] = $label;
	}

	/**
	 * @access public
	 */
	public function setCheckSearchFields() {
		$this->searchFields['CHECK'] = func_get_args();
	}

	/**
	 * @access public
	 */
	public function setSearchRelations() {
		$this->searchRelations = func_get_args();
	}

	/**
	 * @access public
	 * @param relation
	 * @param label
	 * @ParamType relation
	 * @ParamType label
	 */
	public function setSearchRelation($relation, $label) {
		$this->searchRelations[] = $relation;
		$this->searchFields['RELATIONLABEL'][] = $label;
	}

	/**
	 * @access public
	 */
	public function setSearchPresentationHead() {
		$this->searchHead = func_get_args();
	}

	/**
	 * @access public
	 */
	public function setSearchPresentationBody() {
		$this->searchBody = func_get_args();
	}

	/**
	 * @access public
	 */
	public function connect() {
		if($this->debugmode)
		{
			echo "<br> Entity::connect for {$this->name} instance";
		}

		if(Settings::getModMode())
		{
			$tableExists=$this->database->existsTable($this->name);
			$tableSchemaIsUpdated=true;

			if ($tableExists) {
				foreach ($this->fields as $k => $v) {
					if(!$this->database->existsField($this->name,$v->name))
					{
						$tableSchemaIsUpdated=false;
					}
				}
				$existingFields=$this->database->getTableFields($this->name);
				if(is_array($existingFields))
				{
					foreach($existingFields as $k=>$v)
					{
						if(!$this->existsField($k))
						{
							$tableSchemaIsUpdated=false;
						}
					}
				}
			}
			if(!$tableExists||!$tableSchemaIsUpdated)
			{
				$query="";
				if(!$tableSchemaIsUpdated)
				{
					$query.= "DROP TABLE {$this->name}; ";
					$oid = mysql_query($query);
				}
					
				$query = "CREATE TABLE {$this->name} (";
				/**
				 *
				 * L'insostenibile leggerezza dell'essere oggetto!
				 */
				foreach ($this->fields as $k => $v) {
					$query.=$v->connect($this->entityName);
				}


				if ($this->noKey) {
					$query .= ")";
				} else {
					$query .= ", primary key({$this->fields[0]->name}))";
				}
				$oid = mysql_query($query);
				if (!$oid) {
					echo Message::getInstance()->getMessage(MSG_ERROR_DATABASE_QUERY)." {$this->name} at line ",__LINE__;
					echo "<hr>", $query;
					exit;
				}
				else
				{
					$this->database->updateTables();
				}
			}
		}

		if(!isset($this->presentation)){
			$this->setPresentation("%{$this->fields[0]->name}");
		}
		/**
		 * CREAZIONE DEL TEMPLATE
		 * viene eseguita sia se la tabella � esistente sia se non presente nel DB
		 * il controllo sulla creazione dei file � compito del metodo
		 */
		CreateTemplate::createTemplateMultiple($this);
		CreateTemplate::createTemplateSingle($this);
		CreateTemplate::createTemplateReport($this);
		CreateTemplate::createTemplateSearch($this);
		/**
		 * CREAZIONE DEL TEMPLATE
		 * viene eseguita sia se la tabella � esistente sia se non presente nel DB
		 * il controllo sulla creazione dei file � compito del metodo
		*/
		$GLOBALS[] = $this;

		$this->register();
	}

	/**
	 * @access public
	 */
	public function register() {
		if($this->debugmode)
			echo "<br> Entity::register for {$this->name} instance";
		global $entitiesEntity;
		if (isset($GLOBALS['entitiesEntity'])) {
			$oid = mysql_query("INSERT INTO {$entitiesEntity->name}
			VALUES('{$this->name}','{$this->name}', '{$this->owner}', '', 0, 0, 0)");
			if (!$oid) {
			}
		}
	}

	/**
	 * @access public
	 */
	public function noReferred() {
		return (count($this->referredBy) == 0);
	}


	/**
	 *
	 * This function returns the data contained in the entity according to the
	 * presentation given by setPresentation().
	 *
	 *
	 *
	 * @access public
	 * @return data
	 * @ReturnType data
	 */
	public function getPresentation() {
		if($this->debugmode)
			echo "<br> Entity::getPresentation for {$this->name} instance";

		$id1 = md5(uniqid(mt_rand()));
		$id2 = md5(uniqid(mt_rand()));
		$fields = "";
		$fieldsToConcat = "";

		if (strpos($this->presentation[0], "%") === false) {

			foreach($this->presentation as $value) {
				$fields .= Parser::first_comma($id1,", ")."$value";
				foreach($this->fields as $k => $v) {
					if (($v->name == $value) and ($v->type == DATE)) {
						$value = "DATE_FORMAT({$value},'%d/%m/%Y')";
					}
				}
				$fieldsToConcat .= Parser::first_comma($id2,",' ', ")."{$value}";
			}
		} else {
			$presentation = $this->presentation[0];
			$finito = false;
			do {
				$pos = strpos($presentation, "%");
				if ($pos !== false) {
					$value = substr($presentation, 0, $pos);
					$fieldsToConcat .= Parser::first_comma($id2,",")."'{$value}'";
					$presentation = substr($presentation, $pos);
					ereg("^\%([[:alnum:]]*)", $presentation, $token);
					$fields .= Parser::first_comma($id1,", ").$token[1];
					$fieldsToConcat .= Parser::first_comma($id2,",")."{$token[1]}";
					$presentation = substr($presentation, strlen($token[1])+1);
				} else {
					$fieldsToConcat .= Parser::first_comma($id2,",")."'{$presentation}'";
					$finito = true;
				}
			} while (!$finito);
		}
		$result['fields'] = $fields;
		$result['fieldsToConcat'] = $fieldsToConcat;
		return $result;
	}

	/**
	 * @access public
	 */
	public function insertItem() {
		if($this->debugmode)
			echo "<br> Entity::insertItem for {$this->name} instance";
		/**
		 * called only from logs
		 */
		$id = md5(uniqid(mt_rand()));
		$query = "INSERT INTO {$this->name} VALUES(";
		$args = func_get_args();
		if (is_array($args[0])) {
			foreach($this->fields as $k => $field) {
				switch($field->type) {
					case FILE:
						$query .= Parser::first_comma("{$id}", ", ")."'{$args[0][$field->name]}'";
						$query .= Parser::first_comma("{$id}", ", ")."'".$args[0][$field->name."_filename"]."'";
						$query .= Parser::first_comma("{$id}", ", ")."'".$args[0][$field->name."_size"]."'";
						$query .= Parser::first_comma("{$id}", ", ")."'".$args[0][$field->name."_type"]."'";
						break;
					default:
						$query .= Parser::first_comma("{$id}", ", ")."'{$args[0][$field->name]}'";
						break;
				}
			}
		} else {
			foreach($args as $k => $field) {
				$query .= Parser::first_comma("{$id}", ", ")."'{$field}'";
			}
		}
		$query .= ")";
		$oid = mysql_query($query);
		if (!$oid) {
			if (mysql_errno() != "1062") {
				if (mysql_errno() == "1136") {
					echo Message::getInstance()->getMessage(MSG_ERROR_DATABASE_INIT)." {$this->name} "." (".basename(__FILE__).":".__LINE__.")";
					exit;
				}
					
			} else {
				echo Message::getInstance()->getMessage(MSG_ERROR_DATABASE_PRESENTATION)." {$this->name} "." (".basename(__FILE__).":".__LINE__.")";
				exit;
			}
		}
	}
}
?>