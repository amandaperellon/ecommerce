<?php

use \Hcode\PageAdmin;
use \Hcode\Model\Category;
use \Hcode\Model\ Products;
use \Hcode\Model\User;


$app->get('/admin/categories', function(){

	User::verifyLogin();

	$search = (isset($_GET['search'])) ? $_GET['search'] : "";

	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	if ($search != '') {
		
		$pagination = Category::getPageSearch($search, $page, 10);

	}else{

		$pagination = Category::getPage($page, 10);
	}

	$pages = [];

	for ($x=0; $x < $pagination['pages']; $x++) { 
		
		array_push($pages, [
			'href'=>'/curso1/ECommerce/index.php/admin/categories?'.http_build_query([
				'page'=>$x+1,
				'search'=>$search
		]),
		'text'=>$x+1
		]);
	}

	$categories = Category::listAll();

	$page = new PageAdmin();

	$page->setTpl("categories", [
		"categories"=>$pagination['data'],
		"search"=>$search,
		"pages"=>$pages
	]);

});

$app->get('/admin/categories/create', function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("categories-create");

});

$app->post('/admin/categories/create', function(){

	User::verifyLogin();

	$category = new Category();

	$category->setData($_POST);

	$category->save();

	$page = new PageAdmin();

	header("Location: /curso1/ECommerce/index.php/admin/categories");
	exit;

});

$app->get('/admin/categories/:idcategory/delete', function($idcategory){

	User::verifyLogin();

	$category = new Category();

	$category->get((int) $idcategory);

	$category->delete();

	header("Location: /curso1/ECommerce/index.php/admin/categories");
	exit;
});

$app->get('/admin/categories/:idcategory', function($idcategory){

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new PageAdmin();

	$page->setTpl("categories-update", [
	
		"category"=>$category->getValues()

	]);
});

$app->post('/admin/categories/:idcategory', function($idcategory){

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->setData($_POST);

	$category->save();

	header("Location: /curso1/ECommerce/index.php/admin/categories");
	exit;
});

$app->get('/admin/categories/:idcategory/products', function($idcategory){

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new PageAdmin();

	$page->setTpl("categories-products", [
		"category"=>$category->getValues(),
		"productsRelated"=>$category->getProducts(),
		'productsNotRelated'=>$category->getProducts(false)
	]);
});

$app->get('/admin/categories/:idcategory/products/:idproduct/add', function($idcategory, $idproduct){

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$product = new Products();

	$product->get((int)$idproduct);

	$category->addProduct($product);

	header("Location: /curso1/ECommerce/index.php/admin/categories/" . $idcategory . "/products");
	exit;
	
});

$app->get('/admin/categories/:idcategory/products/:idproduct/remove', function($idcategory, $idproduct){

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$product = new Products();

	$product->get((int)$idproduct);

	$category->removeProduct($product);

	header("Location: /curso1/ECommerce/index.php/admin/categories/" . $idcategory . "/products");
	exit;
	
});

?>
