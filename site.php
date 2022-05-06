<?php




use \felipeno22\Page;
use \felipeno22\PageAdmin;
use \felipeno22\Model\Product;
use \felipeno22\Model\Category;
//use \Hcode\Model\Cart;
//use \Hcode\Model\Address;
//use \felipeno22\Model\User;
//use \Hcode\Model\Order;
//use \Hcode\Model\OrderStatus;




$app->get('/', function() {
    
	$products= Product::listAll();
	
	$page= new Page();
	
	$page->setTpl("index",[
		'products'=>Product::checkList($products)]
	
	);

});


//rota tela  de lista de categorias
$app->get('/categories/:idcategory',function ($idcategory){

	//se nao houver um numero de pagina definido sera por padrão 1
//	$p=(isset($_GET['page'])) ? (int)$_GET["page"] : 1;


	$categories=new Category();

	$categories->get((int)$idcategory);
	
	$page=new Page();
	
	$page->setTpl("category",["category"=>$categories->getValues(),
	"products"=> Product::checkList($categories->getProducts())
	]);
	
	//$pages=[];

	//passando o num de paginas  para fazer a paginaçao
//o num de item por pagina nao esta sendo passado por param
//entao por padrão e  3 	
	//$pagination=$categories->getProductsPage($p);



	/*for ($i=1; $i<= $pagination['totalPages'];$i++) {

		array_push($pages,["link"=>"/categories/".$categories->getIdcategory()."?page=".$i,
							"page"=>$i]);
	}

	$page=new Page();


	

 	$page->setTlp("category",array("idcategory"=>$categories->getIdcategory(),"descategory"=>$categories->getDescategory(),"products"=>$pagination['data'],"pages"=>$pages));
*/
});




?>