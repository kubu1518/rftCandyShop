<!DOCTYPE html>
<!--
Ez a kipróbáló index fájlom, ne bántsátok. :D
-->
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/rftCandyShop/Model/database/ConnectionHandler.class.php";

include 'Product.class.php';
include 'Cart.class.php';
include 'Package.class.php';
include 'Category.class.php';
include 'Highlight.class.php';


$user_id = 1;
$package = array(new Package(1, "darab"));
$category = array(new Category(1, "háztartási eszközök"));
$highlight = array(new Highlight(0, ""), new Highlight(1, "Yuhúúú, micsoda akció!"));

//    $id, $name, $package, $category, $weight, $price, $min_order, $min_stock, $discount, $highlight, $img, $description)
/*
$p = array(
    new Product(1, "TeleV", $package[0], $category[0], "5kg", 100, 1, 20, "10%", $highlight[0], "img/tv01.jpg", "This Tv is realy ok!"),
    new Product(2, "Turmixoló", $package[0], $category[0], "1.5kg", 1000, 1, 2, "30%", $highlight[1], "img/turmix01.jpg", "brrr Turmix"),
    new Product(3, "Porszívó", $package[0], $category[0], "3.5kg", 10000, 1, 20, "5%", $highlight[1], "img/por01.jpg", "brrr Porszívó"),
    new Product(4, "Mosógép", $package[0], $category[0], "30kg", 100000, 1, 10, "30%", $highlight[0], "img/por01.jpg", "brrr Mosógép"),
    new Product(5, "Mixer", $package[0], $category[0], "1.5kg", 10, 2, 12, "1%", $highlight[1], "img/mix01.jpg", "brrr Mixer")
);
/*
$c = new Cart();


for ($i = 0; $i < sizeof($p); $i++) {

    $c->addProduct($p[$i], $i);//user_id : 1
    echo $c . "<br>";
    echo $c->cartSubTotal() . " huf.<br>";
    echo "########<br>";
}

echo "------------------<p>Modify</p><br>";
echo "mod this-> " . $p[3] . "<br>";
echo $c->modifyProductQuantity($p[3], 1) . "<br>";
echo "mod this-> " . $p[4] . "<br>";
echo $c->modifyProductQuantity($p[4], 2) . "<br>";

echo $c . "<br>";
echo $c->cartSubTotal() . "<br>";

echo "<p>Termék keresés név alapján</p>";
echo "Keressük a mosógép neve alapján: " . $c->getProductByName("Mosógép") . "<br>";
echo "Keressük a Turmixoló neve alapján: " . $c->getProductByName("Turmixoló") . "<br>";


echo "<p>Termék Törlés</p><br>";
$c->removeProduct($p[0]);
echo $c;
$c->addProduct(new Product(5, "Reszelő", $package[0], $category[0], "1.5kg", 10, 2, 12, "1%", $highlight[0], "img/resz01.jpg", "brrr Reszelő"), 3);
$c->removeProduct($p[3],1);
echo $c;

$c->removeProduct(new Product(5, "Mixer", $package[0], $category[0], "1.5kg", 10, 2, 12, "1%", $highlight[1], "img/mix01.jpg", "brrr Mixer"));
echo $c;

echo $c->cartSubTotal() . " Ft<br>";

echo "##############################################<br>";
$c->watchCart();

echo "---------------SQL------------------------<br>";
/**
 * Created by PhpStorm.
 * User: ngg
 * Date: 12/3/2015
 * Time: 10:56 PM
 */

/*
$user_name = "root";
$password = "";
$database = "laravel";
$server = "127.0.0.1";

//$conn = mysqli_connect($server, $user_name, $password,$database);

/*
    //$stmt = $conn->preparedQuery("select id,name from user",array());
$sql = 'select * from usert WHERE namef="user2"';
$stmt = mysqli_query($conn,$sql);
if (!$stmt) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}

//$row = mysqli_fetch_array($stmt,MYSQLI_BOTH);

//echo $row[0];
echo "db: ".mysqli_num_rows($stmt)."<br>";

 while($row = mysqli_fetch_array($stmt,MYSQLI_BOTH)){

        echo $row[0]." ". $row[1]." ".$row[2]."<br>";

    }
*/
/*
$conn = new ConnectionHandler();


$stmt = $conn->preparedQuery('SELECT * FROM usert');// where namef=?', array("user2"));
if (!$stmt) {
printf("Error: %s\n", mysqli_error($conn));
exit();
}

$v = array();
while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
echo  $row[0]." ".$row[1]." ".$row[2]."<br>";
    $t = $row[0]." ".$row[1]." ".$row[2];
    array_push($v,$t);

}

foreach($v as $value){
  echo $value."<br>";
}

//$row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
//echo "user: ". $row[2]."<br>";

//$count = $stmt->fetch(PDO::FETCH_NUM);
//$stmt2 = $conn->preparedCountQuery('SELECT count(*) FROM usert WHERE pass= ?',array("dslfkdfhfk"));
//echo "db: ". $stmt2."<br>";

//echo "id: ".$result."<br>";
*/

