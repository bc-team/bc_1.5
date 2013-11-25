<?php

/**
 * @access public
 */
class TagStrToLower extends Tag {
	private $_intrisicState;

	/**
	 * @access public
	 * @param aExtrinsicState
	 * @ParamType aExtrinsicState 
	 */
	public function doIt($parameters) {
		
		return strtolower($parameters);
				
	}
}
?>