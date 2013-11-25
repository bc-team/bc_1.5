<?php

/**
 * @access public
 */
class TagFormatDate extends Tag {
	private $_intrisicState;

	/**
	 * @access public
	 * @param aExtrinsicState
	 * @ParamType aExtrinsicState 
	 */
	public function doIt($parameters) {
		
		$mode_default = "NORMAL"; //EXTENDED_PLUS, LETTERS, BLOG, 
		
		/*
		 * Inseriamo un default nel caso non venga esplicitata "mode" della data,
		* ovvero nel caso in cui venga passata SOLO la stringa "grezza" della data.
		*/
		if(!is_array($parameters)){
			$mode = $mode_default;
			$date_to_mode = $parameters;
		}else{
			$mode = $parameters[1];
			$date_to_mode = $parameters[0];
		}
		
		/*
		 * $parameters in questo caso � un array di 2 elementi
		* $paremeters[0] ha la stringa in input da tagliare;
		* $parameters[1] ha la quantit�, la length del taglio.
		*/		
		return Parser::formatDate($date_to_mode, $mode);
				
	}
}
?>