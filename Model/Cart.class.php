<?php
require_once('Product.class.php');

/**
 * @author ngg;
 */

//include 'Product.class.php';
/*
 * A kosárt model osztálya.
 * Felelős a kosárral kapcsolatos műveletekért:
 * -termék hozáadás
 * -törlés
 * -mennyiség módosítás
 * -megtekintés
 */


class Cart
{

    /*Egy objectumot ha lementessz, nem lehet kapcsolattal serializálni, tehát csak aggregáljuk CH viselkedésést.*/
    private $products;
    private $quantities;
    private $AFA;

    function __construct()
    {
        $this->products = array();
        $this->quantities = array();
        $this->AFA = 1.27; // TODO: Az LUba egy getAFA



    }

    function getProducts()
    {
        return $this->products;
    }

    function getQuantities()
    {
        return $this->quantities;
    }

    function setProducts($products)
    {
        $this->products = $products;
    }

    function setQuantities($quantities)
    {
        $this->quantities = $quantities;
    }

    public function __toString()
    {
        $result = "";

        foreach ($this->products as $key => $value) {
            $result .= $this->products[$key] . " => " . $this->quantities[$this->products[$key]->getId()] . " db.<br>";
        }

        return $result;
    }

    /**
     * A kosárhoz hozzá adja a terméket hozzá tartozó mennyiséggel együtt.
     *
     * @param Product $product
     * @param int $quantity
     */
    public function addProduct($product, $quantity)
    {

        array_push($this->products, $product);
        $quantity[$product->getId()] = $this->quantities;


        //echo "elemek száma: " . count($this->items) . " db & " . count($this->quantity) . " db.<br>";
    }

    /**
     * Módosítja a kosárban lévő termékhez a kívánt mennyiséget.
     *
     * @param Product $product
     * @param int $quantity
     */
    public function modifyProductQuantity($product, $quantity)
    {
        $index = array_search($product, $this->products);
        $this->quantities[$this->products[$index]->getId()] = $quantity;

    }

    /**
     * Törli a kosárból a terméket és a hozzárendelt mennyiséget.
     *
     * @param Product $product
     */
    public function removeProduct($product)
    {
        $index = array_search($product, $this->products);
        if ($index !== FAlSE) {

            unset($this->quantities[$this->products[$index]->getId()]);
            unset($this->products[$index]);
        } else {
            throw new Exception("Nincs ilyen termék a kosárban!");
        }
    }

    /**
     * Kiírja listázva a kosárban lévő tételeket, és a mennyiség függvényében az árat hozzá.
     *
     * @return String htmlOutput
     */
    public function watchCart()
    {

        $result = "<div id='cart'>Cart<br>";
        foreach ($this->products as $key => $value) {
            //div id = termék id;
            $result .= "<div id='" . $value->getId() . "' class='basket_product'>"
                . "<img src='" . $value->getImg() . "' title='" . $value->getImg() . "' height=40 width=40> "
                . $value->getName() . " <input type='number' name='" . $value->getId()
                . "' min='" . $value->getMinOrder() . "' max='100' value='" . $this->quantities[$key] . "'> db"
                . "<input type='button' onclick='alert(" . $value->getId() . ")' value='Törlés'> Ár: "
                . $this->itemSub($key) . " Ft.";


            $result .= "</div>";
        }
        $result .= "Összeg: " . $this->cartSubTotal() . " Ft.";
        $result .= "</div>";

        echo $result;
    }

    /**
     * Megadott termék név alapján keres terméket a kosárban, ha van, akkor visszatér
     * Termék objektummal.
     *
     * @param String $name
     * @return Product $product
     * @return NULL
     */
    public function getProductByName($name)
    {
        foreach ($this->products as $item) {
            if ($item->getName() === $name) {
                return $item;
            }
        }

        return NULL;
    }

    /**
     * Megállapítja, hogy a kosárban lévő tételek mennyibe fognak kerülni összesen.
     *
     * @return int $amount
     */
    public function cartSubTotal()
    {
        $result = 0;

        foreach ($this->products as $key => $value) {
            $result += $this->quantities[$key] * $this->products[$key]->getPrice();
        }
        return $result;
    }

    /**
     * Kiszámítja, hogy adott tételnek mennyi az ára.
     *
     * @param int $index
     * @return int $amount
     */
    public function itemSub($index)
    {

        return $this->quantities[$index] * $this->products[$index]->getPrice();
    }

    /**
     * Megkeresi az Objektum kulcs értékét/index-ét a tömbben.
     *
     * @param $product
     * @return int $index
     */
    public function  indexOfProduct($product){
        return array_search($product, $this->products);
    }

    public function valueOfQuantity($product){
        return $this->quantities[$this->indexOfProduct($product)];
    }

}
