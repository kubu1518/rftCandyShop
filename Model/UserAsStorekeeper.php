<?php
include "User.class.php";

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

    /**
     * UserAsStorekeeper constructor.
     */
    public function __construct($user_id, $email, $password)
    {
        parent::__construct($user_id, $email, $password);
    }


    public function getOrdersOfCustomers()
    {
        $result = array(); //type : OrderOfSk


        return $result;
    }

    public function orderHandling($orderNumber, $status)//void
    {


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
    public function addNewRefillingProduct($p_name, $quantity, $expiration_date)//void
    {


        $this->saveNewRefilling();
    }


    public function saveNewRefilling()//void
    {

    }

    /**
     * Lejárt termékek kivonása a forgalomból.
     */
    public function stockProductDisposal()
    {//void

    }

    public function changeStatusToDisposal($product_id, $cargo_id)
    {

    }

    public function disposal()
    {//void


    }
}