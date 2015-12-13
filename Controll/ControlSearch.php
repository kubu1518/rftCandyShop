<?php
/**
 * Created by PhpStorm.
 * User: István
 * Date: 2015.12.12.
 * Time: 15:05
 */

require_once($_SERVER['DOCUMENT_ROOT'] . "rftCandyShop/Model/ListingUtilities.php");


$productBox = <<<PB
            <div class="productbox">
			<div class="image">
				<span class="sale">-20%</span>
				<span class="icon-star"></span>
				<a href=""><img src="1.png" alt=""></a>
			</div>
			<h2><a href="">LG G3 D855 16GB Mobiltelefon</a></h2>
			<p>150 000 Ft</p>
			<button>kosárba <span class="icon-cart"></span></button>
            </div>
PB;


$sName = $_GET['sName'];
$sCategory = $_GET['sCategory'];

$lu = new ListingUtilities();
$result = $lu->listingProducts($sName, $sCategory);
$products = [];


$size = count($result);
if ($size == 0) {
    echo "<p>0 találat</p>";
} else {
    echo "<p>$size találat</p>";
    foreach ($result as $product) {
//        $products[$product['t_azon']] = new Product($product);
        $tId = $product['t_azon'];
        $name = $product['nev'];
        if($product['akcio'] > 0){
            $decrease = $product['akcio'];
            $price =  $product['egysegar'] * (1-($decrease / 100));
        }else{
            $price = $product['egysegar'];
        }
        $minOrder = $product['min_rend'];

        $image = "../View/images/product/" .  $product['kep'];
        $details = $product['reszletek'];
        $cat = $product['kat_nev'];
        $pack = $product['kisz_nev'];
        $weight = $product['suly'];
        $highlighting = $product['kim_nev'];


        echo "<div class='productbox' id='$tId'><div class='image'>";
        if($product['akcio'] > 0){echo "<span class='sale'>-$decrease%</span>";}
        echo "<img src='$image' alt='$image'>";
        echo "</div><h2>$name</h2>";
        echo "<p>$price Ft + ÁFA</p>";
        echo "<input type='number' min='$minOrder' value='$minOrder' size='3' />";
        echo "<button class='pbcart'>kosárba</button>";
        echo "<button class='pbdet'>részletek</button>";
        echo "<div class='details'>
              <p>$cat</p>
              <p>$pack</p>
              <p>$weight gramm</p>
              <p>$details</p>
             </div>";
        echo "</div>";

    }

}
