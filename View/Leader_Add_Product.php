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
require_once $_SERVER['DOCUMENT_ROOT'] . "/rftCandyShop/Model/database/ConnectionHandler.class.php";




$conn = new ConnectionHandler();


//echo "doc: " . $_SERVER['DOCUMENT_ROOT'];



?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin felület</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
    <script>

        function checkHighlight() {

            var x = document.getElementById("highlight").selectedIndex;
            var actionInput = document.getElementById("action");
            if (x === 3) {

                actionInput.removeAttribute('disabled');
                actionInput.setAttribute("min", "1");
                actionInput.setAttribute("max", "90");
                actionInput.value = "1";
                //alert(x);
            }
            else if (x == 1) {
                actionInput.value = "50";
                actionInput.setAttribute("min", "50");
                actionInput.setAttribute("max", "75");
                actionInput.removeAttribute('disabled');
            }
            else {
                actionInput.value = "0";
                actionInput.disabled = true;
            }

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
            <p><u>Új Termék felvitele</u></p>

            <p>

                <?php
                if ($_SESSION["message"] != "") {
                    echo "Termék felvitel állapota ->" . $_SESSION['message'];
                    $_SESSION['message'] = "";
                }

                ?>
            </p>

            <form name="uj_termek" id="form1" method="post" action="LAP.php" enctype="multipart/form-data">
                <p><label>Név</label><input type="text" id="nev" class="inp" name="nev" required
                    title="Adja meg a termék nevét!"></p>

                <p><label>Kategória</label>
                    <select id="kat_azon" class="inp" name="kat_azon">
                        <?php

                        $stmt = $conn->preparedQuery("SELECT * FROM kategoriak");

                        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                            echo "<option value=" . $row[0] . ">" . $row[1] . "</option>";
                        }

                        ?>
                    </select></p>

                <p><label>Kiszerelés</label>
                    <select id='kisz_azon' class="inp" name="kisz_azon">
                        <?php
                        $stmt = $conn->preparedQuery("SELECT * FROM kiszerelesek");
                        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                            echo "<option value=" . $row[0] . ">" . $row[1] . "</option>";
                        }


                        ?>
                    </select></p>

                <p><label>Súly(gramm)</label><input type="number" id="suly" name="suly" class="inp" min="1"
                                                    max="9999" required title="Adja meg a termék súlyát!">
                </p>

                <p><label>Ár</label><input type="number" id="egysegar" name="egysegar" class="inp" min="1" max="999999"
                                           name="price" required title="Adja meg a termék árát!"></p>

                <p><label>Ajánlott menny.</label><input type="number" id="min_keszlet" name="min_keszlet" class="inp" min="0" max="9999"
                                                        required title="Adja meg a termékből tartandó ajánlott mennyiséget!"></p>

                <p><label>Min rendelhető</label><input type="number" id="min_rend" name="min_rend" class="inp" min="1" max="9999"
                                                       required title="Adja meg a termékből rendelhető minium mennyiséget!"></p>


                <p><label>Kiemelés</label><select id="kim_azon" class="inp" name="kim_azon"
                                                  onchange="checkHighlight()">;
                        <?php
                        $stmt = $conn->preparedQuery("SELECT * FROM kiemelesek");
                        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                            echo " <option value=" . $row[0] . ">" . $row[1] . "</option>";
                        }


                        echo "</select></p>";
                        ?>

                <p><label>Akció</label><input type="number" id="akcio" name="akcio" class="inp" min="0" max="50"
                                              value="0"></p>

                <p><label>Részletes leírás</label> <textarea id="reszletek" name="reszletek" maxlength="128"
                                                             rows="8" cols="50"class="inp" required
                                                             title="Adja meg a termék leírását!"></textarea></p>

                <p><label>Termék kép</label> <input type="file" name="kep" id="kep" class="inp"
                                                    accept="image/jpeg,image/gif,image/png,image/jpg" required
                                                    title="Adjon meg a termékhez képet!"></p>

                <input type="submit" id="submit " class="button" value="Termék felvitel" name="submit">
            </form>
        </div>
    </div>

</div>

</body>

</html>
