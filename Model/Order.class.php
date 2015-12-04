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
    private $amount;

    /**
     * Order constructor.
     * @param $id
     * @param $orderDate
     * @param $deliveryAddress
     * @param $billAddress
     * @param $status
     * @param $quantities
     * @param $products
     * @param $amount
     */
    public function __construct( $orderDate, $deliveryAddress, $billAddress, $status, $quantities, $products, $amount)
    {
        $this->id = $id;
        $this->orderDate = $orderDate;
        $this->deliveryAddress = $deliveryAddress;
        $this->billAddress = $billAddress;
        $this->status = $status;
        $this->quantities = $quantities;
        $this->products = $products;
        $this->amount = $amount;
    }


    /**
     * @return mixed
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }

    /**
     * @param mixed $orderDate
     */
    public function setOrderDate($orderDate)
    {
        $this->orderDate = $orderDate;
    }

    /**
     * @return mixed
     */
    public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }

    /**
     * @param mixed $deliveryAddress
     */
    public function setDeliveryAddress($deliveryAddress)
    {
        $this->deliveryAddress = $deliveryAddress;
    }

    /**
     * @return mixed
     */
    public function getBillAddress()
    {
        return $this->billAddress;
    }

    /**
     * @param mixed $billAddress
     */
    public function setBillAddress($billAddress)
    {
        $this->billAddress = $billAddress;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getQuantities()
    {
        return $this->quantities;
    }

    /**
     * @param mixed $quantities
     */
    public function setQuantities($quantities)
    {
        $this->quantities = $quantities;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    function __toString()
    {
     return "";
    }


}