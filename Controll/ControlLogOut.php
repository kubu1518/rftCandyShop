<?php
/**
 * Created by PhpStorm.
 * User: István
 * Date: 2015.12.12.
 * Time: 12:24
 */

require_once($_SERVER['DOCUMENT_ROOT'] . "/Model/database/Login.class.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/Model/UserAsCustomer.php");

session_start();
$user = unserialize($_SESSION['actUser']);

$logIn = new Login();
$user->saveCart();
$logIn->logOut();


