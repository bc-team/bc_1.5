<?php

/**
 * @access public
 */
class TagSeoUrl extends Tag {
	private $_intrisicState;

	/**
	 * @access public
	 * @param aExtrinsicState
	 * @ParamType aExtrinsicState 
	 */
	public function doIt($parameters) {
		
		return Parser::seo_url($parameters);
				
	}
}
?>