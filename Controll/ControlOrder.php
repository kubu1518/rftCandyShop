<?php
/**
 * Created by PhpStorm.
 * User: István
 * Date: 2015.12.14.
 * Time: 10:00
 */


require_once($_SERVER['DOCUMENT_ROOT'] . "rftCandyShop/Model/UserAsCustomer.php");
session_start();
$user = unserialize($_SESSION['actUser']);
$cart = $user->getCart();

echo '<div id="orders"><p>A rendelni kívánt termékeid</p><table>';
echo "<th>Termékkép</th><th>Név</th><th>Mennyiség</th><th>Ár</th>";
foreach ($cart->getProducts() as $pid => $product) {
    $image = "../View/images/product/" . $product->getImg();
    $name = $product->getName();
    $quantitiy = $cart->getQuantities()[$pid];
    $price = $cart->itemSub($pid);
    echo <<<LINE
        <tr>
        <td><img src="$image" title="$image" height=40 width=40></td>
        <td>$name</td>
        <td>$quantitiy</td>
        <td>$price Ft (ÁFA-val)</td>
        </tr>
LINE;
}
echo '</table>';
echo "<p>Fizetendő: " . $cart->cartSubTotal() . " Ft</p>";
echo '</div>';


echo <<< deliverychoose
        <div id="deliverychoose">
        <p>Válassz szálllítási módot</p>
        <input type="radio" name="delch" value="1" checked>Átveszem a sarki csemegében</input>
        <input type="radio" name="delch" value="2">Házhozszállítás</input>
        </div>
deliverychoose;

echo "<div id='address'>";

echo <<< deliveryAddress
    <div id="deliveryadd">
    <p>Szállítási cím</p>
    <table>
        <tr>
           <th>Név</th>
           <td><input type="text" name="delname"></input></td>
        </tr>
         <tr>
           <th>Cím</th>
           <td><input type="text" name="deladd"></input></td>
        </tr>

    </table>
    </div>
deliveryAddress;

echo "<label for='showBA'>A szállítási cím megegyezik a számlázási címmel</label><input type='checkbox' name='showBA'/>";

echo <<< billingAddress
    <div id="billingadd">
    <p>Számlázási cím</p>
    <table>
        <tr>
           <th>Név</th>
           <td><input type="text" name="billname"></input></td>
        </tr>
         <tr>
           <th>Cím</th>
           <td><input type="text" name="billadd"></input></td>
        </tr>
    </table>
    </div>
billingAddress;

echo "</div>";

echo "<button id ='pay'>Tovább a fizetéshez</button>";
