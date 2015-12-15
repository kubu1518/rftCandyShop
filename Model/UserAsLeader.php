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

    private static $conn;

    /**
     * UserAsLeader constructor.
     */
    public function __construct($user_id, $email, $password)
    {
        parent::__construct($user_id, $email, $password);
        self::$conn = new ConnectionHandler();
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


                self::$conn->preparedInsert("termekek",
                    array("nev", "kat_azon", "kisz_azon", "suly", "egysegar", "min_keszlet",
                        "min_rend", "kim_azon", "akcio", "reszletek", "kep"),
                    array($product->getName(), $product->getCategory(), $product->getPackage(), $product->getWeight(),
                        $product->getPrice(), $product->getMinStock(), $product->getMinOrder(), $product->getHighlight()
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
        $stmt = self::$conn->preparedQuery("SELECT count(*) FROM termekek WHERE nev=?", array($name));
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

            self::$conn->preparedUpdate("raktar", array("stat_id"), array("0"), "termek_id = ?", array($product_id));
            die("update után");
        } catch (Exception $e) {
            return "Hiba, nem sikerült a törlés/ státusz átállítás!";
        }

        return "Sikeres termék törlés!";

    }

    /**
     * Megváltoztatja a termék árát.
     *
     * @param int $product_id
     * @param int $price
     * @return string $message
     */
    public function productEditPrice($product_id, $price)
    {
        try {
            self::$conn->preparedUpdate("termekek", array("egysegar"), array($price), "t_azon = ?", array($product_id));
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
        echo "pdid: " . $product_id . " __ stock: " . $min_stock;

        try {
            self::$conn->preparedUpdate("termekek", array("min_keszlet"), array($min_stock), "t_azon = ?", array($product_id));
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
            self::$conn->preparedUpdate("termekek", array("min_rend"), array($min_quantity), "t_azon = ?", array($product_id));
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
            self::$conn->preparedUpdate("termekek", array("kim_azon"), array($hl_id), "t_azon = ?", array($product_id));
        } catch (Exception $e) {
            return "Hiba, nem sikerült az kiemelés módosítása!";
        }

        return "Sikeres kiemelés módosítás!";
    }


    public function productEditDiscount($product_id, $hl_id)
    {
        try {
            self::$conn->preparedUpdate("termekek", array("akcio"), array($hl_id), "t_azon = ?", array($product_id));
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


       // echo $start_date . "---" . $end_date . "<br>";


        /*ezzel jó sql-ben

        SELECT SUM(rendeles_reszletei.mennyiseg)
            FROM megrendelesek INNER JOIN rendeles_reszletei
                ON megrendelesek.rend_szam=rendeles_reszletei.rend_szam
                    AND megrendelesek.rend_datum >= "2015-12-01 00:00:00"
                    AND megrendelesek.rend_datum <= "2015-12-13 23:59:59"
                    AND rendeles_reszletei.termek_id = 20

        -----------------------------------------------------------------------------------------------------
            SELECT rendeles_reszletei.rend_szam,rendeles_reszletei.termek_id,rendeles_reszletei.mennyiseg,
            SUM(rendeles_reszletei.mennyiseg),  megrendelesek.rend_datum FROM megrendelesek
            INNER JOIN rendeles_reszletei ON megrendelesek.rend_szam=rendeles_reszletei.rend_szam
            AND megrendelesek.rend_datum >= "2015-12-01 00:00:00"
            AND megrendelesek.rend_datum <= "2015-12-13 23:59:59"
            AND rendeles_reszletei.termek_id = 20
            GROUP BY rendeles_reszletei.termek_id ORDER BY rendeles_reszletei.termek_id
        */
        $product_quantity = array();


        $stmt = self::$conn->preparedQuery(
            "SELECT SUM(rendeles_reszletei.mennyiseg)
            FROM megrendelesek INNER JOIN rendeles_reszletei
                ON megrendelesek.rend_szam=rendeles_reszletei.rend_szam
                    AND megrendelesek.statusz_id = 3
                    AND megrendelesek.rend_datum >= ?
                    AND megrendelesek.rend_datum <= ?
                    AND rendeles_reszletei.termek_id = ?", array($start_date, $end_date, $product_id)
        );

        $row = $stmt->fetch(PDO::FETCH_NUM);

       // var_dump($row);

       // echo 'q: ' . $row[0];
        if ($row[0] == null) {
            return 0;
        } else {
            return $row[0];
        }
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