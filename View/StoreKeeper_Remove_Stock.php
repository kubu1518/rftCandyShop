<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/rftCandyShop/Model/UserAsStorekeeper.class.php";

session_start();

/**
 * Created by PhpStorm.
 * User: ngg
 * Date: 12/14/2015
 * Time: 8:46 PM
 */


$conn = new ConnectionHandler();
$message = "";


?>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Admin felület</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <script src="script/jquery-1.11.3.js"></script>
    <script src="js/Admin.js"></script>
    <script>


        $(document).ready(function () {

            $('#delete').click(function () {

               scrapping();


            });


        });



        function scrapping() {

            var answer = confirm("Tényleg törölni akarja?");

            if (answer === true) {


                $.ajax({
                    url: 'SK_Interface.php',
                    type: 'post',
                    data: {
                        "callFunc": "finalScrapping"
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

        <input type="button" id="logout" value="Kijelentkezés">
    </div>

    <div class="container">
        <div align="center" width="200px" border="1px">
            <p><u>Elszállításra váró készlet</u></p>

            <?php

            $conn = new ConnectionHandler();

            $stmt = $conn->preparedQuery(
                "select r.termek_id,(select nev from termekek where termekek.t_azon=r.termek_id) as nev,
                  r.mennyiseg,r.szall_id,r.stat_id,sz.beerk_datum,
                  (SELECT stat_nev from statusz WHERE stat_id=r.stat_id) as STAT_NEV
                    from raktar r INNER JOIN szallitmanyok sz ON
                    r.szall_id=sz.szall_id AND (r.stat_id = 0 or r.stat_id = 2 or r.stat_id = 5)"
                , null);

            while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                echo $row[0] . " " . $row[1] . " " . $row[2] . " " . $row[3] . " " . $row[4] . " " . $row[5] . " " . $row[6] . "<br>";
            }


            ?>

            <input type="button" id="delete" value="Elszálítás/Végleges selejtezés">


        </div>
    </div>

</div>

</body>

</html>
