<?php
/**
*
* Classe Tag
*
* Esta biblioteca gerencia funções de utilização de tags internas para a aplicação.
* 
* @since		24/10/2012
* @location		acme.libraries.tag
*
*/
class Tag {
	// Definição de Atributos
	var $tag_name = 'app'; // Valor default: acme
	var $CI = null;
	
	/**
	* __construct()
	* Construtor de classe.
	* @return object
	*/
	public function __construct()
	{
	}
	
	/**
	* eval_replace()
	* Este método faz replace de n instruções localizadas dentro de uma tag pelo resultado destas 
	* instruções. Caso a na string encaminhada como parametro não exista uma tag válida para fazer 
	* replace, retorna a string sem modificações.
	* Veja o exemplo:
	* String contendo a tag: <acme eval=" URL_IMG " />
	* Resultado: URL_IMG
	* @param string tag
	* @param array variables
	* @return mixed result
	*/
	public function eval_replace($string = '')
	{
		$return = $string;
		
		if(!is_null($string) && $string != '')
		{
			if(preg_match_all("#<" . $this->tag_name . "[\s]+eval=[\"'](.*?)[\"'][\s]*?/>#i", $string, $match))
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
	* replace_tag()
	* Faz a substituição do valor {NUMERO_COLUNA} em uma string por um valor de 
	* um íncide de array.
	* @param string value
	* @param array data 
	* @return string new_string
	*/
	public function replace_tag($value = null, $arr_data = array())
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
	
	/**
	* replace_define_constant()
	* Faz a substituição do valor {DEFINE_CONSTANT} pelo valor correspondente da constante.
	* @param string value 
	* @return mixed constant
	*/
	public function replace_define_constant($value = '')
	{
		// Casa todas as ocorrencias de {A-Z0-9a-z_-}
		preg_match_all('/{[0-9a-zA-Z_-]+}/', $value, $matches);	
		
		// Varre todas as ocorrencias, substituindo valor da tag por constante
		foreach($matches as $match)
		{
			$counter = count($match);
			for($i = 0; $i < $counter; $i++)
			{
				// Coleta o indice do array
				$constant = str_replace('}', '', str_replace('{','', $match[$i]));
				
				// Faz replace da tag por valor do define
				$constant = constant($constant);
				
				// Faz replace do valor casado por valor da constante
				$value = str_replace($match[$i], $constant, $value);
			}
		}
		return $value;
	}
}