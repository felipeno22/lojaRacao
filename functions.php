<?php

use \felipeno22\Model\User;
use \felipeno22\Model\Cart;

function formatPrice($vlprice){
	
		if (!$vlprice > 0) $vlprice = 0;
		
		return number_format($vlprice,2,",",".");
}


function format_date($date)
{

	return date('d/m/Y', strtotime($date));

}


function checkLogin($inadmin=true){


	return User::checkLogin($inadmin);
}

function getUserName(){

$user= User::getFromSession();

return $user->getdesperson();

}



function getCartNrQtd()
{

	$cart = Cart::getFromSession();

	$totals = $cart->getProductsTotals();

	return $totals['nrqntd'];

}

function getCartVlSubTotal()
{

	$cart = Cart::getFromSession();

	$totals = $cart->getProductsTotals();

	return formatPrice($totals['vlprice']);

}


?>