<?php
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


class Cart {

    private $items;
    private $quantity;
    private $databaseHandler;
    private $AFA;

    function __construct() {
        $this->items = array();
        $this->quantity = array();
        $this->AFA = 1.27;
    }

    function getItems() {
        return $this->items;
    }

    function getQuantity() {
        return $this->quantity;
    }

    function setItems($items) {
        $this->items = $items;
    }

    function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function __toString() {
        $result = "";
        /* foreach ($this->items as $key => $value) {
          $result.=$key . " " . $value;
          } */
        /*
          for ($i = 0; $i < count($this->items); $i++) {
          $result.= $this->items[$i] . " => " . $this->quantity[$i] . " db.<br>";
          } */

        foreach ($this->items as $key => $value) {
            $result.= $this->items[$key] . " => " . $this->quantity[$key] . " db.<br>";
        }

        return $result;
    }

    /**
     * A kosárhoz hozzá adja a terméket hozzá tartozó mennyiséggel együtt.
     * 
     * @param Product $product
     * @param int $quantity
     */
    public function addProduct($product, $quantity) {
        //$this->items[(String)$item] = $quantity; ez mükszik

        array_push($this->items, $product);

        array_push($this->quantity, $quantity);

        //echo "elemek száma: " . count($this->items) . " db & " . count($this->quantity) . " db.<br>";
    }

    /**
     * Módosítja a kosárban lévő termékhez a kívánt mennyiséget.
     * 
     * @param Product $product
     * @param int $quantity
     */
    public function modifyProductQuantity($product, $quantity) {
        //$res = "";
        $index = array_search($product, $this->items);
        /*
          echo "index: " . $index . "<br>";
          $res .="From: " . (String) $index;
          $res .=" ".(String)  $this->quantity[$index];

          foreach ($this->items as $key => $value) {
          $result.= $this->items[$key] . " => " . $this->quantity[$key] . " db.<br>";
          }

          echo "<br>";
         */
        $this->quantity[$index] = $quantity;

//$res .= " to->" . (String) $this->quantity[$index];
        //return $res;
    }

    /**
     * Törli a kosárból a terméket és a hozzárendelt mennyiséget.
     * 
     * @param Product $product
     */
    public function removeProduct($product) {
        $index = array_search($product, $this->items);

        //echo "index: " . $index . "<br>";
        unset($this->quantity[$index]);
        unset($this->items[$index]);
    }

    /**
     * Kiírja listázva a kosárban lévő tételeket, és a mennyiség függvényében az árat hozzá.
     * 
     * @return String htmlOutput
     */
    public function watchCart() {

        $result = "<div id='cart'>Cart<br>";
        foreach ($this->items as $key => $value) {
            //div id = termék id;
            $result .= "<div id='" . $value->getId() . "' class='basket_product'>"
                    . "<img src='" . $value->getImg() . "' title='" . $value->getImg() . "' height=40 width=40> "
                    . $value->getName() . " <input type='number' name='" . $value->getId()
                    . "' min='" . $value->getMinOrder() . "' max='100' value='" . $this->quantity[$key] . "'> db"
                    . "<input type='button' onclick='alert(" . $value->getId() . ")' value='Törlés'> Ár: "
                    . $this->itemSub($key) . " Ft.";


            $result .="</div>";
        }
        $result .= "Összeg: " . $this->cartSubTotal() . " Ft.";
        $result.="</div>";

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
    public function getProductByName($name) {
        foreach ($this->items as $item) {
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
    public function cartSubTotal() {
        $result = 0;
       
        foreach ($this->items as $key => $value) {
            $result += $this->quantity[$key] * $this->items[$key]->getPrice();
        }
        return $result;
    }

    /**
     * Kiszámítja, hogy adott tételnek mennyi az ára.
     * 
     * @param int $index
     * @return int $amount
     */
    public function itemSub($index) {

        return $this->quantity[$index] * $this->items[$index]->getPrice();
    }

}
