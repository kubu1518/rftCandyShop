<?php

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

        $products = array();

        $stmt = $this->conn->preparedCountQuery("SELECT * FROM Termekek WHERE kat_azon = ?",array($categ_id));

        while($row = $stmt->fetch(PDO::FETCH_NUM,PDO::FETCH_ORI_NEXT)){
/*
            $category = new Category($rowProduct[3]);
//        $category->setName($category->selectName($this->getId()));
            //átköltöztetve a konstrukorba, ha nem szép dolog, akkor hazsnálom ezt itt
            $pack = new Package($rowProduct[2]);
//        $pack->setName($pack->selectName($this->getId()));
            $highlight = new Highlight($rowProduct[9]);
//        $highlight->setName($highlight->selectName($highlight->getId()));
*/
            //termék összeállítása és hozzáadása a kosárhoz
            array_push(addProduct(new Product($row[0], $row[1], new Package($row[2]), new Category($row[3]), $row[4], $row[5],
                $row[6], $row[7], $row[8], new Highlight($row[9]), $row[10], $row[11]), $row[2]), $products);

            /*
             * Összekéne még szedni ,h mennyi van raktáron az adott termékből.
             *
             * Lehetséges, hogy létre kell hozni mégeg model osztályt, amelyet átadunk a controller osztálynak.
             * Így nézne ki -> (Product, Quantity, DiscountPrice)
             *
             */
        }








        return $products;
    }


    public function listingProducts($name, $categ_id)
    {

    }

    public function listingOrderBStatus($product_id, $order_array)/*orderForSk*/
    {

        return null;//String
    }

    public function listingQuantityOfProductInStock()
    {
        return null; //String
    }

    public function listingAllProductsFromStockByStatus($status)
    {
        return null; //String
    }

    public function listingAllProductForLeader()
    {
        return null; //String
    }

    public function listingProductsGroups()
    {
        return null; //String array
    }

    public function showProductIds($product_id) //idk
    {
        return null;
    }

}