<?php

require_once('database/ConnectionHandler.class.php');

/**
 * Created by PhpStorm.
 * User: ngg
 * Date: 12/4/2015
 * Time: 12:04 PM
 */
class ListingUtilities
{
    private $conn;

    /**
     * ListingUtilities constructor.
     */
    public function __construct()
    {
        $this->conn = new ConnectionHandler();
    }


    /**
     * @param int $categ_id
     * @return array(Product) $products_array
     */
    public function listingProductByCategoryId($categ_id)
    {

        $result = array();

        $stmt = $this->conn->preparedCountQuery("SELECT * FROM Termekek WHERE kat_azon = ?", array($categ_id));

        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            /*
                        $category = new Category($rowProduct[3]);
            //        $category->setName($category->selectName($this->getId()));
                        //átköltöztetve a konstrukorba, ha nem szép dolog, akkor hazsnálom ezt itt
                        $pack = new Package($rowProduct[2]);
            //        $pack->setName($pack->selectName($this->getId()));
                        $highlight = new Highlight($rowProduct[9]);
            //        $highlight->setName($highlight->selectName($highlight->getId()));
            */
            //termék összeállítása

            $product = new Product($row[0], $row[1], new Package($row[2]), new Category($row[3]), $row[4], $row[5],
                $row[6], $row[7], $row[8], new Highlight($row[9]), $row[10], $row[11]);

            //Az eladható darabok össze számolása, termékekként.
            $product->setSellAble($this->countSellAbleQuantity($row[0]));

            array_push(addProduct($product, $result));
        }


        return $result;
    }

    /**
     * A keresés végrehajtása történik itt.
     *
     * @param String $name
     * @param int $categ_id
     *
     * @return Product array
     */
    public
    function listingProducts($name, $categ_id)
    {
        $result = array();
        $stmt = NULL;

        if ($categ_id === 0) {
            $stmt = $this->conn->preparedQuery("SELECT * FROM Termekek WHERE nev=?", array($name));

        } else {
            $stmt = $this->conn->preparedQuery("SELECT * FROM Termekek WHERE nev=? AND kat_azon=?", array($name, $categ_id));

        }

        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            array_push(addProduct(new Product($row[0], $row[1], new Package($row[2]), new Category($row[3]), $row[4], $row[5],
                $row[6], $row[7], $row[8], new Highlight($row[9]), $row[10], $row[11]), $row[2]), $products);
        }

        return $result;
    }

    /**
     * Kiválogatja a megrendeléseket
     *
     * @param int $product_id
     * @param Order $order_array
     * @return string
     */
    public
    function listingOrderByStatus($product_id, $order_array)/*orderForSk*/
    {
        $result = "";

        return $result;//String
    }

    public
    function listingQuantityOfProductInStock()
    {
        return null; //String
    }

    public
    function listingAllProductsFromStockByStatus($status)
    {
        return null; //String
    }

    public
    function listingAllProductForLeader()
    {
        return null; //String
    }

    public
    function listingProductsGroups()
    {
        $back = [];
        $stmt = $this->conn->preparedQuery("SELECT * FROM kategoriak"); /*olyan katokat amelyekből van a spejzban de majd később*/
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $back[$row['kat_azon']] = $row['kat_nev'];
        }
        $this->conn->close();
        return $back; //String array
    }

    public
    function showProductIds($product_id) //idk
    {
        return null;
    }


}