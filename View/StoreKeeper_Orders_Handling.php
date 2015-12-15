<?php
session_start();
$_SESSION["id"] = 10;
$_SESSION["email"] = "boss@company.com";
$_SESSION["password"] = "1234";
$_SESSION["right_level"] = 2;
$_SESSION["message"] = "";


/**
 * Created by PhpStorm.
 * User: ngg
 * Date: 12/14/2015
 * Time: 8:46 PM
 */


require_once $_SERVER['DOCUMENT_ROOT'] . "/rftCandyShop/Model/database/ConnectionHandler.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/rftCandyShop/Model/UserAsStoreKeeper.class.php";

$conn = new ConnectionHandler();
$message = "";


?>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Admin felület</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <script src="script/jquery-1.11.3.js"></script>

    <script>

        function editStatus(id, nValue) {

            var answer = confirm("Tényleg változtatni akarja az "+id + " azonosítójú rendelés státuszát erre: "+nValue+" ?");

            if (answer === true) {


                $.ajax({
                    url: 'SK_Interface.php',
                    type: 'post',
                    data: {
                        "callFunc": "editStatus",
                        "id" : id,
                        "nValue" : nValue
                    },
                    success: function (response) {
                        console.log(response);
                        location.reload();
                    }
                })
                ;

            }

        }
    </script>
</head>
<body>


<div class="frame">

    <div class="menu">
        <a href="StoreKeeper_Check_Stock.php">Készlet ellenőrzése</a>
        <a href="StoreKeeper_Fill_Stock.php">Készlet feltöltés</a>
        <a href="StoreKeeper_Scrapping_Stock.php">Leselejtezés</a>
        <a href="StoreKeeper_Remove_Stock.php">Elszállíttatás</a>
        <a href="StoreKeeper_Orders_Handling.php">Rendelések kezelése</a>
    </div>

    <div class="container">
        <div align="center" width="200px" border="1px">
            <p><u>Rendelések</u></p>
<table>
            <?php

            $stmt = $conn->preparedQuery(
                "select m.rend_szam,(SELECT nev from termekek where t_azon=r.termek_id) as Termek,r.mennyiseg,m.statusz_id
                    FROM megrendelesek m INNER JOIN rendeles_reszletei r
                    ON m.rend_szam=r.rend_szam ORDER BY m.statusz_id", null);


            $rend = array();
            $stat = array();

            while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
                $id = $row[0];
              //  var_dump($row);

                if(array_key_exists($id,$rend)){
                    $rend[$id] .= $row[2]." db ". $row[1]."<br>";
                }
                else{
                    $rend[$id] = $row[2]." db ". $row[1]."<br>";
                    $stat[$id] = $row[3];
                    //echo "stat_id: ". $row[3]."<br>";
                    /*if(array_key_exists($id,$stat) == false) {
                        $stat[$id] = $row[3];
                        echo "stat:: " . $stat[$id] . "<br>";
                    }*/
                }

            }

            //var_dump($stat);

            $stmtOrderStatus = $conn->preparedQuery(
                "select * from megrendeles_statusz", null);

            $statuszok = array();

            while ($row = $stmtOrderStatus->fetch(PDO::FETCH_BOTH)) {
                $statuszok[$row[0]] = $row[1];
            }

            echo '<tr><td>Rendelés azonosító</td><td>Termékek</td><td>Rendelés státusza</td></tr>';
            foreach ($rend as $rend_id => $item) {
               // echo $rend_id . " * " . $item . " * " . $stat[$rend_id] . "<br>";
echo '<tr><td>'.$rend_id.'</td><td>'.$item.'</td><td><select id="'.$rend_id.'"';
                if ($stat[$rend_id] == 3) {

                    echo ' disabled';
                }

                    echo ' onchange="editStatus(this.id, this.value)">';


                foreach ($statuszok as $statusz_id => $vv) {
                   // echo '<option value="' . $key . '" selected>' . $value . '</option>';
                    if(  ($stat[$rend_id] > 1) && $statusz_id == 1 ){
                        continue;
                    }
                    echo '<option value=" '. $statusz_id .'"';
                    if ($statusz_id == $stat[$rend_id]) {
                        echo " selected ";
                    }
                   // echo "kk:" . $statusz_id . " vv: " . $vv;

                    echo '> '. $vv .' </option>';
                }

            }
            echo '></td></tr>';

/*
$id = 0;


            foreach($rend as $key=>$value) {
                foreach ($statuszok as $skey => $svalue) {

                    if($skey == $stat[$key] ){
                        echo "selected ". $skey ." - ". $stat[$skey];
                    }
                    else {
                        echo "not selected ". $skey ." - ". $stat[$skey];

                    }



                }
            }
            /*

                echo '<tr><td>' . $key . '</td><td>';

                echo $value .'</td><td><select id="kim_azon" class="inp" name="kim_azon"
                                                  onchange="checkHighlight()"';


                if($stat[$key] == 3){
                    echo ' disabled';
                }
                echo '>';


                foreach($statuszok as $skey => $svalue) {
                    print "skey: " . $skey ." ---- ".$rend[$skey];
                    if($skey == $rend[$key]){

                            echo " <option value=" . $skey . " selected>" . $svalue . "</option>";

                    }
                    else{

                    echo " <option value=" . $skey . ">" . $svalue . "</option>";
                }
                }

               echo'</select></td></td></tr>';
            if($stat[$key] == 3) {
            echo "stat id:  ". $stat[$key].'<br>';
            }

            }


*/

            ?>

            </table>





        </div>
    </div>

</div>

</body>

</html>
