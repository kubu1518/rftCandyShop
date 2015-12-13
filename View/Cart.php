<?php
/**
 * Created by PhpStorm.
 * User: István
 * Date: 2015.12.13.
 * Time: 11:39
 */

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


?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Candy Shop - Kosár</title>
    <link rel="stylesheet" type="text/css" href="css/base.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/Cart.js"></script>
</head>

<body>
<div id="header">
    <div class="head object1"><img src="images/cooltext151692606346986.png" name="logo" width="525" height="99"/></div>
    <div class="objectAudio">
        <audio controls>
            <source src="/rftCandyShop/Model/medias/candy_shop.mp3" type="audio/ogg">
        </audio>
    </div>
    <div class="head object2">
        <?php echo $autControl; ?>
    </div>
</div>
<div id="mainContainer">
    <div id="workzone">
        <?php
        $user->getCart()->watchCart();
        }
        ?>
    </div>
</div>
<footer>
    Copyright © DE-PTI
</footer>
</body>
</html>
