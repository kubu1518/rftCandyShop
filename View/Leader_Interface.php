<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . "/rftCandyShop/Model/database/ConnectionHandler.class.php";
include $_SERVER['DOCUMENT_ROOT'] . "/rftCandyShop/Model/UserAsLeader.php";

/**
 * @param $datas
 */
/*
function addNewProduct($datas)
{
   $parameter = array();

    foreach($datas as $v){
        array_push($parameter,$v);
    }

    $conn = new ConnectionHandler();
/*
        $conn->preparedInsert("termekek", array(
            "nev",
            "kat_azon",
            "kisz_azon",
            "suly",
            "egysegar",
            "min_keszlet",
            "min_rend",
            "kim_azon",
            "akcio",
            "reszletek",
            "kep"
        )
            , $datas);
*/
/*
$result = "";
    foreach($parameter as $value){
       // echo "-->>".$value."<br>";
        $result .= $value." ";

    }
    echo "success!".$result;
}
*/

function deleteP($id, $nValue)
{

    echo "delete: " . $id . "<br>";
    $user = new UserAsLeader($_SESSION["id"], $_SESSION["email"], $_SESSION["password"]);

    echo $user->productRemoveFromStore($id);
}

function editPrice($id, $nValue)
{

    echo "editPrice: " . $id . "<br>";

    $user = new UserAsLeader($_SESSION["id"], $_SESSION["email"], $_SESSION["password"]);

    $user->productEditPrice($id, $nValue); //elfelejtettem ,h kellenek a második paraméterek is, nah majd később xD
}

function editStock($id, $nValue)
{

    echo "editStock: " . $id . "<br>";
    $user = new UserAsLeader($_SESSION["id"], $_SESSION["email"], $_SESSION["password"]);

    $user->productEditRecommendQuantity($id, $nValue);
}

function editMin($id, $nValue)
{

    echo "editMin: " . $id . "<br>";
    $user = new UserAsLeader($_SESSION["id"], $_SESSION["email"], $_SESSION["password"]);
    $user->productMinimalOrderQuantity($id, $nValue);
}

function editHighlight($id, $nValue)
{

    echo "editHighlight: " . $id . " " . $nValue . ".<br>";
    $user = new UserAsLeader($_SESSION["id"], $_SESSION["email"], $_SESSION["password"]);
    $user->productEditHighlighting($id, $nValue);
}

function editDiscount($id, $nValue)
{

    echo "editDiscount: " . $id . " " . $nValue . ".<br>";

    $user = new UserAsLeader($_SESSION["id"], $_SESSION["email"], $_SESSION["password"]);
    $user->productEditDiscount($id, $nValue);
}

$method = $_POST['callFunc'];
$id = $_POST['id'];
$nValue = null;
if (isset($_POST['nValue'])) {
    $nValue = $_POST['nValue'];
}
//echo func1($_POST['callFunc1']);

//meghívódik adott metódus a név alapján pl: deleteP a metódus, ekkor a deleteP(paraméter) hívódik meg.
$method($id, $nValue);

?>