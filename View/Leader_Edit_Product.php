<?php
session_start();
$_SESSION["id"] = 10;
$_SESSION["email"] = "boss@company.com";
$_SESSION["password"] = "1234";
$_SESSION["right_level"] = 1;
$_SESSION["message"] = "";
/**
 * Created by PhpStorm.
 * User: ngg
 * Date: 12/9/2015
 * Time: 9:43 PM
 */
//include "Header.html";

include $_SERVER['DOCUMENT_ROOT'] . "rftCandyShop/Model/database/ConnectionHandler.class.php";
$conn = new ConnectionHandler();

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin felület</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
    <script src="script/jquery-1.11.3.js"></script>

    <script>
        function showhide(id) {

            console.log("id :" + id);
            id = "div_" + id;

            var div = document.getElementById(id);



            //console.log("--- "+ div.className);
            if(div.className === "editorOff"){
                var divOn = document.getElementsByClassName("editorOn");
                for(var i = 0; i < divOn.length; i++){
                    //console.log(divOn[i]);
                    //console.log(divOn[i].className)
                    divOn[i].className = "editorOff";
                }
                div.className = "editorOn";
}
            else {


                div.className = "editorOff";
            }

            /*
             if (div2.style.display !== "none") {
             div2.style.display = "none";
             }
             else {
             div2.style.display = "block";
             }*/
        }

        function deleteP(id) {

            var answer = confirm("Tényleg törölni akarja?");

            if (answer === true) {


                $.ajax({
                    url: 'Leader_Interface.php',
                    type: 'post',
                    data: {
                        "callFunc": "deleteP",
                        "id" : id
                    },
                    success: function (response) {
                        console.log(response);
                    }
                });

            }

        }


        function editHightlight(id){

            $.ajax({
                url: 'Leader_Interface.php',
                type: 'post',
                data: {
                    "callFunc": "editHighlight",
                    "id" : id
                },
                success: function (response) {
                    console.log(response);
                }
            });


        }
        function editPrice(id){
            console.log(id);
            $.ajax({
                url: 'Leader_Interface.php',
                type: 'post',
                data: {
                    "callFunc": "editPrice",
                    "id" : id
                },
                success: function (response) {
                    console.log(response);
                }
            });


        }
        function editStock(id){

            $.ajax({
                url: 'Leader_Interface.php',
                type: 'post',
                data: {
                    "callFunc": "editStock",
                    "id" : id
                },
                success: function (response) {
                    console.log(response);
                }
            });


        }
        function editMin(id){

            $.ajax({
                url: 'Leader_Interface.php',
                type: 'post',
                data: {
                    "callFunc": "editMin",
                    "id" : id
                },
                success: function (response) {
                    console.log(response);
                }
            });


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
            <p><u>Termék módosítása</u></p>
            <table>
                <?php

                $stmt = $conn->preparedQuery("SELECT * FROM termekek");
                $stmtHighlight = $conn->preparedQuery("SELECT * FROM kiemelesek");
                $highlits = array();

                while ($rowHighlight = $stmtHighlight->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                    $highlits[$rowHighlight[0]] = $rowHighlight[1];
                }


                while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                    $id = $row[0];


                    echo '<tr><td><p>Id: ' . $id . '</p></td><td> Név:' . $row[1] .
                        '</td><td><button id="' . $id . '" onclick="showhide(this.id)">Szerkesztés</button></td></tr>' .
                        '<tr><td colspan="3"><div id="div_' . $id . '" class="editorOff">

                            <input type="button" id="' . $id . '" value="Törlés" onclick="deleteP(this.id)">


                            Ár: <input type="number" id="' . $id . '" value="' . $row[5] . '" name="recQ"
                                class="inp" min="0" max="9999"
                                required title="Adja meg a termékből tartandó ajánlott mennyiséget!" onchange="editPrice(this.id)">
                            Raktáron tartandó: <input type="number" id="' . $id . '" value="'. $row[5].'" name="stock"
                                class="inp" min="0" max="9999"
                                required title="Adja meg a termékből miniumum rendelhető mennyiséget!" onchange="editStock(this.id)">
                            Min Rendelhető mennyiség: <input type="number" id="'.$id.'" name="recQ" class="inp" min="0" max="9999" value="'.$row[7].'"
                                                        required title="Adja meg a termékből tartandó ajánlott mennyiséget!" onchange="editMin(this.id)">
                            Kiemelés: <select id="'.$id.'" onchange="editHightlight(this.id)">';
                    foreach ($highlits as $key => $value) {
                        if ($key == $row[8]) {
                            echo '<option value="' . $key . '" selected>' . $value . '</option>';
                        } else {
                            echo '<option value="' . $key . '">' . $value . '</option>';
                        }
                    }

                    echo '</select></div></td></tr>';


                }


                ?>

            </table>

        </div>
    </div>

</div>

</body>

</html>
