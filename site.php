<?php




use \felipeno22\Page;
use \felipeno22\PageAdmin;
//use \Hcode\Model\Product;
//use \Hcode\Model\Category;
//use \Hcode\Model\Cart;
//use \Hcode\Model\Address;
//use \felipeno22\Model\User;
//use \Hcode\Model\Order;
//use \Hcode\Model\OrderStatus;




$app->get('/', function() {
    
	//echo "OK";
	
/*	$sql= new felipeno22\DB\Sql();
	
	$results= $sql->select("select * from tb_users");
	echo json_encode($results);
	*/
	
	$page= new Page();
	
	$page->setTpl("index");

});



?>