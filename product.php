<?php

use \felipeno22\PageAdmin;	
use \felipeno22\Model\Product;
use \felipeno22\Model\User;

//rota tela  de lista de categorias
$app->get('/admin/products',function (){

	User::verifyLogin();

	$products= Product::listAll();	
	
	$admin=new PageAdmin();

	$admin->setTpl('products',array("products"=>$products));
 
									
										

});
	
	
$app->get('/admin/products/create',function (){
	
	User::verifyLogin();

 	
 	$admin= new PageAdmin();

 	$admin->setTpl("products-create");
	
});	


$app->post('/admin/products/create',function (){
	
	User::verifyLogin();
	
	$product= new Product();
	
	$product->setData($_POST);
	
	
	
	$product->save();
	
	header("Location: /admin/products");
 	exit;	
 
	
});	



$app->get('/admin/products/:idproduct',function ($idproduct){
	
	User::verifyLogin();

	$products = new Product();

	$products->get((int)$idproduct);
	
	$products->checkPhoto();//chamando metodo de verificação de foto
 	
 	$admin= new PageAdmin();

 	$admin->setTpl("products-update",array("product"=>$products->getValues()));
	
});	


$app->post('/admin/products/:idproduct',function ($idproduct){
	
	User::verifyLogin();
	
	
	$products = new Product();

	$products->get((int)$idproduct);
	
	$products->setData($_POST);
	$products->update();
	
	$products->changePhoto($_FILES['file']);//passando o nome do atributo name da tag de  upload
	
	header("Location: /admin/products");
 	exit;
	
	
	
});



$app->get("/admin/products/:idproduct/delete", function ($idproduct) {

 	User::verifyLogin();


	$products = new Product();

	

	

	
	$products->delete($idproduct);

 	header("Location: /admin/products");
 	exit;


});



?>