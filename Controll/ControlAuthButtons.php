<?php
/**
 * Created by PhpStorm.
 * User: István
 * Date: 2015.12.13.
 * Time: 20:25
 */



require_once($_SERVER['DOCUMENT_ROOT'] . "rftCandyShop/Model/UserAsCustomer.php");

$autControl = "";

session_start();
if (!isset($_SESSION['actUser'])) {
    $autControl = <<<AUTH
    <a href='RegistrationFrom.php'>Regisztráció</a>
    <a href='LoginForm.php'>Bejelentkezés</a>
AUTH;
} else {
    $user = unserialize($_SESSION['actUser']);
    $email = $user->getEmail();
    $cartSize = $user->getCart()->getSize();
    $autControl = <<<AUTH
    <span>$email</span>
    <span id='cart'><a href="Cart.php">Kosár($cartSize)</a></span>
    <span id='logout'>Kijelentkezés</span>
AUTH;
}

echo $autControl;