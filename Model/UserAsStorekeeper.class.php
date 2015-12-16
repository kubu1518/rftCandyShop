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
        //$orderNumber = 4;

        if($status == 2) {


            if ($this->checkStockEnoughProduct($orderNumber)) {

//lekérem a szállítmányokat az azokhoz a termékekhez amelyekből rendelés történt az adott azonosítóval.

// rendelés_id, szállitmány_id, termek_id, mennyiség raktáron, szükséges mennyiség , stat_id, lejárati dátum
                $stmt2 = self::$conn->preparedQuery(
                    "SELECT rr.rend_szam ,r.szall_id ,r.termek_id ,r.mennyiseg as raktaron,rr.mennyiseg,r.stat_id,sz.lejar_datum
        FROM `raktar` r INNER JOIN rendeles_reszletei rr
          ON r.termek_id=rr.termek_id
          AND (r.stat_id = 1 or r.stat_id = 3)
          AND rr.rend_szam = ?
            inner JOIN szallitmanyok sz
            ON r.szall_id=sz.szall_id
              order by r.termek_id, sz.lejar_datum", array($orderNumber));

//$raktaronDb = array();

//a szükséges mennyiség nyilvántartása kulcs: termek_id => szükséges mennyiség
                $kellDb = array();


//ez előtt ellenőrzés történik ,hogy van-e elég termék raktáron, így csak akkor jutunk el ide, ha igen.

                while ($row = $stmt2->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {

                    echo $row[0] . " " . $row[1] . " " . $row[2] . " " . $row[3] . " " . $row[4] . " " . $row[5] . " " . $row[6] . "<br>";

                    $termek_id = $row[2];

                    //ha nem létezik a termek_id akkor belerakjuk a szükséges mennyiséget
                    if (array_key_exists($row[2], $kellDb) == false) {
                        $kellDb[$termek_id] = $row[4];
                    }

                    //ha a szükséges mennyiség nagyobb mint nulla az adott termék_id esetén.
                    if ($kellDb[$termek_id] > 0) {
                        $raktaron = $row[3];

                        //ha több kellene mint amennyi van az adott szállítmányban a termékből, vagy ugyanannyi
                        if ((($raktaron - $kellDb[$termek_id]) < 0) || ($raktaron - $kellDb[$termek_id]) == 0) {

                            $kellDb[$termek_id] = $kellDb[$termek_id] - $raktaron;
                            $raktaron = 0;

                            // echo "update raktaron:".$raktaron." && ennyi kell meg: ".$kellDb[$termek_id]."<br>";

                            self::$conn->preparedDelete(
                                "raktar", "termek_id = ? and szall_id = ? and mennyiseg = ? and stat_id = ?",
                                array($termek_id, $row[1], $row[3], $row[5]));
                        } //több van a szállítmányban mint amennyi kell
                        else {

                            $raktaron -= $kellDb[$termek_id];
                            $kellDb[$termek_id] = 0;

                            //echo "update raktaron:".$raktaron ." ennyi kell meg: ".$kellDb[$termek_id]."<br>";

                            self::$conn->preparedUpdate(
                                "raktar", array("mennyiseg"), array($raktaron),
                                "termek_id = ? and szall_id = ? and mennyiseg = ? and stat_id = ?",
                                array($termek_id, $row[1], $row[3], $row[5]));
                        }
                    }
                }


                self::$conn->preparedUpdate("megrendelesek", array("statusz_id"), array($status), "rend_szam = ?", array($orderNumber));

                echo "Sikeres státusz változtatás";


            } else {
                echo "HIBA: A raktáron lévő mennyiségből nem lehet kiszolgálni a rendelést!";
            }

        }
        else{
            self::$conn->preparedUpdate("megrendelesek", array("statusz_id"), array($status), "rend_szam = ?", array($orderNumber));

            echo "Sikeres státusz változtatás";
        }
    }

    /**
     * Ellenőrzi ,hogy elég termék-e van-e raktáron a rendelés kiszolgálásához.
     *
     * @param int $orderNumber
     * @return bool
     */
    public function checkStockEnoughProduct($orderNumber)
    {

        $stmt = self::$conn->preparedQuery(
            "SELECT rr.rend_szam ,r.szall_id ,r.termek_id ,sum(r.mennyiseg) as raktaron,rr.mennyiseg,sz.lejar_datum FROM `raktar` r
      INNER JOIN rendeles_reszletei rr ON r.termek_id=rr.termek_id AND r.stat_id <> 0 AND rr.rend_szam = ?
      inner JOIN szallitmanyok sz ON r.szall_id=sz.szall_id
      group BY r.termek_id
      order by r.termek_id, sz.lejar_datum",
            array($orderNumber));

        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {

            //echo $row[0] . " " . $row[1] . " " . $row[2] . " " . $row[3] . " " . $row[4] . " " . $row[5] . "<br>";
            if ($row[3] < $row[4]) {
                echo "Nem elég a készlet hozzá!";
                return false;
                break;
            }


        }

        return true;
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
    public function stockProductDisposal($product_id, $cargo_id, $quantity, $stat, $removedQuantity)
    {

        $romlott = false;

        $stmt = self::$conn->preparedQuery("select lejar_datum from szallitmanyok WHERE szall_id = ?", array($cargo_id));
        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {

            //a mai dátum, kisebb mint a lejárati dátum
            if (date("Y-m-d h:i:s") > date($row[0])) {
                $romlott = true;
            }

            echo date("Y-m-d h:i:s") ."  ---   ". date($row[0]);

        }

        echo "Romlott-e? ";
        if($romlott){
            echo " true";

        }
        else{
            echo " false";
        }

        if ($romlott) {

//a Romlottnak 5-ös az id-je
            self::$conn->preparedUpdate(
                "raktar", array("stat_id"), array(5),
                "termek_id = ? and szall_id = ? and mennyiseg = ? and stat_id = ?",
                array($product_id, $cargo_id, $quantity, $stat));

        } else {
            /*
             * mivel nem romlott, ezért le kell vonni a mennyiséget és újként hozzá adni
            * a levont mennyiséget, selejtes id-vel.
            */


            if ($quantity == $removedQuantity) {
                //update a raktárban a státuszt az adott szállítmányos terméknek stat_id = 2 //selejt

                self::$conn->preparedUpdate(
                    "raktar", array("stat_id"), array(2),
                    "termek_id = ? and szall_id = ? and mennyiseg = ? and stat_id = ?",
                    array($product_id, $cargo_id, $quantity, $stat));

            } else {

                //annál a szállítmánynál amiből selejtezünk a sérülés miatt, levonjuk a darabszámot
                self::$conn->preparedUpdate(
                    "raktar", array("mennyiseg"), array($quantity - $removedQuantity),
                    "termek_id = ? and szall_id = ? and mennyiseg = ? and stat_id = ?",
                    array($product_id, $cargo_id, $quantity, $stat));

                //a selejtesezett termékekeket bevezetjük a selejtezni kívánt mennyiségben
                self::$conn->preparedInsert("raktar", array("termek_id","szall_id","mennyiseg","stat_id"),
                    array($product_id, $cargo_id, $removedQuantity, 2));


            }


            /*
            self::$conn->preparedUpdate(
                "raktar", array("mennyiseg"), array(($quantity-$removedQuantity)),
                "termek_id = ? and szall_id = ? and mennyiseg = ? and stat_id = ?",
                array($product_id, $cargo_id, $quantity, $stat));
            */


        }


    }

    public function changeStatusToDisposal($product_id, $cargo_id)
    {

    }

    /**
     * Végleges elszállítatás, törlés a raktár táblából.
     */
    public function disposal()
    {//void

        self::$conn->preparedDelete("raktar", "stat_id=? or stat_id=? ", array(0, 2));
    }


}