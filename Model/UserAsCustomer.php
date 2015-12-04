<?php

/**
 * Created by PhpStorm.
 * User: ngg
 * Date: 12/4/2015
 * Time: 11:50 AM
 */
class UserAsCustomer extends User
{
private $cart;
private $orders;

    /**
     * UserAsCustomer constructor.
     */
    public function __construct($user_id, $email, $password)
    {
        parent::__construct($user_id,$email,$password);
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

    public function orderStart(){//void

    }

    public function orderFinalize(){//boolean

    }

    public function saveCart(){//void

    }
}