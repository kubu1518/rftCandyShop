<?php

?>

<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Candy Shop - Bejelentkezés</title>
    <meta name="description" content="Candy Shop - Bejelentkezés">
    <meta name="author" content="Rosti">

</head>
<body>


<?php
/**
 * Created by PhpStorm.
 * User: István
 * Date: 2015.12.02.
 * Time: 17:47
 */

require_once($_SERVER['DOCUMENT_ROOT'].'/Model/database/Registration.class.php');

$email = "";

if(!empty($_POST)){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $reg = new Registration();
    $back = $reg->registration($email,$password);
    echo "<div class='info'>$back</div>";
}

$selfpage = htmlspecialchars($_SERVER["PHP_SELF"]);

echo <<<_LOGIN_FORM
<form action=$selfpage method="post">
<table width="454" height="406" border="1" cellpadding="10" cellspacing="10">
  <tr>
    <td><label>Email cím:</label></td>
    <td><input type="text" name="email" value="$email" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label>Jelszó:</label></td>
    <td><input type="password" name="password" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="Küldés" /></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
_LOGIN_FORM;



?>

</body>
</html>
