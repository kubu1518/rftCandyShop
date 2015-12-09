<?php

/**
 * @author ngg;
 */

/**
 * A forgalmazandó Termék általános model osztálya.
 */
class Product
{

    private $id;
    private $name;
    private $package;
    private $category;
    private $weight;
    private $price;
    private $min_order;
    private $min_stock;
    private $discount;
    private $highlight;
    private $img;
    private $description;

    /**
     * Product constructor.
     * @param $id
     * @param $name
     * @param $package
     * @param $category
     * @param $weight
     * @param $price
     * @param $min_order
     * @param $min_stock
     * @param $discount
     * @param $highlight
     * @param $img
     * @param $description
     */

    
    /*Hölgyeim és uraim! Bosszantja önöket, h mikor adatbéből buildel objectet, az összes paramétert
     át kell adni a resultsetből, ami ugyebár a resultset indexelését figyelembe véve, egy sok fieldes classnél igen-igen fos meló?
     Akkor miért nem tömbözik??? :D
     */
    public function __construct(){

    }

    public static function  createProduct($id, $name, $package, $category, $weight, $price, $min_order, $min_stock, $discount, $highlight, $img, $description){
        $tmp = func_get_args();
        return self::createProductByArray($tmp);
    }


    public static function createProductByArray($productFields)
    {
        $instance = new self();
        $instance->id = $productFields['t_azon'];
        $instance->name = $productFields['nev'];
        $instance->category = $productFields['kat_azon'];
        $instance->package = $productFields['kisz_azon'];
        $instance->weight = $productFields['suly'];
        $instance->price = $productFields['egysegar'];
        $instance->min_order = $productFields['min_rend'];
        $instance->min_stock = $productFields['min_keszlet'];
        $instance->discount = $productFields['akcio'];
        $instance->highlight = $productFields['kim_azon'];
        $instance->img = $productFields['reszletek'];
        $instance->description = $productFields['kep'];

        return $instance;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * @param mixed $package
     */
    public function setPackage($package)
    {
        $this->package = $package;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getMinOrder()
    {
        return $this->min_order;
    }

    /**
     * @param mixed $min_order
     */
    public function setMinOrder($min_order)
    {
        $this->min_order = $min_order;
    }

    /**
     * @return mixed
     */
    public function getMinStock()
    {
        return $this->min_stock;
    }

    /**
     * @param mixed $min_stock
     */
    public function setMinStock($min_stock)
    {
        $this->min_stock = $min_stock;
    }

    /**
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param mixed $discount
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }

    /**
     * @return mixed
     */
    public function getHighlight()
    {
        return $this->highlight;
    }

    /**
     * @param mixed $highlight
     */
    public function setHighlight($highlight)
    {
        $this->highlight = $highlight;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img)
    {
        $this->img = $img;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


    public function __toString()
    {
        return $this->getId() . " " . $this->getName() . ":&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"
        . $this->getPrice() . " " . $this->getImg() . " minOrder: " . $this->getMinOrder();
    }


    public function saveProduct()
    {

        $conn = new ConnectionHandler();

        $table = "Product";
        $fields = array("nev", "kat_azon", "kisz_azon", "suly", "egysegar", "min_keszlet", "min_rend", "kim_azon", "akcio",
            "reszletek", 'kep');
        $stmtCat = $conn->preparedQuery("SELECT kat_azon FROM Kiszereles WHERE kat_nev=?", arra($this->getCategory()));
        $arr = $stmtCat->fetchAll(PDO::FETCH_ASSOC);
        $category_id = $arr[0];
        
        foreach ($arr as $titleData) {
            echo $titleData['name'];
        }

        $values = array($this->getName(), $this->getCategory()->getId(),$this->getCategory()->getId(), $this->getWeight(), $this->getPrice(), $this->getMinStock(),
            $this->getMinOrder(), $this->getHighlight()->getId(), $this->getDiscount(), $this->getDescription(), $this->getImg()
        );

        $conn->preparedInsert($table, $fields, $values);


    }



}
