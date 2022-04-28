<?php 

session_start();

require_once("vendor/autoload.php");
use \Slim\Slim;
use \felipeno22\Page;
use \felipeno22\PageAdmin;
use \felipeno22\Model\User;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	//echo "OK";
	
/*	$sql= new felipeno22\DB\Sql();
	
	$results= $sql->select("select * from tb_users");
	echo json_encode($results);
	*/
	
	$page= new Page();
	
	$page->setTpl("index");

});




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


$app->run();

 ?>