<?php

namespace Hcode;

class Model{
	private $values = [];

	public function  __call($name, $args){

		$method = substr($name, 0, 3);  //posição 0 a 3, ou seja, traga 0,1 e 2, é quantidade

		$fieldName = substr($name, 3, strlen($name));

		switch ($method) {
			case 'get':
			
				return (isset($this->values[$fieldName])) ? $this->values[$fieldName] : NULL; 
			
			break;
			
			case 'set':
				return $this->values[$fieldName] = $args[0];
			break;
		}
	}

	public function setData($data = array()){

		foreach ($data as $key => $value) {
			
			$this->{"set" . $key}($value);

		}

	}

	public function getValues(){

		return $this->values;

	}
}

?>
