<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Candy Shop - Regisztráció</title>
    <meta name="description" content="Candy Shop - Regisztráció">
    <meta name="author" content="Rosti">
    <link rel="stylesheet" type="text/css" href="css/base.css">
    <link rel="stylesheet" type="text/css" href="css/RegistrationForm.css">
</head>
<body>
<div id="header">
    <div class="head object1"><img src="images/cooltext151692606346986.png" name="logo" width="525" height="99"/></div>
    <div class="objectAudio">
        <audio controls>
            <source src="rft/CandyShop/Model/medias/candy_shop.mp3" type="audio/ogg">
        </audio>
    </div>
</div>
<div id="mainContainer">
    <div id="workzone">

        <?php
        /**
         * Created by PhpStorm.
         * User: István
         * Date: 2015.12.02.
         * Time: 17:47
         */

        require_once($_SERVER['DOCUMENT_ROOT'] . '/rftCandyShop/Model/database/Registration.class.php');

        $email = "";

        if (!empty($_POST)) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordC = $_POST['passwordc'];
            $reg = new Registration();
            $back = $reg->registration($email, $password, $passwordC);
            if ($back !== "ok") {
                $error = explode(":", $back);
                foreach ($error as $e) {
                    if ($e !== "")
                        echo "<div class='info'>Hiba: $e</div>";
                }
            }else{
                $url = $_SERVER['HTTP_REFERER'];
                $redirect = str_replace(basename($_SERVER['PHP_SELF']),"RegSucces.php",$url);
                header("Location: $redirect");
            }

        }

        $selfpage = htmlspecialchars($_SERVER["PHP_SELF"]);

        echo <<<_LOGIN_FORM
<form action=$selfpage method="post">
<table>
  <tr>
    <th><label>Email cím:</label></th>
    <td><input type="text" name="email" value="$email" /></td>
  </tr>
  <tr>
    <th><label>Jelszó:</label></th>
    <td><input type="password" name="password" /></td>
  </tr>
  <tr>
    <th><label>Jelszó újra:</label></th>
    <td><input type="password" name="passwordc" /></td>
  </tr>
  <tr>
    <td></td>
    <td><input type="submit" value="Küldés" /></td>
  </tr>
</table>
</form>
_LOGIN_FORM;
        ?>

    </div>
</div>
<footer>
    Copyright © DE-PTI
</footer>
</body>
</html>
