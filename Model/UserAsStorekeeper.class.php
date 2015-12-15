<?php
require_once("User.class.php");
require_once $_SERVER['DOCUMENT_ROOT'] . "/rftCandyShop/Model/database/ConnectionHandler.class.php";

/**
 * Created by PhpStorm.
 * User: ngg
 * Date: 12/4/2015
 * Time: 11:12 AM
 */
class UserAsStorekeeper extends User
{
    private $orders;
    private $newRefilling;
    private static $conn;

    /**
     * UserAsStorekeeper constructor.
     */
    public function __construct($user_id, $email, $password)
    {
        parent::__construct($user_id, $email, $password);
        self::$conn = new ConnectionHandler();
    }


    public function getOrdersOfCustomers()
    {
        $result = array(); //type : OrderOfSk


        return $result;
    }

    public function orderHandling($orderNumber, $status)//void
    {

        self::$conn->preparedUpdate("megrendelesek",array("statusz_id"),array($status),"rend_szam = ?",array($orderNumber));
        echo "update is done";

    }

    public function checkStock()
    {
        $result = "";


        return $result;//String
    }

    public function stockRefill()
    { //void

    }

    /**
     * A raktár feltöltést végzi el.
     * @param $p_name
     * @param $quantity
     * @param $expiration_date
     */
    public function addNewRefillingProduct($p_id, $quantity, $expiration_date)//void
    {

        //echo "date: ". date($expiration_date." 00:00:00");

        try {
            $expiration_date = date($expiration_date . " 00:00:00");

            $transport_id = $this->getTransportId($expiration_date);
            if ($transport_id == false) {
                $transport_id = $this->getTransportId($expiration_date);
            }

            //var_dump($transport_id);
            //echo "<br>transport id: " . $transport_id . "<br>";

            self::$conn->preparedInsert("raktar", array("termek_id", "szall_id", "mennyiseg", "stat_id"),
                array($p_id, $transport_id, $quantity, 1));

            return "Sikeres raktár feltöltés!";
        } catch (Exception $e) {
            return "Sajnos nem sikerült a raktár feltöltés!";
        }

    }

    /**
     * Adott lejárati dátumhoz megkeresi a szállítmány azonosítót.
     * @param date $expiration_date
     * @return int $id
     */
    public function getTransportId($expiration_date)
    {

        $stmt = self::$conn->preparedQuery("SELECT szall_id FROM szallitmanyok WHERE lejar_datum = ?", array($expiration_date));

        $row = $stmt->fetch(PDO::FETCH_NUM);

        //var_dump($row);
        if ($row === false) {

            //echo "<br>transport is not exist<br>";
            $today = date("Y-m-d h:i:s");
            self::$conn->preparedInsert("szallitmanyok", array("beerk_datum", "lejar_datum"), array($today, $expiration_date));

            return false;


        } else {
            //echo "exist transport id " . $row[0] . "<br>";
            return $row[0];
        }

    }


    public function saveNewRefilling()//void
    {

    }


    /**
     * Lejárt termékek kivonása a forgalomból.
     */
    public function stockProductDisposal($product_id,$cargo_id,$quantity,$stat,$removedQuantity)
    {




    }

    public function changeStatusToDisposal($product_id, $cargo_id)
    {

    }

    /**
     * Végleges elszállítatás, törlés a raktár táblából.
     */
    public function disposal()
    {//void

        self::$conn->preparedDelete("raktar","stat_id=? or stat_id=? ",array(0,2));
    }






}