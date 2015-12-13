<?php

require_once("User.class.php");
require_once $_SERVER['DOCUMENT_ROOT'] . "/rftCandyShop/Model/database/ConnectionHandler.class.php";

/**
 * Created by PhpStorm.
 * User: ngg
 * Date: 12/4/2015
 * Time: 11:56 AM
 */
class UserAsLeader extends User
{

    private $conn;

    /**
     * UserAsLeader constructor.
     */
    public function __construct($user_id, $email, $password)
    {
        parent::__construct($user_id, $email, $password);
        $this->conn = new ConnectionHandler();
    }

    /**
     * Hozzá adja, elmenti az adatbázisban az új termék adatait.
     *
     * @param Product $product
     * @return Exception|string
     */
    public function productAddStore($product)
    {
        //die("temrék neve: " . $product->getName());

        if ($this->checkProductExist($product->getName()) === FALSE) {

            try {


                $this->conn->preparedInsert("termekek",
                    array("nev", "kat_azon", "kisz_azon", "suly", "egysegar", "min_keszlet",
                        "min_rend", "kim_azon", "akcio", "reszletek", "kep"),
                    array($product->getName(), $product->getCategory(), $product->getPackage(), $product->getWeight(),
                        $product->getPrice(), $product->getMinOrder(), $product->getMinStock(), $product->getHighlight()
                    , $product->getDiscount(), $product->getDescription(), $product->getImg()));

                //die("Sql után!");

            } catch (Exception $e) {
                return new Exception("Nem sikerült elmenteni a terméket!");
            }
            //$stmt = $conn->preparedQuery("SELECT t_azon FROM termekek WHERE nev=?",array("$name"));


            return "Sikeres termék felvitel!";


        } else {

            return "Létezik már ilyen termék!";
        }

    }

    /**
     * Ellenőrzi név alapján ,hogy adott termék név foglalt-e már, vagyis létezik-e, mivel a temrék nevek egyediek.
     *
     * @param String $name
     * @return bool exist
     */
    public function checkProductExist($name)
    {
        $stmt = $this->conn->preparedQuery("SELECT count(*) FROM termekek WHERE nev=?", array($name));
        $number = $stmt->fetch(PDO::FETCH_NUM);

        //die("number: " . $number[0]);
        if ($number[0] >= 1) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

    /**
     * Törlésre jelölt termék sátuszát, kiemelését változtatja meg nem árusíthatóvá.
     * Kódja az adat táblában a nulla -> 0.
     *
     * @param int $product_id
     * @return string $message
     */
    public function productRemoveFromStore($product_id)
    {//void
        try {
            $this->conn->preparedUpdate("termekek", array("kim_azon"), array("0"), array("t_azon"), array($product_id));
        } catch (Exception $e) {
            return "Hiba, nem sikerült a törlés!";
        }

        return "Sikeres termék törlés!";

    }

    /**
     * Törlésre jelölt termék sátuszát, kiemelését változtatja meg nem árusíthatóvá.
     * Kódja az adat táblában a nulla -> 0.
     *
     * @param int $product_id
     * @param int $price
     * @return string $message
     */
    public function productEditPrice($product_id, $price)
    {
        try {
            $this->conn->preparedUpdate("termekek", array("price"), array($price), array("t_azon"), array($product_id));
        } catch (Exception $e) {
            return "Hiba, nem sikerült az ármódosítás!";
        }

        return "Sikeres ármódosítás!";
    }

    /**
     * Beállítja, hogy a termékből mennyit ajánlott a raktáron tartani.
     *
     * @param int $product_id
     * @param int $min_stock
     * @return string $message
     */
    public function productEditRecommendQuantity($product_id, $min_stock)
    {
        try {
            $this->conn->preparedUpdate("termekek", array("min_keszlet"), array($min_stock), array("t_azon"), array($product_id));
        } catch (Exception $e) {
            return "Hiba, nem sikerült az raktáron tartandó mennyiség módosítása!";
        }

        return "Sikeres ajánlott mennyiség módosítás!";

    }

    /**
     * Beállítja a termékből minimum rendelhető mennyiségét.
     *
     * @param int $product_id
     * @param int $min_quantity
     * @return string $message
     */
    public function productMinimalOrderQuantity($product_id, $min_quantity)
    {
        try {
            $this->conn->preparedUpdate("termekek", array("min_rend"), array($min_quantity), array("t_azon"), array($product_id));
        } catch (Exception $e) {
            return "Hiba, nem sikerült az minimum rendelhető mennyiség módosítása!";
        }

        return "Sikeres minimum rendelhető mennyiség módosítás!";
    }

    /**
     * Kiemelését változtatja a megadottnak megfelően.
     *
     * @param int $product_id
     * @param int $hl_name_id
     * @return string $message
     */
    public function productEditHighlighting($product_id, $hl_id)
    {
        try {
            $this->conn->preparedUpdate("termekek", array("kim_azon"), array($hl_id), array("t_azon"), array($product_id));
        } catch (Exception $e) {
            return "Hiba, nem sikerült az kiemelés módosítása!";
        }

        return "Sikeres kiemelés módosítás!";
    }

    /**
     * Összeszámolja a megrendelések alapján, hogy egyes termékekből mekkora mennyiségben rendeltek.
     *
     * @param $product_id
     * @param $start_date
     * @param $end_date
     * @return array
     */
    public function productSoldStatistic($product_id, $start_date, $end_date)
    {

        $product_quantity = array();

        //amennyiben nincs megadva a intervallum vége, a jelenlegi dátum kerül beállításra.
        if ($end_date == "" || $end_date == null) {
            $end_date = date("Y-m-d");
        }


        $orders = array();

        $stmt = $this->conn->preparedQuery("SELECT * FROM megrendelesek WHERE rend_datum >= ? AND rend_datum <= ?", array($start_date, $end_date));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            array_push($row["rend_szam"], $orders);
        }

        $orderedProducts = array();

        foreach ($orders as $order) {

            $quantity = 0;

            //meghatározott termékre, ha kivesszük a termek_id feltételt, akkor az összes termékre nézné, kényelmesebb is lenne a controller oldalon.
            $stmt = $this->conn->preparedQuery("SELECT * FROM rendeles_reszletei WHERE rend_szam = ? AND termek_id = ?", array($order, $product_id));
            while ($rowO = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {

                if (array_key_exists($rowO["termek_id"], $product_quantity)) {
                    $product_quantity[$rowO["termek_id"]] = $rowO["mennyiseg"];
                } else {
                    $product_quantity[$rowO["termek_id"]] += $rowO["mennyiseg"];
                }


            }
        }

        return $product_quantity;

    }

    /**
     * Vissza adjad a statisztika adatokat html formátumban.
     * Jó kérdés ,h ez most minek ide.
     * @return string
     */
    public function showStatistic()
    {
        $result = "";

        return $result;//String
    }
}