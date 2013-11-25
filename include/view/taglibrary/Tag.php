<?php
require_once(realpath(dirname(__FILE__)) . '/TagLibrariesFactory.php');

/**
 * @access public
 */
class Tag implements JsonSerializable {

	/**
	 * @access public
	 * @param aExtrinsicState
	 * @ParamType aExtrinsicState 
	 */
	
	public function __construct($structureAsArray=null,$fileSystemElement=null,$mode="as_array")
	{
		/**
		 * This is the leaf of the tree so nothing to do here,
		 * see TagLibrary implementation of this method
		 */
	}
	
	public function doIt($tagRoute,$parameters){}
	
	public function addTag($aKey, $tag){}
	
	public function removeTag($aKey){}
	
	
	public function jsonSerialize()
	{
		$turnback=array();
		$turnback["classname"]=get_class($this);
		return $turnback;
	}
	
	/**
	 *
	 * @param unknown $fileSystemElement
	 */
	protected function buildFromFileSystem($fileSystemElement)
	{
		/**
		 * This is the leaf of the tree so nothing to do here, 
		 * see TagLibrary implementation of this method
		 */
	}
	
	/**
	 *
	 * @param unknown $structureAsArray
	 */
	protected function buildFromArray($structureAsArray)
	{
		/**
		 * This is the leaf of the tree so nothing to do here, 
		 * see TagLibrary implementation of this method
		 */
	}
}
?>