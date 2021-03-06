<?php
require_once('Product.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . "/rftCandyShop/Model/database/ConnectionHandler.class.php");

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

    function __construct($products, $quantities)
    {
        $this->products = $products;
        $this->quantities = $quantities;
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
            $result .= $this->products[$key] . " => " . $this->quantities[$key] . " db.<br>";
        }

        return $result;
    }


    /**
     *A kosárban lévő tételek száma
     * @return int
     */
    public function getSize()
    {
        return count($this->products);
    }

    /**
     * A kosárhoz hozzá adja a terméket hozzá tartozó mennyiséggel együtt.
     * A products arrayben a termék id-je az index
     * és ugyan ezzel indexelem a qauntities tömböt, így te megoldásod is maradhat és egyértelmű.
     *
     * @param Product $product
     * @param int $quantity
     */
    public function addProduct($product, $quantity)
    {
        if (!isset($this->products[$product->getId()])) {
            $this->products[$product->getId()] = $product;
            $this->quantities[$product->getId()] = $quantity;
        } else {
            $this->quantities[$product->getId()] += $quantity;
        }

        //echo "elemek száma: " . count($this->items) . " db & " . count($this->quantity) . " db.<br>";
    }

    /**
     * Módosítja a kosárban lévő termékhez a kívánt mennyiséget.
     *
     * @param Product $product
     * @param int $quantity
     */
    public function modifyProductQuantity($productId, $quantity)
    {
        $this->quantities[$productId] = $quantity;
    }

    /**
     * Törli a kosárból a terméket és a hozzárendelt mennyiséget.
     *
     * @param Product $product
     * @throws Exception
     */
    public function removeProduct($productid)
    {
        unset($this->quantities[$productid]);
        unset($this->products[$productid]);

    }

    /**
     * Kiírja listázva a kosárban lévő tételeket, és a mennyiség függvényében az árat hozzá.
     *
     * @return String htmlOutput
     */


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
            $result += $this->itemSub($key);
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

        return $this->quantities[$index] * ($this->products[$index]->getPrice() * $this->AFA);
    }

    /**
     * Megkeresi az Objektum kulcs értékét/index-ét a tömbben.
     *
     * @param $product
     * @return int $index
     */
    public function  indexOfProduct($product)
    {
        return array_search($product, $this->products);
    }

    public function valueOfQuantity($product)
    {
        return $this->quantities[$this->indexOfProduct($product)];
    }


}
