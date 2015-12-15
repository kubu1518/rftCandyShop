<?php
session_start();
$_SESSION["id"] = 10;
$_SESSION["email"] = "boss@company.com";
$_SESSION["password"] = "1234";
$_SESSION["right_level"] = 2;
$_SESSION["message"] = "";

/**
 * Created by PhpStorm.
 * User: ngg
 * Date: 12/14/2015
 * Time: 10:41 AM
 */

require_once $_SERVER['DOCUMENT_ROOT'] . "/rftCandyShop/Model/database/ConnectionHandler.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/rftCandyShop/Model/UserAsStoreKeeper.class.php";

$conn = new ConnectionHandler();
$message = "";

//echo "doc: " . $_SERVER['DOCUMENT_ROOT'];
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['submit']) && $_SESSION["right_level"] == 2) {

        /*
        echo $_POST["product"];
        echo $_POST["quantity"];
        echo $_POST["date"];

        $user = new UserAsStorekeeper($_SESSION["id"], $_SESSION["email"], $_SESSION["password"]);

       // $mess = $user->addNewRefillingProduct($_POST["product"], $_POST["quantity"], $_POST["date"]);
    */
    }
}


?>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Admin felület</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <script src="script/jquery-1.11.3.js"></script>
    <script>

        $(document).ready(function () {

            $('#scrap').click(function () {

                var selected = [];
                /*$('#checkboxes input:checked').each(function() {
                 selected.push($(this).attr('id'));
                 });*/


                jsonObj = [];

/*
 jsonObj = [];
 $("input[class=email]").each(function() {

 var id = $(this).attr("title");
 var email = $(this).val();

 item = {}
 item ["title"] = id;
 item ["email"] = email;

 jsonObj.push(item);
 });

 console.log(jsonObj);


*/


                $("input:checkbox[class=checkb]:checked").each(function () {
                    alert("Id: " + $(this).attr("id") + " Value: " + $(this).val());

                    var id = $(this).attr("id");

                    var termekid = $('#termekid_'+id).val();
                    var szallitmanyid = $('#szallitmany_'+id).val();
                    var nev = $('#nev_'+id).val();
                    var mennyiseg = $('#mennyiseg_'+id).val();
                    var datum = $('#datum_'+id).val();
                    var darab = $('#darab_'+id).val();
                    var stat = $('#stat_'+id).val();

                    item = {}
                        item["termekid"] = termekid;
                        item["szallitmanyid"] = szallitmanyid;
                        item["mennyiseg"] = mennyiseg;
                        item["darab"] = darab;
                        item["stat"] = stat;


                    jsonObj.push(item);


                  //  console.log("id: "+id+"  , termekid : "+termekid+"  , szallitmanyid : "+szallitmanyid+"  , nev : "+nev
                  //      +"  , mennyiseg : "+mennyiseg+"  , datum : "+datum+"  , darab : "+darab+"  , stat : "+stat);

                    //console.log(jsonObj);


                });

                jsonO = JSON.stringify(jsonObj);

                editProductStatus(jsonO);

            });


        });

        function editProductStatus(jsonObj) {




                $.ajax({
                    url: 'SK_Interface.php',
                    type: 'post',
                    data: {
                        "callFunc": "stockProductDisposal",
                        "id" : null,
                        "nValue" : jsonObj
                    },
                    success: function (response) {
                        console.log(response);
                        location.reload();
                    }
                })
                ;

            }







    </script>
</head>
<body>


