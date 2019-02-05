<?php

namespace Hcode;

use Rain\Tpl;

class Page {

	private $tpl;
	private $options = [];
	private $defaults = [
		"data"=>[]
	];

	public function __construct($opts = array()){

		$this->options = array_merge($this->defaults, $opts);  //o 2 parametro (opts) sempre irá sobreescrever o 1 (defaults) quando houver conflito, quando isso não ocorrer, o metodo mesclara os arrays

		$config = array(
			"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"] . "/curso1/ECommerce/views/",
			"cache_dir"     => $_SERVER["DOCUMENT_ROOT"] . "/curso1/ECommerce/views-cache/",
			"debug"         => false // set to false to improve the speed
		);

		Tpl::configure( $config );

		$this->tpl = new Tpl;

		$this->setData($this->options["data"]);

		$this->tpl->draw("header");

	}

	private function setData($data = array()){

		foreach ($data as $key => $value) {
			$this->tpl->assign($key, $value);
		}

	}

	public function setTpl($name, $data = array(), $returnHTML = false){

		$this->setData($data);

		return $this->tpl->draw($name, $returnHTML);

	}


	public function __destruct(){

		$this->tpl->draw("footer");

	}
}

?> 
