<?php
/**
* --------------------------------------------------------------------------------------------------
* 
* Helper Form
*
* Gathers functions related with application HTML forms. 
*
* These functions are aliases to the same method names of form library.
*
* @example	// Function of this helper	
*			example_function();
*
*			// Equivalent call
* 			$this->form->example_function();
* 
* @since 	15/07/2013
*
* --------------------------------------------------------------------------------------------------
*/

/** 
* build_select_options()
* Builds a set of HTML tags <option> from a resultset array. This array must has two indexes, the
* first one is value will be placed on value attribute and the second one must be the label will
* be placed on option.
*  
* Take an example:
*
* 		Array 
* 		(
* 			[0] => Array ( [0] => VALUE, [1] => ROTULE )
* 			[1] => Array ( [0] => VALUE, [1] => ROTULE )
*		)
*
* @param array data
* @param option_selected 		// Value must be set as selected="selected"
* @param boolean blank_option 	// true for inserting an initial blank <option>
* @return string html
*/
function build_select_options($data = null, $option_selected = '', $blank_option = true)
{
	$CI =& get_instance();
	return $CI->form->build_select_options($data, $option_selected, $blank_option);
}