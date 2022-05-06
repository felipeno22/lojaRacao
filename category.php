<?php


use \felipeno22\PageAdmin;
use \felipeno22\Model\User;
use \felipeno22\Model\Category;
use \felipeno22\Model\Product;

//rota tela  de lista de categorias
$app->get('/admin/categories',function (){

	User::verifyLogin();

 //	$search= (isset($_GET['search'])) ? $_GET['search'] :'';
 	//$page= (isset($_GET['page'])) ? (int)$_GET['page'] :1;

		$categories=Category::listAll(); 	

 /*		if($search != ''){

 		$categories=Category:: getPageSearch($search,$page);	

 		}else{


 		$categories=Category:: getPage($page);

 		}

 		$pages=[];



for ($x=0; $x < $categories['totalPages'] ; $x++) { 

	array_push($pages, ["href"=>"/admin/categories?".http_build_query(["page"=>$x+1,"search"=>$search]),
						"text"=>$x+1]);
}

*/
	
	$admin=new PageAdmin();

	$admin->setTpl('categories',array("categories"=>$categories));
 /*	$admin->setTlp("categories",array("categories"=>$categories['data'],"search"=>$search,
 									"pages"=>$pages));*/
									
										

});


//chama tela de criar categorias
$app->get("/admin/categories/create", function () {

	User::verifyLogin();

 	
 	$admin= new PageAdmin();

 	$admin->setTpl("categories-create");


 	
});

//rota tela  de lista de categorias
$app->post('/admin/categories/create',function (){


	User::verifyLogin();
 		
		
 	$category = new Category();
 	$category->setData($_POST);

 	$category->save();

 	header("Location: /admin/categories");
 	exit;

});


//chama tela de alterar categoria
$app->get("/admin/categories/:idcategory", function ($idcategory) {

 	User::verifyLogin();

	$categories = new Category();

	$categories->get((int)$idcategory);//convertendo o id passado para int 	


	$admin=new PageAdmin();

 	$admin->setTpl("categories-update",array("category"=>$categories->getValues()));

});




//rota para alterar categorias
$app->post("/admin/categories/:idcategory", function ($idcategory) {


 	User::verifyLogin();

	$categories = new Category();

	$categories->get((int)$idcategory);//convertendo o id passado para int 	

	$categories->setData($_POST);
	$categories->update();

 	header("Location: /admin/categories");
 	exit;




});


$app->get("/admin/categories/:idcategory/delete", function ($idcategory) {

 	User::verifyLogin();


	$categories = new Category();

	

	

	
	$categories->delete($idcategory);

 	header("Location: /admin/categories");
 	exit;


});




$app->get("/admin/categories/:idcategory/products", function ($idcategory) {

 	User::verifyLogin();


	$categories = new Category();

	

	$categories->get((int)$idcategory);//convertendo o id passado para int 	

 	$admin= new PageAdmin();

 	$admin->setTpl("categories-products",["category"=>$categories->getValues(),
	 											"productsRelated"=>$categories->getProducts(),
 												"productsNotRelated"=>$categories->getProducts(false)]);



});


$app->get("/admin/categories/:idcategory/products/:idproduto/add", function ($idcategory,$idproduct) {

 	User::verifyLogin();


	$categories = new Category();

	

	$categories->get((int)$idcategory);//convertendo o id passado para int 	

 	$products=new Product();

	$products->get((int)$idproduct);

 	$categories->addProduct($products);

	header("Location: /admin/categories/".$idcategory."/products");
 	exit;
 	

});


$app->get("/admin/categories/:idcategory/products/:idproduto/remove", function ($idcategory,$idproduct) {

 	User::verifyLogin();


	$categories = new Category();

	

	$categories->get((int)$idcategory);//convertendo o id passado para int 	

 	$products=new Product();

	$products->get((int)$idproduct);

 	$categories->removeProduct($products);

	header("Location: /admin/categories/".$idcategory."/products");
 	exit;
 	

});


?>