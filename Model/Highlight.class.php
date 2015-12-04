<?php

/**
 * Created by PhpStorm.
 * User: ngg
 * Date: 12/4/2015
 * Time: 5:02 PM
 */
class Highlight
{

    private $id;
    private $name;

    /**
     * Package constructor.
     * @param $id
     * @param $name
     */
    public function __construct($id=NULL, $name=NULL)
    {
        $this->id = $id;
        $this->name = $name;
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

    function __toString()
    {
        return $this->getId()." ".$this->getName();   // TODO: Implement __toString() method.
    }


    /**
     * A Megadott azonosító alapján, megkeresi a kiemelés elnevezését.
     *
     * @param int $id
     * @return String name
     */
    public function selectName($id){
        $conn = new ConnectionHandler();
        $stmt = $conn->preparedQuery("SELECT kim_nev FROM Kiemeles WHERE kim_azon=?",array($id));
        $row = mysqli_fetch_array($stmt,MYSQLI_BOTH);

        return $row[1];
    }

}