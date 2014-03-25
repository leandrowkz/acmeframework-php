<?php
/**
* --------------------------------------------------------------------------------------------------
*
* Library Tag
*
* Library of functions related to application tag manipulation. An application tag is a tag that
* contains a constant value, for example:
*
*		The tag {URL_ROOT} when replaced will contain the constant value of URL_ROOT.
*
* This is very useful in cases when you have to save this mutable values on database.
* 
* @since 	24/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
class Tag {
	
	public $CI = null;
	
	/**
	* __construct()
	* @return object
	*/
	public function __construct () {}
	
	/**
	* tag_replace()
	* Replace all tag ocurrences for their respective values inside a string.
	* @param string string
	* @return mixed result
	*/
	public function tag_replace($string = '')
	{
		$return = $string;
		
		if(!is_null($string) && $string != '')
		{
			if(preg_match_all('/{([\s]*)[0-9a-zA-Z_-]+([\s]*)}/i', $string, $match))
			{
				
				// DEBUG;
				// print_r($match);
				
				if(isset($match[0]))
				{
					// Try to find all ocurrences
					foreach($match[0] as $index => $command)
					{
						// Remove characters tag '{' and '}'
						$command = str_replace(array('{', '}'), '', $command);

						// debug
						// echo $command;
						
						// replace only if command is a defined constant
						if( defined( $command ))
							$return = str_replace($match[0][$index], constant($command), $return);
					}
				}
			}
		}
		return $return;
	}
	
	/**
	* array_tag_replace()
	* Replaces one tag with name {NUMBER OR COLUMN_NAME} by the value of an array followed
	* $arr_data['NUMBER OR COLUMN_NAME'].
	* @param string value
	* @param array arr_data 
	* @return string new_string
	*/
	public function array_tag_replace($value = null, $arr_data = array())
	{
		// match all occurrences of {A-Z0-9a-z_-}
		preg_match_all('/{[0-9a-zA-Z_-]+}/', $value, $matches);	
		
		// cross all occurrences, replacing the value from tag by the value from array
		foreach($matches as $match)
		{	
			$counter = count($match);
			for($i = 0; $i < $counter; $i++)
			{
				// match array index, to replace that
				$index = str_replace('}', '', str_replace('{','', $match[$i]));
				
				// case tag name == array index number
				$data = (is_integer_($index)) ? array_values($arr_data) : $arr_data;
				
				// replaces tag value
				$value = str_replace($match[$i], get_value($data, $index), $value);
			}
		}
		return $value;
	}
}