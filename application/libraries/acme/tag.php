<?php
/**
* --------------------------------------------------------------------------------------------------
* 
* Library Tag
*
* Gathers methods related with application tags.
*
* An app tag is every tag as {URL_ROOT} or {URL_IMG} inside a text. You can replace this tags by
* the corresponding value, in this case, URL_ROOT and URL_IMG constant values. 
* 
* @since 	24/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
class Tag {
	
	public $CI = null;
	
	/**
	* __construct()
	* Class constructor.
	*/
	public function __construct () {}
	
	/**
	* tag_replace()
	* Replaces all tag ocurrences by their respective values inside a string.
	*
	* Example:
	*			tag_replace('{URL_ROOT}/app_dashboard') => URL_ROOT constant value + /app_dashboard
	*
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
	* Replaces an specific tag as {NUMBER OR COLUMN_NAME} by the equivalent value inside an array.
	* 
	* Example:
	*
	*			$param_1 = String 'http://foobar.com/form/edit/{0}';
	*
	*			$param_2 = Array (
	*							 id    => 1, 
	*							 label => my_label, 
	* 							 email => some@some.com
	*							  );
	*
	*			echo array_tag_replace($param_1, $param_2); // will reproduce http://foobar.com/form/edit/1
	*
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