<?php
require_once(realpath(dirname(__FILE__)) . '/../../include/model/baseType.php');

/**
 * @access public
 * @author Di Pompeo Sacco
 * @package include.model
 */
class TypeBuilder {


	private static $instance;
	private $supported_types_factories;

	
	private function __construct()
	{
			$this->supported_types_factories[STANDARD_PRIMARY_KEY_TYPE]=new IDTypeFactory();
			$this->supported_types_factories[ID]=new IDTypeFactory();
			$this->supported_types_factories[VARCHAR]=new VarcharTypeFactory();
			$this->supported_types_factories[TEXT]=new TextTypeFactory();
			$this->supported_types_factories[FILE]=new FileTypeFactory();
			$this->supported_types_factories[FILE2FOLDER]=new File2FolderTypeFactory();
			$this->supported_types_factories[IMAGE]=new ImageTypeFactory();
			$this->supported_types_factories[INT]=new IntegerTypeFactory();
			$this->supported_types_factories[BLOB]=new BlobTypeFactory();
			$this->supported_types_factories[POSITION]=new PositionTypeFactory();
			$this->supported_types_factories[DATE]=new DateTypeFactory();
			$this->supported_types_factories[LONGDATE]=new LongDateTypeFactory();
			$this->supported_types_factories[PASSWORD]=new PasswordTypeFactory();
			$this->supported_types_factories[COLOR]=new ColorTypeFactory();
	}
	
	public static function getInstance()
	{
		if(!isset(TypeBuilder::$instance))
		{
			TypeBuilder::$instance=new TypeBuilder();
		}
		return TypeBuilder::$instance;
	}
	
	/**
	 * @access public
	 * @param name
	 * @param type
	 * @param for_key
	 * @param pri_key
	 * @param length
	 * @param mandatory
	 * @static
	 * @ParamType name 
	 * @ParamType type 
	 * @ParamType for_key 
	 * @ParamType pri_key 
	 * @ParamType length 
	 * @ParamType mandatory 
	 */
	public static function create($name, $type, $for_key, $pri_key, $length, $mandatory) {
		$typeInstance=null;
		
		$typeInstance= TypeBuilder::getInstance()->supported_types_factories[$type]->create($name,$type, $for_key, $pri_key, $length, $mandatory);
		
		return $typeInstance;
	}

	/**
	 * @access public
	 * @param include.model.baseType[] supported_types
	 * @ParamType supported_types include.model.baseType[]
	 */
	public function setSupported_types(array $supported_types) {
		$this->supported_types = $supported_types;
	}

	/**
	 * @access public
	 * @return include.model.baseType[]
	 * @ReturnType include.model.baseType[]
	 */
	public function getSupported_types() {
		return $this->supported_types;
	}
}