/*
echo "<p>Dates</p><br>";
$tomorrow = strtotime("tomorrow");
$week = strtotime("+7 day");
$today = date("Y-m-d");
echo "Today: ".$today."<br>";
echo "Tomorrow: ".  date("Y-m-d", $tomorrow)."<br>";
echo "Today+7 day: ".  date("Y-m-d",$week)."<br>";


$d = date("Y-m-d");
$s = date("Y-m-d", $week);
$d_start = new DateTime($d);
$d_end = new DateTime($s);

$d_diff = $d_start->diff($d_end);
echo $d_diff->format("%R");
echo $d_diff->days;

//echo "diff: ". date_diff( $w, $d , FALSE) ."<br>";
*/
/*
echo date("Y-m-d h:i:s")."<br>";

$conn = new ConnectionHandler();
$product_id = 20;
$start_date = date("2015-12-01 00:00:00");
$end_date = date("2015-12-31 23:59:59");

$stmt = $conn->preparedQuery(
    "SELECT SUM(rendeles_reszletei.mennyiseg)
            FROM megrendelesek INNER JOIN rendeles_reszletei
                ON megrendelesek.rend_szam=rendeles_reszletei.rend_szam
                    AND megrendelesek.rend_datum >= ?
                    AND megrendelesek.rend_datum <= ?
                    AND rendeles_reszletei.termek_id = ?", array($start_date, $end_date, $product_id)
);

$row = $stmt->fetch(PDO::FETCH_NUM);


//var_dump($row);
echo 'q: '.$row[0];
 */



$conn = new ConnectionHandler();
$orderNumber = 2;



$stmt = $conn->preparedQuery(
    "SELECT rr.rend_szam ,r.szall_id ,r.termek_id ,sum(r.mennyiseg) as raktaron,rr.mennyiseg,sz.lejar_datum FROM `raktar` r
      INNER JOIN rendeles_reszletei rr ON r.termek_id=rr.termek_id AND r.stat_id <> 0 AND rr.rend_szam = ?
      inner JOIN szallitmanyok sz ON r.szall_id=sz.szall_id
      group BY r.termek_id
      order by r.termek_id, sz.lejar_datum",
    array($orderNumber));

while($row = $stmt->fetch(PDO::FETCH_NUM,PDO::FETCH_ORI_NEXT)){

    echo $row[0]." ".$row[1]." ".$row[2]." ".$row[3]." ".$row[4]." ".$row[5]."<br>";
    if($row[3] < $row[4]){
        echo "Nem elég a készlet hozzá!";
        break;
    }


}

echo "-------------------------<br>";

//lekérem a szállítmányokat az azokhoz a termékekhez amelyekből rendelés történt az adott azonosítóval.

// rendelés_id, szállitmány_id, termek_id, mennyiség raktáron, szükséges mennyiség , lejárati dátum
$stmt2 = $conn->preparedQuery("SELECT rr.rend_szam ,r.szall_id ,r.termek_id ,r.mennyiseg as raktaron,rr.mennyiseg,sz.lejar_datum
                                        FROM `raktar` r INNER JOIN rendeles_reszletei rr
                                        ON r.termek_id=rr.termek_id AND r.stat_id <> 0 AND rr.rend_szam = ?
                                        inner JOIN szallitmanyok sz ON r.szall_id=sz.szall_id
                                        order by r.termek_id, sz.lejar_datum",array($orderNumber));

//$raktaronDb = array();

//a szükséges mennyiség nyilvántartása kulcs: termek_id => szükséges mennyiség
$kellDb = array();


//ez előtt ellenőrzés történik ,hogy van-e elég termék raktáron, így csak akkor jutunk el ide, ha igen.

while($row = $stmt2->fetch(PDO::FETCH_NUM,PDO::FETCH_ORI_NEXT)){

    echo $row[0]." ".$row[1]." ".$row[2]." ".$row[3]." ".$row[4]." ".$row[5]."<br>";

    $termek_id = $row[2];

    //ha nem létezik a termek_id akkor belerakjuk a szükséges mennyiséget
    if(array_key_exists($row[2],$kellDb) == false ) {
        $kellDb[$termek_id] = $row[4];
    }

    //ha a szükséges mennyiség nagyobb mint nulla az adott termék_id esetén.
    if($kellDb[$termek_id] > 0){
        $raktaron = $row[3];

        //ha több kellene mint amennyi van az adott szállítmányban a termékből, vagy ugyanannyi
        if( ( ($raktaron - $kellDb[$termek_id]) < 0) ){

            $kellDb[$termek_id] = $kellDb[$termek_id] - $raktaron;
            $raktaron = 0;

            echo "update raktaron:".$raktaron." && ennyi kell meg: ".$kellDb[$termek_id]."<br>";
        }
        //több van a szállítmányban mint amennyi kell vag ugyananni
        else{

            $raktaron -= $kellDb[$termek_id];
            $kellDb[$termek_id] = 0;

            echo "update raktaron:".$raktaron ." ennyi kell meg: ".$kellDb[$termek_id]."<br>";
        }

    }


}

?>
</body>
</html>
