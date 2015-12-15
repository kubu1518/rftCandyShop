<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/rftCandyShop/Model/UserAsStorekeeper.class.php";

session_start();
$user = unserialize($_SESSION['actUser']);


$_SESSION["id"] = $user->getId();
$_SESSION["email"] = $user->getEmail();
$_SESSION["password"] = $user->getPassword();
$_SESSION["right_level"] = 2;
$_SESSION["message"] = "";
/**
 * Created by PhpStorm.
 * User: ngg
 * Date: 12/14/2015
 * Time: 10:41 AM
 */


$conn = new ConnectionHandler();


//echo "doc: " . $_SERVER['DOCUMENT_ROOT'];


?>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Admin felület</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <script src="script/jquery-1.11.3.js"></script>
    <script src="js/Admin.js"></script>
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
            <p><u>Készlet ellenőrzése</u></p>

            <?php
            $conn = new ConnectionHandler();
            $stmt = $conn->preparedQuery(
                "SELECT r.termek_id,
                    (select termekek.nev from termekek where termekek.t_azon = r.termek_id) AS Nev,
                    (select termekek.min_keszlet from termekek where termekek.t_azon = r.termek_id) MinKeszlet,
                    sum(r.mennyiseg) AS Raktaron FROM raktar r
                      INNER JOIN szallitmanyok sz
                        ON r.szall_id=sz.szall_id
                        AND r.stat_id = 1
                          group BY r.termek_id", null);


            echo '<table><tr><td>Azonosító</td><td>Termék név</td><td>Ajánlott készlet</td><td>Raktáron</td></tr>';

            while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {

                if( ($row[2]/2) > $row[3] ) {
                    echo '<tr><td>' . $row[0] . '</td><td>' . $row[1] . "</td><td>" . $row[2] . '</td><td>' . $row[3] . '</tr></tr>';
                }
            }

            ?>
            </table>

        </div>
    </div>

</div>

</body>

</html>