<div class="frame">

    <div class="menu">
        <a href="StoreKeeper_Check_Stock.php">Készlet ellenőrzése</a>
        <a href="StoreKeeper_Fill_Stock.php">Készlet feltöltés</a>
        <a href="StoreKeeper_Scrapping_Stock.php">Leselejtezés</a>
        <a href="StoreKeeper_Remove_Stock.php">Elszállíttatás</a>
        <a href="StoreKeeper_Orders_Handling.php">Rendelések kezelése</a>
    </div>

    <div class="container">
        <div align="center" width="200px" border="1px">
            <p><u>Leselejtezés</u></p>

            <h3>Amennyiben olyan terméket jelöl meg selejtezésre amelynek nem járt le a szavatossági ideje,
                az sérültként lesz nyilván tartva.</h3>

            <table id="table">
                <tr>
                    <td>Id</td>
                    <td>SzId</td>
                    <td>Név</td>
                    <td>Mennyiség</td>
                    <td>Lejárati dátum</td>
                    <td><input type="button" value="LeSelejtezés" id="scrap"></td>
                    <td></td>
                </tr>
                <?php
                if ($message != "") {
                    echo "<p>.$message.</p>";
                }
                $conn = new ConnectionHandler();

                $stmt = $conn->preparedQuery("SELECT r.termek_id,r.szall_id,(select nev from termekek where t_azon=r.termek_id),
                                    r.mennyiseg,sz.lejar_datum,r.stat_id from raktar r
                                    INNER JOIN szallitmanyok sz ON r.szall_id=sz.szall_id
                                    AND (r.stat_id = 1 OR r.stat_id = 3)
                                    ORDER BY sz.lejar_datum",
                    null);

                $counter = 0;
                while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {


                    echo '<tr>
                       <td><input type="number" id="termekid_' . $counter . '" value="' . $row[0] . '" class="short" disabled></td>
                       <td><input type="number" id="szallitmany_' . $counter . '" value="' . $row[1] . '" class="short" disabled></td>
                       <td><input type="text" id="nev_' . $counter . '" value="' . $row[2] . '" class="long" disabled></td>
                       <td><input type="number" id="mennyiseg_' . $counter . '" value="' . $row[3] . '" class="short" disabled></td>
                       <td><input type="text" id="datum_' . $counter . '" value="' . $row[4] . '" class="long" disabled></td>
                       <td><input type="number" id="darab_' . $counter . '"  min="0" max="' . $row[3] . '" class="mennyiseg" ';

                        if (date("Y-m-d h:i:s") >= date($row[4])) {
                            echo 'value="' . $row[3] . '"';
                        } else {
                            echo 'value="0"';
                        }

                    /*
                       <td id="szallid_' . $counter . '">' . $row[1] . '</td>
                       <td id="nev_'.$counter.'">' . $row[2] . '</td>
                       <td id="mennyiseg_'.$counter.'">' . $row[3] . '</td>
                       <td id="datum_' . $counter . '">' . $row[4] . '</td>
                       <td><input type="number" id="darab_' . $counter . '"';

                       if (date("Y-m-d h:i:s") >= date($row[4])) {
                           echo 'value="' . $row[3] . '"';
                       } else {
                           echo 'value="0"';
                       }
*/
                    echo ' name="inp_' . $counter . '" class="inp"> db </td>
                   <td><input type="checkbox" id="' . $counter . '"  name="check_' . $row[0] . '"  value="Törlésre jelölés" class="checkb"';
                    if (date("Y-m-d h:i:s") >= date($row[4])) {
                        echo 'checked="checked"';
                    }
                    echo '><input type="number" id="stat_'.$counter.'" value="'.$row[5].'" hidden> </td></tr>';


                    /*
                    echo '<tr>
                    <td id="termekid_' . $counter . '">' . $row[0] . '</td>

                    <td id="szallid_' . $counter . '">' . $row[1] . '</td>
                    <td id="nev_'.$counter.'">' . $row[2] . '</td>
                    <td id="mennyiseg_'.$counter.'">' . $row[3] . '</td>
                    <td id="datum_' . $counter . '">' . $row[4] . '</td>
                    <td><input type="number" id="darab_' . $counter . '"';

                    if (date("Y-m-d h:i:s") >= date($row[4])) {
                        echo 'value="' . $row[3] . '"';
                    } else {
                        echo 'value="0"';
                    }

                    echo 'name="inp_' . $counter . '" class="inp"> db </td>
                <td><input type="checkbox" id="' . $counter . '"  name="check_' . $row[0] . '"  value="Törlésre jelölés" class="checkb"';
                    if (date("Y-m-d h:i:s") >= date($row[4])) {
                        echo 'checked="checked"';
                    }
                    echo '> </td></tr>';
*/
                    $counter++;
                }

                ?>
            </table>

        </div>
    </div>

</div>

</body>

</html>
