<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/Model/ListingUtilities.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/Model/UserAsCustomer.php");


if (!isset($_GET["login"])) {
    $autControl = <<<AUTH
    <a href='RegistrationFrom.php'>Regisztráció</a>
    <a href='LoginForm.php'>Bejelentkezés</a>"
AUTH;
} else {
    session_start();
    if (isset($_SESSION['actUser'])) {
        $user = unserialize($_SESSION['actUser']);

        $autControl = <<<AUTH
    <span>$user->getEmail()</span>
    <span id='logout'>Kijelentkezés</span>
AUTH;
    } else die(utf8_decode("Nem létezik munkamenet"));

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Candy Shop - Kezdőoldal</title>
    <link rel="stylesheet" type="text/css" href="css/base.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">

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
                    echo "<li id='$k'>$v</li>";
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
            <input type="submit" id="submitButton" value="Keresés"/>
        </div>
        <div id="alterablecontent">
        </div>
    </div>
</div>
</body>
</html>