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

        include $_SERVER['DOCUMENT_ROOT'] . "/git/rftCandyShop/Model/database/ConnectionHandler.class.php";
        include 'Product.class.php';
        include 'Cart.class.php';

    //    $id, $name, $package, $category, $weight, $price, $min_order, $min_stock, $discount, $highlight, $img, $description)
        $p = array(
            new Product(1, "TeleV",1,1,"5kg", 100, 1,20,"10%","Top" ,"img/tv01.jpg", "This Tv is realy ok!"),
            new Product(2, "Turmixoló",2,2,"1.5kg", 1000,1,2,"30%","Last one" ,"img/turmix01.jpg", "brrr Turmix"),
            new Product(3, "Porszívó",3,3,"3.5kg", 10000,1,20,"5%",null ,"img/por01.jpg", "brrr Porszívó"),
            new Product(4, "Mosógép",4,4,"30kg", 100000,1,10,"30%",null ,"img/por01.jpg", "brrr Mosógép"),
            new Product(5, "Mixer",5,1,"1.5kg", 10,2,12,"1%",null ,"img/mix01.jpg", "brrr Mixer")
        );

        $c = new Cart();

        for ($i = 0; $i < sizeof($p); $i++) {

            $c->addProduct($p[$i], $i);
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
        $c->addProduct(new Product(5, "Reszelő",5,1,"1.5kg", 10,2,12,"1%",null ,"img/resz01.jpg", "brrr Reszelő"),3);
        $c->removeProduct($p[3]);
        echo $c;

        $c->removeProduct(new Product(5, "Mixer",5,1,"1.5kg", 10,2,12,"1%",null ,"img/mix01.jpg", "brrr Mixer"));
        echo $c;

        echo $c->cartSubTotal() . " Ft<br>";

        echo "##############################################<br>";
        $c->watchCart();

echo "---------------SQL------------------------<br";
/**
 * Created by PhpStorm.
 * User: ngg
 * Date: 12/3/2015
 * Time: 10:56 PM
 */


$user_name = "root";
$password = "";
$database = "laravel";
$server = "127.0.0.1";

$conn = mysqli_connect($server, $user_name, $password,$database);

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
$table = "usert";
$stmt = $conn->preparedQuery('SELECT * FROM usert where namef=?', array("user2"));
if (!$stmt) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}

while($row = mysqli_fetch_assoc($stmt,MYSQLI_BOTH)){
    echo  $row["id"]." ".$row["name"]." ".$row["pass"]."<br>";
}

//echo "id: ".$result."<br>";
*/
        ?>
    </body>
</html>
