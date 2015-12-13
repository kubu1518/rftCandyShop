<?php
/**
 * Created by PhpStorm.
 * User: István
 * Date: 2015.12.13.
 * Time: 20:59
 *
 */

require_once($_SERVER['DOCUMENT_ROOT'] . "rftCandyShop/Model/UserAsCustomer.php");
session_start();
$user = unserialize($_SESSION['actUser']);
$cart = $user->getCart();

$result = "<div id='cartdiv'>Cart<br>";
foreach ($cart->getProducts() as $key => $value) {
    $image = "../View/images/product/" . $value->getImg();
    //div id = termék id;
    $result .= "<div id='" . $value->getId() . "' class='basket_product'>"
        . "<img src='" . $image . "' title='" . $value->getImg() . "' height=40 width=40> "
        . $value->getName() . " <input type='number' class='numinput' name='" . $value->getId()
        . "' min='" . $value->getMinOrder() . "' max='100' value='" . $cart->getQuantities()[$key] . "'> db"
        . "<input type='button' class='delete' name='" . $value->getId()  . "' value='Törlés'> Ár(ÁFA-val):  "
        . $cart->itemSub($key) . " Ft.";

    $result .= "</div>";
}
$result .= "Összeg: " . $cart->cartSubTotal() . " Ft.";
$result .= "<button id='nexttoorder'>Pénztár</button>";
$result .= "</div>";
echo $result;

