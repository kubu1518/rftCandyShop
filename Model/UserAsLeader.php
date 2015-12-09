<?php

require_once("User.class.php");

/**
 * Created by PhpStorm.
 * User: ngg
 * Date: 12/4/2015
 * Time: 11:56 AM
 */
class UserAsLeader extends User
{


    /**
     * UserAsLeader constructor.
     */
    public function __construct($user_id, $email, $password)
    {
        parent::__construct($user_id, $email, $password);
    }


    public function productAddStore()
    {//void

    }

    public function checkProductExist($product)
    {//boolean

    }

    public function productRemoveFromStore($product_id)
    {//void

    }

    public function productEditPrice($product_id, $price)
    {

    }

    public function productEditRecommendQuantity($product_id, $min_stock)
    {

    }

    public function productMinimalOrderQuantity($product_id, $min_quantity)
    {

    }

    public function productEditHighlighting($product_id, $hl_name)
    {

    }

    public function productSoldStatistic($product_id, $start_date, $end_date)
    {

    }

    public function showStatistic()
    {
        $result = "";

        return $result;//String
    }
}