<?php
/**
 * Created by PhpStorm.
 * User: István
 * Date: 2015.12.14.
 * Time: 19:44
 */

require_once($_SERVER['DOCUMENT_ROOT'] . "rftCandyShop/Model/UserAsCustomer.php");
session_start();
$user = unserialize($_SESSION['actUser']);

$user->orderFinalize();

$_SESSION['actUser'] = serialize($user);

echo "<p>A rendelés sikeres. <a href='http://localhost/rftCandyShop/View/index.php'>Ide</a> kattintva visszatérhet a kezdőoldalra</p>";