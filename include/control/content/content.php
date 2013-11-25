<?php
/**
 * @author dipompeodaniele@gmail.com, n.sacco.dev@gmail.com
 */

DEFINE("SINGLE", "SINGLE");
DEFINE("FILTER", "FILTER");
#DEFINE("ALL", "ALL");
DEFINE("HIERARCHICAL", "HIERARCHICAL");
DEFINE("INDEXED", "INDEXED");
DEFINE("ISEMPTY", "ISEMPTY");
DEFINE("ISNOTEMPTY", "ISNOTEMPTY");
DEFINE("IF_FIRST", "IF_FIRST");

DEFINE('ACTIVE', "active = '*'");

Class Content {
	var
	$entity_name,
	$join_entities,
	$join_entities_2,
	$join_rules,
	$join_rules_2,
	$join_condition,

	$template_single,
	$template_multiple,
	$template,
	$template_alt,
	$templates,

	$buffer,

	$mode,
	$filters,
	$conditions,
	$order_fields,
	$limit,
	$copies,
	$triggers,
	$cache,
	$languages,
	$parameters,
	$style,
	$presentation,
	$values,
	$conditionals,

	$pager,

	$debug,
	$debugmode,

	$forceMultiple=false,
	$forceSingle=false;
	

	static function __autoload(){
		require_once 'include/content.inc.php';
	}

    /**
     * @param $entity
     * @property base_entity, joined_entity.
     * * For relation n-m use
     * * @property base_entity, relation_entity, joined_entity.
     */
    function __construct($entity) {

		$args = func_get_args();

		if (count($args)>1) {

			for($i=1; $i<count($args); $i++) {
				$item = $args[$i];
				$this->join_entities[] = $item;
				$this->join_entities_2[] = $item->name;
				$this->join_rules[$item->name] = "";
				$this->join_rules_2[$item->name][] = "";
			}
		}
			
		$this->entities = func_get_args();
		$this->entity_name = $entity->entityName;
		$this->template_single = "single/".$entity->entityName."_single";
		$this->template_multiple = "multiple/".$entity->entityName."_multiple";
		$this->template = false;
		$this->template_alt = false;
		$this->limit = false;
		$this->triggers = false;
		$this->presentation = false;
		$this->pager = false;
		$this->debug = false;
		$this->order_fields = $this->detectOrderFields();
		$languages=Config::getInstance()->getConfigurations()['languages'];
		if (isset($languages)) {
			foreach (Config::getInstance()->getConfigurations()['languages'] as $k => $v) {
				$this->languages[$k] = $k;
			}
		}
		//$this->detectCardinality();
	}

	/**
	 * This method is used to output template with data inside,
	 * it returns the compiled html code, it uses getRaw to retrieve data
	 * it assigns the standard template to entities in the schema multiple/entity_name_multiple.html
	 * or single/entity_name_single.html
	 * @param unknown_type $key
	 * @return string
	 */
	function get($key = "")
    {
		/**
		 * retrieving the requested entity from database
		 *
		 */
		$entity = DB::getInstance()->getEntityByName($this->entity_name);

		/**
		 * enabling parameters that could have been specified in the Content construction 'till now
		 */
		$this->enableRequest();

		/**
		 * Executing data retrieve
		 */
		$data=$this->getRaw($key);

		/**
		 * passing retrieved instances to smarty
		 */
		if($this->mode==SINGLE)
		{

			$skin=new Skinlet("single/{$entity->entityName}_single");
			if(isset($entity->instances))
			{
				$skin->setContent("instance",$entity->instances[0]);
			}
			else
				$skin->setContent("instance",null);

			$skin->setContent("instances",null);
		}
		else
		{
			$skin=new Skinlet("multiple/{$entity->entityName}_multiple");
			if(isset($entity->instances))
			{
				$skin->setContent("instances",$entity->instances);
			}
			else
				$skin->setContent("instances",null);
			
			$skin->setContent("instance",null);
		}
		
		if(isset($this->values))
		{
			foreach($this->values as $placeholder=>$value)
			{
				$skin->setContent($placeholder,$value);
			}
		}
		
		return $skin->get();

	}

	/**
	 * This method is used to output template with data inside indexed with position data,
	 * it returns the compiled html code, it uses getRaw to retrieve data
	 * @param unknown_type $key
	 * @return string
	 */
	function getIndexed() {
		$this->enableRequest();

		if (!$this->template) {

			echo "Warning: you need to specify a template for the indexed mode in {$this->entity_name} content.";
			exit;

		}

		$template = new Template("skins/{Config::getInstance()->getConfigurations()['skin']}/dtml/{$this->template}.html");

		$id = uniqid(time());
		$order_clause = $this->getOrderClause();
		$join_clause = $this->getJoinClause();
		$where_clause = $this->getWhereConditions();
		$limit_clause = $this->getLimitClause();

		$fields = $this->getEntityFields();

		$data = $this->getRaw();



		$index = 0;
		if (is_array($data)) {
			foreach ($data as $item) {
				$index++;
				foreach($item as $k => $v) {
					$template->setContent("{$k}_{$index}", $v);
				}
			}
		}


		$template->setContent("skin", Config::getInstance()->getConfigurations()['skin']);

		if (is_array($this->values)) {
			foreach($this->values as $k => $v) {

				$template->setContent($k,$v);
			}
		}

		$this->disableRequest();
		return $template->get();

	}

	/**
	 * This method applies the content to a template passed as a parameter, is useful in the case of partial
	 * content in a page and for using a template different from the standard entityName_single / entityName_multiple
	 * it operates on the $skin and compiles fields related to this content for that skin
	 * it uses getRaw to retrieve data
	 * @param Skin $skin
	 * @param String $prefix
     *
     * usa il prefix per due apply differenti nella stessa skin
	 */
	function apply($skin, $prefix = "")
    {

		$entity = DB::getInstance()->getEntityByName($this->entity_name);


		$data = $this->getRaw();
		
	    /*passing retrieved instances to smarty*/
		if($this->mode==SINGLE)
		{
			if(isset($entity->instances))
			{
                if( $prefix != ''){
                    $skin->setContent($prefix.'_instance',$entity->instances[0]);
                }
                else
				    $skin->setContent("instance",$entity->instances[0]);
			}
			else{
				$skin->setContent("instance",null);
            }
			$skin->setContent("instances",null);
		}
		else
		{
			if(isset($entity->instances))
			{
                if( $prefix != ''){
                    $skin->setContent($prefix.'_instances',$entity->instances);
                }
                else {
				    $skin->setContent("instances",$entity->instances);
                }
			}
			else
				$skin->setContent("instances",null);
			
			$skin->setContent("instance",null);
		}
	}
	
	/**
	 * This method returns only an attribute of a single instance of the entity
	 * by the way the method retrieves all the fields from db
	 * it uses getRaw to retrieve data
	 * @param unknown_type $key
	 * @param unknown_type $field
	 */
	function getFieldRaw($key, $field) {
	
		$entity = DB::getInstance()->getEntityByName($this->entity_name);
	
		$data=$this->getRaw($key);
		
		return $data[0][$this->getName($field)];
	
	}
	
	/**
	 * This method is used to retrieve data without putting it in a template,
	 * it returns the query cursor and it instantiates the instances in the requesting entity
	 * @param unknown_type $key
	 * @return string
	 */
	function getRaw($key = "") {

		$entity = DB::getInstance()->getEntityByName($this->entity_name);
		
		$this->enableRequest();

		$this->detectCardinality();

		if (isset($this->cache[$key])) {
			$result = $this->cache[$key];
		}
        else
        {
			$where_conditions = $this->getWhereConditions();
			/**
			 * retrieving what requested as object 
			 */
			$this->entities[0]->retrieveAndLink($where_conditions,$this->join_entities,$this->order_fields,$this->limit);
		}

		$this->disableRequest();

		return $result;
	}


	function setTemplate($name) {
		$this->template = $name;
	}

	function setContent($name, $value) {
		$this->values[$name] = $value;
	}

	function setConditional($condition, $value) {

		$this->conditionals[] = Array("condition" => $condition, "value" => $value);

	}

	function setConditionalTemplate($template1, $template2, $cond, $field) {

		$this->template_alt["true"] = $template1;
		$this->template_alt["false"] = $template2;
		$this->template_alt["expr"] = $cond;
		$this->template_alt["field"] = $field;
	}

	function getName($name) {
		return $this->entity_name."_".$name;
	}

	function setParameter($name, $value) {

		$this->parameters[$name] = $value;
	}

	function unsetParameter($name) {
		unset($this->parameters[$name]);
	}

	function enableRequest() {
		if (is_array($this->parameters)) {
			foreach($this->parameters as $k => $v) {
				$_REQUEST[$k] = $v;
			}
		}

	}

	function disableRequest() {
		if (is_array($this->parameters)) {
			foreach($this->parameters as $k => $v) {
				unset($_REQUEST[$k]);
			}
		}
	}

	function setDebug() {
		$this->debug = true;
	}


	function setPresentation() {
		$this->presentation = func_get_args();
	}

	function getEntityFields() {

		if($this->debugmode)
			echo "<br> Entity::getEntityFields for {$this->entities[0]->name} instance";


		$result = "";

		$id = uniqid(time());

		foreach($this->entities[0]->fields as $field) {

			if (ereg("_{Config::getInstance()->getConfigurations()['currentlanguage']}$", $field->name)) {

				$result .= Parser::first_comma($id, ", ");

				$result .= "{$this->entity_name}.{$field->name} AS {$this->entity_name}_";
				$result .= substr($field->name, 0, strlen($field->name)-3);
					

			} else {
					
				switch ($field->type) {
					case FILE:
						$result .= Parser::first_comma($id, ", ");
						$result .= "{$this->entity_name}.{$field->name}_filename AS {$this->entity_name}_{$field->name}_filename";
						$result .= Parser::first_comma($id, ", ");
						$result .= "{$this->entity_name}.{$field->name}_size AS {$this->entity_name}_{$field->name}_size";
						$result .= Parser::first_comma($id, ", ");
						$result .= "{$this->entity_name}.{$field->name}_type AS {$this->entity_name}_{$field->name}_type";
						break;
							
					default:
						$result .= Parser::first_comma($id, ", ");
						$result .= "\n";
						$result .= "{$this->entity_name}.{$field->name} AS {$this->entity_name}_{$field->name}";
						break;
				}
			}
		}

		if (is_array($this->join_entities_2)) {

			foreach($this->join_entities_2 as $name) {

				$join_entities[$name][] = true;

				if (count($join_entities[$name]) == 1) {
					$postfix = "";
				} else {
					$postfix = "_".count($join_entities[$name]);
				}

				$entity = DB::getInstance()->getEntityByName($name);

				foreach($entity->fields as $field) {
					if (ereg("_{Config::getInstance()->getConfigurations()['currentlanguage']}$", $field->name)) {

						$result .= Parser::first_comma($id, ", ");
							
						$result .= "{$entity->name}.{$field->name} AS {$entity->name}{$postfix}_";
						$result .= substr($field->name, 0, strlen($field->name)-3);

					} else {
							
						switch ($field->type) {
							case FILE:
								$result .= Parser::first_comma($id, ", ");
								$result .= "{$entity->name}{$postfix}.{$field->name}_filename AS {$entity->name}{$postfix}_{$field->name}_filename";

								$result .= Parser::first_comma($id, ", ");
								$result .= "{$entity->name}{$postfix}.{$field->name}_size AS {$entity->name}{$postfix}_{$field->name}_size";

								$result .= Parser::first_comma($id, ", ");
								$result .= "{$entity->name}{$postfix}.{$field->name}_type AS {$entity->name}{$postfix}_{$field->name}_type";
								break;
									
							default:
								$result .= Parser::first_comma($id, ", ");
								$result .= "\n";
								$result .= "{$entity->name}{$postfix}.{$field->name} AS {$entity->name}{$postfix}_{$field->name}";
								break;
						}

						#$result .= "{$entity->name}.{$field['name']} AS {$entity->name}_{$field['name']}";
					}
				}
			}
		}
		return $result;
	}

    /**
     * @param
     * setOrderFields("campo sul quale ordinare <DESC se necessario>
     */
    function setOrderFields() {
		$this->order_fields = func_get_args();
	}

	function setFilter($filter_name,$filter_value)
    {
		$this->conditions[$filter_name] = $filter_value;
	}

	function setLimit($limit) {
		$this->limit = $limit;
	}

	function setTrigger($name, $value) {
		$this->triggers[] = Array($name, $value);
	}

	function forceSingle()
	{
		$this->forceSingle=true;
	}


	function forceMultiple()
	{
		$this->forceMultiple=true;
	}
	
	function detectCardinality() {

		if($this->forceMultiple||$this->forceSingle)
		{
			if($this->forceSingle)
				$this->mode = SINGLE;
			else
			{
					
				$this->mode = ALL;
			}
		}
		else
		{
			$entity = DB::getInstance()->getEntityByName($this->entity_name);
	
			if (array_key_exists($this->getName($entity->fields[0]->name),$_REQUEST)) {
				$this->mode = SINGLE;
			} else {
				for($i=1; $i<count($entity->fields); $i++) {
	
					if (array_key_exists($this->getName($entity->fields[$i]->name), $_REQUEST)) {
						$filters[] = $this->getName($entity->fields[$i]->name);
					}
				}
	
				if (is_array($this->join_entities)) {
					$i=0;
					foreach($this->join_entities as $k => $entity) {
						//$entity = DB::getInstance()->getEntityByName($entity->entityName);
	
						foreach($entity->fields as $field) {
							if (array_key_exists("{$entity->name}_{$field->name}", $_REQUEST)) {
								$filters[] = $field->name;
							}
						}
						$i++;
					}
				}
	
				if (isset($filters)) {
					if (count($filters) > 0) {
						$this->mode = FILTER;
					} else {
						$this->mode = ALL;
					}
				} else {
					$this->mode = ALL;
				}
			}
		}
	}

	function detectOrderFields() {

		$entity = $GLOBALS[$this->entity_name];

		if ($entity->referenceOrder != "") {
			$result[] = $entity->referenceOrder;

			return $result;
		}
	}
	/**
	 * This method finds all required fields of the entire join for this request
	 * and creates a $where_conditions compatible array in order to be used with entities
	 * retrieving mechanism, it's necessary to have this reposibility in here 'cause this script
	 * is specific to contents that has to be compatible with templates so this class has to
	 * mantain the entityName_attributeName -- attributeEffectiveName notations correspondence
	 *
	 * Otherwise there's no responsability regarding the existence of attributes in entity structure,
	 * this check is executed inside every entity
	 */
	function getWhereConditions() {

		$entity = DB::getInstance()->getEntityByName($this->entity_name);
		
		$where_conditions = array();
		$id = uniqid(time());

		/**
		 * Retrieving conditions passed from request (POST OR GET)
		 */
		foreach ($_REQUEST as $k => $v) {
			$token=array();
			if ($this->isField($k, $token)) {
				/**
				 * Token is necessary in order to distinguish between the
				 * entityName_attributeName and the attributeEffectiveName notations
				 * @var unknown_type
				 */
				if(!($this->mode!=SINGLE) && $token['field'] == $entity->fields[0]->name)			
					$where_conditions[$token['field']]= $_REQUEST[$k];
			}
		}

		/**
		 * Retrieving conditions imposed from setFilter and setParameter
		 */
		if(is_array($this->conditions))
        {
			foreach($this->conditions as $k=>$value)
			{
				$where_conditions[$k]= $value;
			}
        }

        if (is_array($this->parameters)) {
            foreach($this->parameters as $name => $value) {
                $where_conditions[$name]=$value;
            }
        }
        /**
         * turning back the entity-compatible where_conditions array
         */
        return $where_conditions;
	}

	function getValue($name) {
		if (isset($this->buffer[0][$name])) {
			return $this->buffer[0][$name];
		} else {
			return false;
		}
	}

	/**
	 * this method is used to retrieve a clean version of the field name inserted and its value
	 * @param unknown $field
	 * @return unknown
	 */
	function cleanField($field) {

		ereg("([[:alnum:]\_]*)\_([[:alnum:]]*)$", $field, $token);

		$result['table'] = $token[1];
		$result['field'] = $token[2];

		return $result;
	}
	
	/**
	 * this method is used to check if a field is an element of this content
	 * it could be related to any of the joining entities so it has to be checked
	 * @param unknown $field
	 * @param unknown $token
	 * @return boolean
	 */
	function isField($field, &$token) {

		$entity = DB::getInstance()->getEntityByName($this->entity_name);

		$field2 = substr($field, strlen($this->entity_name) + 1);
		$trovato = false;

		foreach ($entity->fields as $k => $v) {

			if (($this->getName($v->name) == $field)) {
				$trovato = true;
				$element = $this->cleanField($field);
				$token['entity'] = $entity->name;
				$token['field'] = $v->name;
			}
		}

		if (!$trovato) {
			if (is_array($this->join_entities)) {

				foreach($this->join_entities as $name=>$entity) {
					foreach($entity->fields as $f) {
						if ("{$entity->name}_{$f->name}" == $field) {
							$trovato = true;
							$token['entity'] = $entity->name;
							$token['field'] = $f->name;
						}
					}
				}
			}
		}
		return $trovato;
	}
}
?>