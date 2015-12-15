<?php

/**
 * Created by PhpStorm.
 * User: ngg
 * Date: 12/4/2015
 * Time: 10:46 AM
 */
class Order
{

    private $orderDate;
    private $deliveryAddress;
    private $billAddress;
    private $status;
    private $quantities;
    private $products;
    private $subtotal;


    /**
     * Order constructor.
     * @param $id
     * @param $orderDate
     * @param $deliveryAddress
     * @param $billAddress
     * @param $status
     * @param $quantities
     * @param $products
     */



    public function __construct($deliveryAddress, $billAddress, $status, $quantities, $products,$subtotal)
    {
        $this->deliveryAddress = $deliveryAddress;
        $this->billAddress = $billAddress;
        $this->status = $status;
        $this->quantities = $quantities;
        $this->products = $products;
        $this->subtotal = $subtotal;
    }

    /**
     * @return mixed
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }

    /**
     * @return mixed
     */
    public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }

    /**
     * @return mixed
     */
    public function getBillAddress()
    {
        return $this->billAddress;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getQuantities()
    {
        return $this->quantities;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $orderDate
     */
    public function setOrderDate($orderDate)
    {
        $this->orderDate = $orderDate;
    }






}