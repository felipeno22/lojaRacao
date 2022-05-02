<?php


use \felipeno22\Page;
use \felipeno22\PageAdmin;
//use \Hcode\Model\Product;
//use \Hcode\Model\Category;
//use \Hcode\Model\Cart;
//use \Hcode\Model\Address;
use \felipeno22\Model\User;
//use \Hcode\Model\Order;
//use \Hcode\Model\OrderStatus;

$app->get("/admin/users",function(){
	
		//verificando sessao do login
   User::verifyLogin();
	
	$users=User::listAll();
	
	$page_admin= new PageAdmin();
	
	//$page_admin->setTpl("users");
	$page_admin->setTpl("users",array("users"=>$users));
	
	
});


$app->get("/admin/users/create",function(){
	
		//verificando sessao do login
   User::verifyLogin();
	
	$page_admin= new PageAdmin();
	
	$page_admin->setTpl("users-create");
	
	
});

$app->get("/admin/users/:iduser/delete", function ($iduser) {

 	User::verifyLogin();


	$user = new User();

	

	

	
	$user->delete($iduser);

 	header("Location: /admin/users");
 	exit;




});




$app->get("/admin/users/:iduser",function($iduser){
	
		//verificando sessao do login
   User::verifyLogin();
   
   $user = new User();
   
   $user->get((int)$iduser);
	
	$page_admin= new PageAdmin();
	
	$page_admin->setTpl("users-update",array("user"=>$user->getValues()));
	
	
});



//rota para cadastrar
$app->post("/admin/users/create", function () {

 	User::verifyLogin();


 		
 	$user = new User();

 	$_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;



 	$user->setData($_POST);

	
	$user->save();

 	header("Location: /admin/users");
 	exit;



});




//rota para alterar
$app->post("/admin/users/:iduser", function ($iduser) {


 	User::verifyLogin();

	$user = new User();

	$_POST["inadmin"] = (isset($_POST["inadmin"])) ? 1 : 0;

	$user->get((int)$iduser);//convertendo o id passado para int 	


	$user->setData($_POST);

	//var_dump($user);
	$user->update();

 	header("Location: /admin/users");
 	exit;




});





?>