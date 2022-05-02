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



$app->get('/admin', function() {
    //verificando sessao do login
   User::verifyLogin();
	
	$page_admin= new PageAdmin();
	
	$page_admin->setTpl("index");

});

	
	
$app->get('/admin/login', function() {
    
	$page_admin = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page_admin->setTpl("login");

});


$app->post('/admin/login', function() {

	User::login($_POST['deslogin'], $_POST['despassword']);

	header("Location: /admin");
	exit;

});


$app->get('/admin/logout', function() {

	
	User::logout();
	

	header("Location: /admin/login");
	exit;

});



$app->get("/admin/forgot", function(){
	
		$page_admin = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
	
	
	$page_admin->setTpl("forgot");
	
	
	
	
});




//rota  para verificar se o existe usuario com o email digitado
$app->post('/admin/forgot',function (){


	//enviando o email digitado para verificar se existe usuario com ele
 	$user= User::getForgot($_POST["email"]);

 		header("Location: /admin/forgot/sent");
 		exit;

});



//rota para chamar a tela de  menssagem que o email foi enviado
$app->get('/admin/forgot/sent',function (){


	$admin=new PageAdmin(["header"=>false,"footer"=>false]);

 	$admin->setTpl("forgot-sent");
});





//rota para chamar tela de digitar nova senha
//nessa tela ja ocorre a validação  da recupeção de senha
$app->get('/admin/forgot/reset',function (){

	//pegando o codigo para validar
	$user= User::validForgotDecrypt($_GET['code']);

	$admin=new PageAdmin(["header"=>false,"footer"=>false]);

 	$admin->setTpl("forgot-reset",array("name"=>$user['desperson'],"code"=>$_GET['code']));
});


//rota aonde  faz a validação de senha novamente
$app->post('/admin/forgot/reset',function (){

	//pegando o codigo para validar novamente
	$forgot= User::validForgotDecrypt($_POST['code']);

//setando data de   recuperação de senha
	User::setFogotUsed($forgot['idrecovery']);

	$user = new User();

	//pegando dados do usario
	$user->get((int)$forgot['iduser']);//convertendo o id passado para int 

//password transforma senha de caracteres em hash para salvar no banco
	//o terceiro param é um array aonde vc define o numero de processamente
	//coloque sempre 12 para haver equilibrio
	$password=password_hash($_POST['password'], PASSWORD_DEFAULT,['cost'=>12]);
	
	//alterando a senha do usuario
	$user->setPassword($password);	

	$admin=new PageAdmin(["header"=>false,"footer"=>false]);

 	$admin->setTpl("forgot-reset-success");
});




?>