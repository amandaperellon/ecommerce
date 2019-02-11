<?php

use \Hcode\Page;
use \Hcode\Model\Products;

$app->config('debug', true);

$app->get('/', function() {

	$products = Products::listAll();

	$page = new Page();

	$page->setTpl("index", [
		'products'=>Products::checkList($products)
	]);

}); 
?>