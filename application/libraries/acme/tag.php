<?php
/**
* --------------------------------------------------------------------------------------------------
*
* Library Tag
*
* Biblioteca de funções relacionadas à manipulação de tags internas da aplicação. Uma tag interna
* é uma tag que contém o valor de uma constante, por exemplo:
*
*		A tag {URL_ROOT}, quando substituída conterá o valor da constante URL_ROOT.
*
* Isto é útil no caso de salvar o valor de URLs no banco de dados.
* 
* @since 	24/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
class Tag {
	
	public $CI = null;
	
	/**
	* __construct()
	* Construtor de classe.
	* @return object
	*/
	public function __construct()
	{
	}
	
	/**
	* tag_replace()
	* Este método faz replace de todas as tags encontradas em uma string pelo seu respectivo valor.
	* @param string string
	* @return mixed result
	*/
	public function tag_replace($string = '')
	{
		$return = $string;
		
		if(!is_null($string) && $string != '')
		{
			if(preg_match_all("#{[0-9a-zA-Z_-]+}#i", $string, $match))
			{
				if(isset($match[1]))
				{
					// print_r($match[1]);
					// Executa um a um os comandos localizados na string
					foreach($match[1] as $index => $command)
					{
						// Verifica se o comando possui ponto e vírgula no final, 
						// caso não possua, então adiciona
						$command = (preg_match("/;$/", $command)) ? $command : $command . ';';
						
						// Eval no comando localizado, o retorno vai para $replace
						// echo($command . "\n");
						eval('$replace = ' . $command);
						
						// Caso $replace não tenha retorno, isto é, o eval não 
						// possui um retorno, então faz a substituição da tag por nada
						$replace = (!is_null($replace)) ? $replace : '';
						$return = str_replace($match[0][$index], $replace, $return);
					}
				}
			}
		}
		return $return;
	}
	
	/**
	* tag_array_replace()
	* Faz a substituição em uma string do valor {NUMERO_COLUNA} pelo valor de um 
	* índice de array $array['NUMERO_COLUNA'].
	* @param string value
	* @param array data 
	* @return string new_string
	*/
	public function tag_array_replace($value = null, $arr_data = array())
	{
		// Casa todas as ocorrencias de {A-Z0-9a-z_-}
		preg_match_all('/{[0-9a-zA-Z_-]+}/', $value, $matches);	
		
		// Varre todas as ocorrencias, substituindo valor do array por tag
		foreach($matches as $match)
		{	
			$counter = count($match);
			for($i = 0; $i < $counter; $i++)
			{
				// Coleta o indice do array
				$index = str_replace('}', '', str_replace('{','', $match[$i]));
				
				// coleta o indice do array por numero, caso tag == numero
				$data = (is_integer_($index)) ? array_values($arr_data) : $arr_data;
				
				// Faz replace da tag por valor
				$value = str_replace($match[$i], get_value($data, $index), $value);
			}
		}
		return $value;
	}
}