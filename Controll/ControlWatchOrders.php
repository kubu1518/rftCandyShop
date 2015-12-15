<?php
/**
 * Created by PhpStorm.
 * User: István
 * Date: 2015.12.14.
 * Time: 22:41
 */

require_once($_SERVER['DOCUMENT_ROOT'] . "rftCandyShop/Model/UserAsCustomer.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "rftCandyShop/Model/ListingUtilities.php");
session_start();
$user = unserialize($_SESSION['actUser']);

$lu = new ListingUtilities();
$array = $lu->listingCustomerOrdersByItsId($user->getId());
$orders = $array[0];
$orderDetails = $array[1];



foreach($orders as $o){
    $orderNum = $o["rend_szam"];
    $orderDate = $o["rend_datum"];
    $delAddress = $o["szall_cim"];
    $billAddress = $o["szam_cim"];
    $status = $o["stat_megnev"];


    echo "<div id=' $orderNum '><table>";
    echo <<<Otable
            <tr>
                <th>Rendelés szám</th>
                <th>Rendelés dátuma</th>
                <th>Szállítási cím</th>
                <th>Számlázási cím</th>
                <th>Rendelés státusza</th>
            </tr>
            <tr>
                <td>$orderNum</td>
                <td>$orderDate</td>
                <td>$delAddress</td>
                <td>$billAddress</td>
                <td>$status</td>
            </tr>

Otable;



    echo " </table>";

    echo "<div id='prod'><table>";

    echo "<th>Termékkép</th><th>Név</th><th>Mennyiség</th><th>Ár</th>";
    $subtotal = 0;
    foreach ($orderDetails[$orderNum] as $product) {
        $image = "../View/images/product/" . $product['kep'];
        $name = $product['nev'];
        $quantitiy = $product['mennyiseg'];
        $price = $product['osszeg'];

        $subtotal += $price;
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
    echo "Összesen fizetett: $subtotal Ft";
    echo "</div>";

    echo "</div>";

}