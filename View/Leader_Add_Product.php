<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/rftCandyShop/Model/UserAsLeader.php";

session_start();
$user = unserialize($_SESSION['actUser']);


$_SESSION["id"] = $user->getId();
$_SESSION["email"] = $user->getEmail();
$_SESSION["password"] = $user->getPassword();
$_SESSION["right_level"] = 1;
$_SESSION["message"] = "";
/**
 * Created by PhpStorm.
 * User: ngg
 * Date: 12/9/2015
 * Time: 9:43 PM
 */


$conn = new ConnectionHandler();


//echo "doc: " . $_SERVER['DOCUMENT_ROOT'];



?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin felület</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <script src="script/jquery-1.11.3.js"></script>
    <script src="js/Admin.js"></script>
    <script>


        $(document).ready(function(){
            $("#highlight").change(function(){

                var h = $('#highlight').val();

if(h == 4){
  //  alert("h is 4");

    $('#action').prop('disabled',false);
    $('#action').attr("min","1");
    $('#action').attr("max","90");
    $('#action').val("1");

}
                else{
//    alert("h is not 4");

    $('#action').prop('disabled',true);
    $('#action').val("0");
}







            })
        });
/*
        function checkHighlight() {

            var x = document.getElementById("highlight").value;
            var actionInput = document.getElementById("action");

            alert(x + " - "+actionInput.value)
            if (x === 4) {
                alert(x);
                actionInput.removeAttribute('disabled');
                actionInput.setAttribute("min", "1");
                actionInput.setAttribute("max", "90");
                actionInput.value = "1";

            }
            else {
                actionInput.value = "0";
                actionInput.disabled = true;
            }

        }

*/
    </script>


</head>
<body>




<div class="frame">

    <div class="menu">
        <a href="Leader_Add_Product.php">Új termék felvitele</a>
        <a href="Leader_Edit_Product.php">Termék módosítás</a>
        <a href="Leader_Statistic.php">Statisztika készítés</a>
        <input type="button" id="logout" value="Kijelentkezés">
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


                <p><label>Kiemelés</label><select id="highlight" class="inp" name="kim_azon">;
                        <?php
                        $stmt = $conn->preparedQuery("SELECT * FROM kiemelesek");
                        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                            if($row[0] != 2) {
                                echo " <option value=" . $row[0] . ">" . $row[1] . "</option>";
                            }
                        }


                        echo "</select></p>";
                        ?>

                <p><label>Akció</label><input type="number" id="action" name="akcio" class="inp" min="0" max="50"
                                              value="0" disabled></p>

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
