<?php

require_once("User.class.php");
require_once("Cart.class.php");
require_once("Product.class.php");
require_once("Order.class.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "rftCandyShop/Model/database/ConnectionHandler.class.php");

/**
 * Created by PhpStorm.
 * User: ngg, István
 * Date: 12/4/2015
 * Time: 11:50 AM
 */
class UserAsCustomer extends User
{
    private $cart;
    private $orders;
    private $actual_order;

    /**
     * UserAsCustomer constructor.
     */
    public function __construct($user_id, $email, $password)
    {
        parent::__construct($user_id, $email, $password);
        $this->orders = array(); /*ideiglenesen mert ez egy picitt bonyolult lesz*/
        $this->cart = $this->loadCart();
    }

    /**
     * @return mixed
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param mixed $cart
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
    }

    /**
     * @return mixed
     */
    public function getActualOrder()
    {
        return $this->actual_order;
    }

    /**
     * @param mixed $actual_order
     */
    public function setActualOrder($actual_order)
    {
        $this->actual_order = $actual_order;
    }


    /**
     * @return mixed
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @param mixed $orders
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;
    }

    /**
     * A Rendelés megkezdését végzi el, begyűjti a szállítási adatokat, termékeket, mennyiségeket, összeget.
     * @param $delivery_address
     * @param $bill_address
     * @param $products
     * @param $quantities
     * @param $amount
     */
    public function orderStart($delivery_address, $bill_address)
    {//void

        $this->setActualOrder(new Order(new Date("Y-m-d"), $delivery_address, $bill_address, StatusEnum::OSSZE_ALLITAS_ALATT,
            $this->getCart()->getItems(), $this->getCart()->getQuantity, $this->getCart()->cartSubTotal()));
    }

    public function orderFinalize()
    {//boolean

    }

    /**
     * Lementi a Cart objektumban lévő összes tételt.
     *
     * Külön szedem két halmazra a kosár tartalmát.
     * 1. amelyek már bent vannak az sql táblában -> Update kell,
     * 2. amelyek nincsennek az adat táblában, azoknak -> Insert kell.
     *
     * Ha a Cart osztályban történnének az sql műveletek, akkor nem kellene itt szétválogatni.
     */
    public function saveCart()
    {//void
        $conn = new ConnectionHandler();
        //bejárjuk a kosárban lévő termékek listáját.
        foreach ($this->getCart()->getProducts() as $value) {

            $quantity = $this->getCart()->valueOfQuantity($value);

            //ami benne van, arra mindre megy az update.
            $count = $conn->preparedCountQuery("SELECT count(*) FROM kosar WHERE u_id = ? AND termek_id = ?",
                array($this->getId(), $value->getId()));




            if ($count[0] >= 1) {
                //amelyek szerepelnek a Kosar táblában, updatet kapnak a mennyiseg oszlopra.
                $conn->preparedUpdate("Kosar", array("mennyiseg"), array($quantity),
                    "u_id = ? and termek_id = ?", array($this->getId(), $value->getId()));

            } else {
//amelek eddig nem voltak a Kosar táblában beszúrásra kerülnek.

                $conn->preparedInsert("Kosar", array("u_id", "termek_id", "mennyiseg"), array($this->getId(), $value->getId(), $quantity));
            }
        }

        ///$this->conn->close(); azért se zárom be :D

    }

    /**
     * Lekéri az adatbázisból az Ügyfélhez tartozó kosár tartalmát,
     * majd beállítja a Cart objektum értékét a lekért adatokból.
     */
//    public function loadCart()
//    {
//        //termék id összegűjtése a user_id alapján
//        $stmt = $this->conn->preparedQuery("SELECT * FROM Kosar WHERE u_id = ?", array($this->getId()));
//        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
//
//            //a termék adatok összegűjtése a termék_id alapján (row[1])
//            $stmtProduct = $this->conn->preparedQuery("SELECT * FROM Termekek WHERE t_azon=?", array($row[1]));
//            while ($rowProduct = $stmtProduct->fetch(PDO::FETCH_NUM)) {
//                //használandó objektumok adatainak össze szedése: kategória, csomag, kiemelés
//                $category = new Category($rowProduct[3]);
//                //$category->setName($category->selectName($this->getId()));
//                /*
//                 * átköltöztetve a konstrukorba, ha nem szép dolog, akkor hazsnálom ezt itt, minden esetre ott
//                 * kevesebb metódus hívás
//                */
//                $pack = new Package($rowProduct[2]);
//                //$pack->setName($pack->selectName($this->getId()));
//                $highlight = new Highlight($rowProduct[9]);
//                //$highlight->setName($highlight->selectName($highlight->getId()));
//
//                //termék összeállítása és hozzáadása a kosárhoz
//                $this->cart->addProduct(new Product($rowProduct[0], $rowProduct[1], $pack, $category, $rowProduct[4], $rowProduct[5],
//                    $rowProduct[6], $rowProduct[7], $rowProduct[8], $highlight, $rowProduct[10], $rowProduct[11]), $row[2]); //$row[2] a mennyiség
//            }
//        }
//
//    }

    public function loadCart()
    {
        $conn = new ConnectionHandler();
        $products = [];
        $quantities = [];
        //termék id összegűjtése a user_id alapján
        $stmt = $conn->preparedQuery("SELECT * FROM Kosar WHERE u_id = ?", array($this->getId()));
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            //a termék adatok összegűjtése a termék_id alapján (row[termek_id])
            $stmtProduct = $conn->preparedQuery("SELECT * FROM Termekek WHERE t_azon=?", array($row["termek_id"]));
            while ($rowProduct = $stmtProduct->fetch(PDO::FETCH_ASSOC)) {
                  $products[$rowProduct['t_azon']] = Product::createProductByArray($rowProduct);
                  /*Csak t_azonnal indexelem mert ha esetleg lesz szükség még másra is a termékből, nem csak a nevére, mikor
                  a kosárba kiírjuk, akkor ott legyen minden*/
                  $quantities[$rowProduct['t_azon']] = $row['mennyiseg'];
            }
        }
        return new Cart($products,$quantities);

    }

    /**
     *A felhasználó rendelései
     */
    public function loadOrders(){

    }

    /**
     * Van e egyáltalán a kosár táblában az adott felhasználóhoz tartozó sor?
     * @return boolean
     */
    public function hasACart(){
        $conn = new ConnectionHandler();
        $stmt = $conn->preparedQuery("SELECT * FROM kosar WHERE u_id = ?",array($this->getId()));
        if($stmt->fetch(PDO::FETCH_BOTH)){
            $conn->close();
            return true;
        }else{
            $conn->close();
            return false;
        }
    }
}