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

$size = count($result);
if ($size == 0) {
    echo "<p>0 találat</p>";
} else {
    echo "<p>$size találat</p>";
    foreach ($result as $product) {
        $tId = $product['t_azon'];
        $name = $product['nev'];
        $hasDecrease = isset($product['akcio']);
        if($hasDecrease){
            $decrease = $product['akcio'];
            $price =  $product['egysegar'] * ($decrease / 100);
        }else{
            $price = $product['egysegar'];
        }

        $image = $product['kep'];
        $details = $product['reszletek'];
        $cat = $product['kat_nev'];
        $pack = $product['kisz_nev'];
        $weight = $product['suly'];
        $highlighting = $product['kim_nev'];


        echo "<div class='productbox' id='$tId'><div class='image'>";
        if($hasDecrease){echo "<span class='sale'>-$decrease%</span>";}
        echo "<img src='$image' alt='$image'>";
        echo "</div><h2>$name</h2>";
        echo "<button>kosárba</button>";
        echo "<button>részletek</button>";
        echo "</div>";
    }
}
