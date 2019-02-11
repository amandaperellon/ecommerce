<?php

use \Hcode\Page;
use \Hcode\Model\Products;
use \Hcode\Model\Category;

$app->config('debug', true);

$app->get('/', function() {

	$products = Products::listAll();

	$page = new Page();

	$page->setTpl("index", [
		'products'=>Products::checkList($products)
	]);

}); 

$app->get('/categories/:idcategory', function($idcategory){

	$category = new Category();

	$category->get((int)$idcategory);

	$category->setData($_POST);

	$page = new Page();

	$page->setTpl("category", [
		"category"=>$category->getValues(),
		"products"=>Products::checkList($category->getProducts())
	]);
});
?>