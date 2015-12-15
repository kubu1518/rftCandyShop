<?php
/**
 * Created by PhpStorm.
 * User: István
 * Date: 2015.12.13.
 * Time: 21:21
 */

require_once($_SERVER['DOCUMENT_ROOT'] . "/rftCandyShop/Model/UserAsCustomer.php");
session_start();
$user = unserialize($_SESSION['actUser']);
$cart = $user->getCart();

$cart->modifyProductQuantity($_GET['id'],$_GET['value']);

$_SESSION['actUser'] = serialize($user);