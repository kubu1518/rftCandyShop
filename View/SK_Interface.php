<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/rftCandyShop/Model/database/ConnectionHandler.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/rftCandyShop/Model/UserAsStorekeeper.class.php";


$nValue = null;
$id = null;
if (isset($_POST['nValue'])) {
    $nValue = $_POST['nValue'];
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
//echo func1($_POST['callFunc1']);


$method = $_POST['callFunc'];


//meghívódik adott metódus a név alapján pl: deleteP a metódus, ekkor a deleteP(paraméter) hívódik meg.
$method($id, $nValue);

/**
 *
 */
function finalScrapping($id, $nValue)
{

    $user = new UserAsStorekeeper($_SESSION["id"], $_SESSION["email"], $_SESSION["password"]);

    $user->disposal();

}

function editStatus($id, $nValue)
{
    $user = new UserAsStorekeeper($_SESSION["id"], $_SESSION["email"], $_SESSION["password"]);

    echo "edit status id: " . $id . " , value: " . $nValue . "<br>";
    $user->orderHandling($id, $nValue);


}

function stockProductDisposal($id, $nValue)
{

    $data = json_decode($nValue);
   // var_dump($data, true);
    $user = new UserAsStorekeeper($_SESSION["id"], $_SESSION["email"], $_SESSION["password"]);


    foreach ($data as $value) {
        $termekid = $value->{"termekid"};
        $szallitmanyid = $value->{"szallitmanyid"};
        $mennyiseg = $value->{"mennyiseg"};
        $darab = $value->{"darab"};
        $stat = $value->{"stat"};

    echo $termekid." ".$szallitmanyid." ".$mennyiseg." ".$darab." ".$stat." / ";


        $user->stockProductDisposal($termekid,$szallitmanyid,$mennyiseg,$stat,$darab);
    }




}


?>