<?php
/**
 * Created by PhpStorm.
 * User: István
 * Date: 2015.12.13.
 * Time: 20:59
 *
 */

require_once($_SERVER['DOCUMENT_ROOT'] . "/rftCandyShop/Model/UserAsCustomer.php");
session_start();
$user = unserialize($_SESSION['actUser']);
$cart = $user->getCart();

$result = "<div id='bigtext'><div>Kosár</div></div></div><div id='cartdiv'><p>Jelenlegi tartalom:</p><div id='content'>";
foreach ($cart->getProducts() as $key => $value) {
    $image = "../View/images/product/" . $value->getImg();
    //div id = termék id;
    $result .= "<div id='" . $value->getId() . "' class='basket_product'>"
        . "<img src='" . $image . "' title='" . $value->getImg() . "' height=40 width=40><span> "
        . $value->getName() . "</span> <input type='number' class='numinput' name='" . $value->getId()
        . "' min='" . $value->getMinOrder() . "' max='100' value='" . $cart->getQuantities()[$key] . "'> <span>db</span>"
        . "<input type='button' class='delete' name='" . $value->getId()  . "' value='Törlés'> <span>Ár(ÁFA-val):  "
        . $cart->itemSub($key) . " Ft. </span>";

    $result .= "</div>";
}
$result .= "</div><span> Összeg: " . $cart->cartSubTotal() . " Ft. </span>";
$result .= "<button id='nexttoorder'>Pénztár</button>";
$result .= "<button id='backtoindex'>Vissza</button>";
$result .= "</div>";
echo $result;

