<?php
/**
 * Created by PhpStorm.
 * User: István
 * Date: 2015.12.13.
 * Time: 14:38
 */

require_once($_SERVER['DOCUMENT_ROOT'] . "rftCandyShop/Model/ListingUtilities.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "rftCandyShop/Model/UserAsCustomer.php");

session_start();
$lu = new ListingUtilities();
$user = unserialize($_SESSION['actUser']);
$productID = $_GET['t_id'];
$qauntity = $_GET['qauntity'];

$productData= $lu->getProductByPID($productID);


$user->getCart()->addProduct(Product::createProductByArray($productData),$qauntity);
$_SESSION['actUser'] = serialize($user);

