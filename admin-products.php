<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Products;

$app->get("/admin/products", function(){

	User::verifyLogin();

	$products = Products::listAll();

	$page = new PageAdmin();

	$page->setTpl("products", array(
		"products"=>$products
	));
});

$app->get("/admin/products/create", function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("products-create");
});

$app->post("/admin/products/create", function(){

	User::verifyLogin();

	$products = new Products();

	$products->setData($_POST);

	

	header("Location: /curso1/ECommerce/index.php/admin/products");
	exit;
});

$app->get("/admin/products/:idproduct", function($idproduct){

	User::verifyLogin();

	$product = new Products();

	$product->get((int)$idproduct);

	$page = new PageAdmin();

	$page->setTpl("products-update", array(
		"product"=>$product->getValues()
	));
});

$app->post("/admin/products/:idproduct", function($idproduct){

	User::verifyLogin();

	$product = new Products();

	$product->get((int)$idproduct);

	$product->setData($_POST);

	$product->save();

	if($_FILES["file"]["name"] !== "") $product->setPhoto($_FILES["file"]);

	header("Location: /curso1/ECommerce/index.php/admin/products");
	exit;
});

$app->get("/admin/products/:idproduct/delete", function($idproduct){

	User::verifyLogin();

	$product = new Products();

	$product->get((int)$idproduct);

	$product->delete();

	header("Location: /curso1/ECommerce/index.php/admin/products");
});


?> 
