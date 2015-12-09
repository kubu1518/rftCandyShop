<?php
/**
 * Created by PhpStorm.
 * User: István
 * Date: 2015.12.02.
 * Time: 17:47
 */
?>
<!doctype html>
<head>
    <meta charset="utf-8">
    <title>Candy Shop - Bejelentkezés</title>
    <meta name="description" content="Candy Shop - Bejelentkezés">
    <meta name="author" content="Rosti">
    <link rel="stylesheet" type="text/css" href="css/base.css">
    <link rel="stylesheet" type="text/css" href="css/RegistrationForm.css">
</head>
<body>
<div id="header">
    <div class="head object1"><img src="images/cooltext151692606346986.png" name="logo" width="525" height="99"/></div>
    <div class="objectAudio">
        <audio controls>
            <source src="/CandyShop/Model/medias/candy_shop.mp3" type="audio/ogg">
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

        require_once($_SERVER['DOCUMENT_ROOT'] . '/Model/database/Login.class.php');

        $email = "";

        if (!empty($_POST)) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $login = new Login();
            $back = $login->logIn($email, $password);
            if (substr($back,0,2) !== "ok") {
                echo "<div class='info'>Hiba: $back</div>";
            }else{
                $url = $_SERVER['HTTP_REFERER'];
                $redirect = str_replace(basename($_SERVER['PHP_SELF']),substr($back,2),$url);
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
    <td></td>
    <td><input type="submit" value="Belépés" /></td>
  </tr>
</table>
</form>
_LOGIN_FORM;
        ?>

</div>
</div>
</body>
</html>
