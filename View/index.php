<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "rftCandyShop/Model/ListingUtilities.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "rftCandyShop/Model/UserAsCustomer.php");



session_start();
if (!isset($_SESSION['actUser'])) {
    $autControl = <<<AUTH
    <a href='RegistrationFrom.php'>Regisztráció</a>
    <a href='LoginForm.php'>Bejelentkezés</a>
AUTH;
} else {
        $user = unserialize($_SESSION['actUser']);
        $email = $user->getEmail();
        $cartSize = $user->getCart()->getSize();
        $autControl = <<<AUTH
    <span>$email</span>
    <span id='cart'>Kosár($cartSize)</span>
    <span id='logout'>Kijelentkezés</span>
AUTH;
    }


?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Candy Shop - Kezdőoldal</title>
    <link rel="stylesheet" type="text/css" href="css/base.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/productbox.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/Customer.js"></script>
</head>

<body>
<div id="header">
    <div class="head object1"><img src="images/cooltext151692606346986.png" name="logo" width="525" height="99"/></div>
    <div class="objectAudio">
        <audio controls>
            <source src="/CandyShop/Model/medias/candy_shop.mp3" type="audio/ogg">
        </audio>
    </div>
    <div class="head object2">

        <?php echo $autControl; ?>

    </div>
</div>
<div id="mainContainer">
    <div id="workzone">
        <nav>
            <span>Kategóriák</span>
            <ul>
                <?php
                $lu = new ListingUtilities();
                $categories = $lu->listingProductsGroups();
                foreach ($categories as $k => $v) {
                    echo "<li id='$k' class='category'>$v</li>";
                }
                ?>
                <!--<li><button type="button" class=navbutton>Rendeléseim megtekintése</button></li>-->
            </ul>
        </nav>
        <div class="objectSearch">
            <label for="searchName">Termék neve: </label><input type="text" name="searchInput" id="searchName"/>
            <label for="searchCategory">Kategória:</label>
            <select id="searchCategory" name="searchCategory">
                <?php
                foreach ($categories as $k => $v) {
                    echo "<option value='$k'>$v</option>";
                }
                ?>
            </select>
            <input type="button" id="search" value="Keresés"/>
        </div>
        <div id="alterablecontent">
        </div>
    </div>
</div>
<footer>
    Copyright © DE-PTI
</footer>
</body>
</html>