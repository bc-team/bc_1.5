<?php

/**
 * @access public
 */
class TagSubText extends Tag {
	private $_intrisicState;

	/**
	 * @access public
	 * @param aExtrinsicState
	 * @ParamType aExtrinsicState 
	 */
	public function doIt($tagRoute, $parameters) {
		
		$length_default = 50;
		/*
		 * Inseriamo un default nel caso non venga esplicitata la length del taglio,
		 * ovvero nel caso in cui venga passata SOLO la stringa da tagliare. 
		 */ 
		if(!isset($parameters[1])){
			$length = $length_default;
			$string_to_cut = $parameters[0];
		}else{
			$length = $parameters[1];
			$string_to_cut = $parameters[0];
		}
		
		/*
		 * $parameters in questo caso � un array di 2 elementi
		 * $paremeters[0] ha la stringa in input da tagliare;
		 * $parameters[1] ha la quantit�, la length del taglio.
		 */
		return Parser::subtext($string_to_cut, $length);
				
	}
}
?>