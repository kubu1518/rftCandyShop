<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . "/git/rftCandyShop/Model/database/ConnectionHandler.class.php";

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

function deleteP($id){

    echo "delete: " . $id."<br>";
    $user = new UserAsLeader($_SESSION["id"],$_SESSION["email"],$_SESSION["password"]);

    echo $user->productRemoveFromStore($id);
}

function editPrice($id){

    echo "editPrice: " . $id."<br>";

    $user = new UserAsLeader($_SESSION["id"],$_SESSION["email"],$_SESSION["password"]);

    $user->productEditPrice($id,$pice); //elfelejtettem ,h kellenek a második paraméterek is, nah majd később xD
}

function editStock($id){

    echo "editStock: " . $id."<br>";
}

function editMin($id){

    echo "editMin: " . $id."<br>";
}
function editHighlight($id){

    echo "editHighlight: " . $id."<br>";
}

$method = $_POST['callFunc'];
$id = $_POST['id'];

//echo func1($_POST['callFunc1']);

//meghívódik adott metódus a név alapján pl: deleteP a metódus, ekkor a deleteP(paraméter) hívódik meg.
$method($id);

?>