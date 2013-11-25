<?php

/**
 * @access public
 */
class front extends Tag {
	
	private $_intrisicState;

	/**
	 * @access public
	 * @param aExtrinsicState
	 * @ParamType aExtrinsicState 
	 */
	public function doIt($tagRoute,$parameters) {
		
			$menuEntity = $GLOBALS['sys_menu'];
			$menuTemplate = new Content($menuEntity,$menuEntity);
			$menuTemplate->setFilter("sys_menu_parent_id", $parameters["parent_id"]);
			$menuTemplate->setOrderFields("sys_menu_position",'sys_menu_parent',"sys_menu0_position");
			return $menuTemplate->get();
		
	}
}
?>