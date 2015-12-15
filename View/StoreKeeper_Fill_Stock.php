<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/rftCandyShop/Model/UserAsStorekeeper.class.php";

session_start();

/**
 * Created by PhpStorm.
 * User: ngg
 * Date: 12/14/2015
 * Time: 10:41 AM
 */


$conn = new ConnectionHandler();
$message = "";

//echo "doc: " . $_SERVER['DOCUMENT_ROOT'];
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['submit']) && $_SESSION["right_level"] == 2) {

        echo $_POST["product"];
        echo $_POST["quantity"];
        echo $_POST["date"];

        $user = new UserAsStorekeeper($_SESSION["id"], $_SESSION["email"], $_SESSION["password"]);

        $mess = $user->addNewRefillingProduct($_POST["product"], $_POST["quantity"], $_POST["date"]);
    }
}


?>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Admin felület</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
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
            if ($message != "") {
                echo "<p>.$message.</p>";
            }
            $conn = new ConnectionHandler();

            echo '<form name="termek" id="form1" method="post" action="StoreKeeper_Fill_Stock.php" enctype="multipart/form-data">';
            echo '<p><label> Válassz terméket </label ><select id = "product" class="inp" name = "product" > ';

            $stmt = $conn->preparedQuery("SELECT * FROM termekek");

            while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                echo "<option value=" . $row[0] . ">" . $row[1] . "</option>";
            }


            ?>

            </select></p>

            <p><label>Mennyiség</label><input type="number" id="quantity" name="quantity" class="inp" min="1" max="9999"
                                              required title="Adja meg a termékből érkező mennyiséget!"></p>

            <p><label>Lejárati dátum</label>
                <input type="date" id="date" name="date" required title="Kérem adja meg a lejárati időt!"></p>

            <input type="submit" id="submit " class="button" value="Termék felvitel" name="submit">
            </form>
        </div>
    </div>

</div>

</body>

</html>
