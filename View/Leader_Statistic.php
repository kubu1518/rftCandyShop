<?php
session_start();
/**
 * Created by PhpStorm.
 * User: ngg
 * Date: 12/13/2015
 * Time: 8:05 PM
 */

//include "Header.html";
require_once $_SERVER['DOCUMENT_ROOT'] . "/rftCandyShop/Model/database/ConnectionHandler.class.php";


$conn = new ConnectionHandler();


//echo "doc: " . $_SERVER['DOCUMENT_ROOT'];


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin felület</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <script src="script/jquery-1.11.3.js"></script>
    <script>

        function statistic() {

            var p = document.getElementById("product").value;
            var s = document.getElementById("startDay").value;
            var e = document.getElementById("endDay").value;

            //console.log("id: " + p + " , Sd: " + s + " Ed: " + e);

            editStock(p, (s + "_" + e));
        }

        function editStock(id, nValue) {


            $.ajax({
                url: 'Leader_Interface.php',
                type: 'post',
                data: {
                    "callFunc": "statistic",
                    "id": id,
                    "nValue": nValue
                },
                success: function (response) {
                    console.log(response);
                    var div = document.getElementById("content");

                    div.innerHTML = response + " db lett eladva az adott termékből az adott intervallumban.";
                }
            })
            ;


        }

    </script>


</head>
<body>


<div class="frame">

    <div class="menu">
        <a href="Leader_Add_Product.php">Új termék felvitele</a>
        <a href="Leader_Edit_Product.php">Termék módosítás</a>
        <a href="Leader_Statistic.php">Statisztika készítés</a>
    </div>

    <div class="container">
        <div align="center" width="200px" border="1px">
            <p><u>Statisztika</u></p>

            <p><label>Termék</label>


                <select id="product" class="inp" name="kat_azon">
                    <?php

                    $stmt = $conn->preparedQuery("SELECT * FROM termekek");

                    while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                        echo "<option value=" . $row[0] . ">" . $row[1] . "</option>";
                    }

                    ?>
                </select>
            </p>

            <p><label>Intervallum</label>
                <input type="date" id="startDay" required title="Kérem adja meg az intervallum kezdő időpontját!">
                <input type="date" id="endDay">
            </p>
            <input type="submit" id="statisticButton" value="Statisztika" onclick="statistic()">

            <div id="content"></div>


        </div>
    </div>

</div>

</body>

</html>
