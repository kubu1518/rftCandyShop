<?php
/**
 * Created by PhpStorm.
 * User: István
 * Date: 2015.12.12.
 * Time: 12:24
 */

require_once($_SERVER['DOCUMENT_ROOT'] . "rftCandyShop/Model/database/Login.class.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "rftCandyshop/Model/UserAsCustomer.php");

session_start();
$user = unserialize($_SESSION['actUser']);

$logIn = new Login();
var_dump($user->getCart()->getProducts());
$user->saveCart();
$logIn->logOut();


