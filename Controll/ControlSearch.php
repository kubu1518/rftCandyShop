<?php
/**
 * Created by PhpStorm.
 * User: István
 * Date: 2015.12.12.
 * Time: 15:05
 */

require_once($_SERVER['DOCUMENT_ROOT'] . "/rftCandyShop/Model/ListingUtilities.php");


$sName = $_GET['sName'];
$sCategory = $_GET['sCategory'];

$lu = new ListingUtilities();
$result = $lu->listingProducts($sName, $sCategory);
$products = [];

session_start();
$size = count($result);
if ($size == 0) {
    echo "<p>0 találat</p>";
} else {
    echo "<p>$size találat</p>";
    foreach ($result as $product) {
//        $products[$product['t_azon']] = new Product($product);
        $tId = $product['t_azon'];
        $name = $product['nev'];

        if ($product['akcio'] > 0) {
            $decrease = $product['akcio'];
            $originPrice = $product['egysegar'];
            $price = $product['egysegar'] * (1 - ($decrease / 100));
        } else {
            $price = $product['egysegar'];
            $decrease = "";
        }

        $highlighting = $product['kim_nev'];
        $class = "";
        switch($highlighting){
            case 'akciós' :
                $class='action';
                $decrease = "-" . $decrease . "%";
                break;
            case 'árcsökkentett' :
                $class='sale';
                $decrease = "-" . $decrease . "%";
                break;
            case 'új termék' :
                $class='new';
                $decrease = "NEW";
                break;
        }




        $minOrder = $product['min_rend'];

        $image = "../View/images/product/" . $product['kep'];
        $details = $product['reszletek'];
        $cat = $product['kat_nev'];
        $pack = $product['kisz_nev'];
        $weight = $product['suly'];

        echo "<div class='productbox' id='$tId'><div class='image'>";

        if($decrease != "")
        echo "<span class='$class'>$decrease</span>";

        echo "<img src='$image' alt='$image'>";
        echo "</div><h2>$name</h2>";
        echo "<p>$price Ft + ÁFA</p>";
        if (isset($_SESSION['actUser'])) {
            echo "<input type='number' min='1' value='1' size='3' />";
            echo "<button class='pbcart'>kosárba</button>";
        }
        echo "<button class='pbdet'>részletek</button>";
        echo "<div class='details'>
              <p>Kategória: $cat</p>
              <p>Kiszerelés: $pack</p>
              <p>Súly: $weight gramm</p>
              <p>$details</p>
             </div>";
        echo "</div>";

    }

}
