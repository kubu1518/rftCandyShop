<?php
/**
 * Created by PhpStorm.
 * User: István
 * Date: 2015.12.14.
 * Time: 16:16
 */
require_once($_SERVER['DOCUMENT_ROOT'] . "rftCandyShop/Model/UserAsCustomer.php");
session_start();
$user = unserialize($_SESSION['actUser']);

if(isset($_GET['data'])) {
    $array = $_GET['data'];
    if (!isset($array[2]) && !isset($array[3])) {
        $delAddress = $array[0] . " " . $array[1];
        $billAddress = $delAddress;
    } else {
        $delAddress = $array[0] . " " . $array[1];
        $billAddress = $array[2] . " " . $array[3];
    }
}else{
    $delAddress = "";
    $billAddress = "";
}

$user->orderStart($delAddress,$billAddress);

$_SESSION['actUser'] = serialize($user);

echo "<div id='paying'>";
echo "<p>Fizetési módok:</p>";
echo <<<Paying
    <table>
        <tr>
            <td><input type="radio" name="paymode" value="1">Utánvéttel</input></td>
        </tr>
        <tr>
            <td><input type="radio" name="paymode" value="2">Elküldöm a bankártyámat "húzatásra"</input></td>
        </tr>
        <tr>
            <td><input type="radio" name="paymode" value="3">Megadom az aláírást</input></td>
        </tr>
    </table>
    <button id="finorder" >Megrendelés</button>
    <button id="backtoindex">Mégse</button>
Paying;
echo "</div>";
