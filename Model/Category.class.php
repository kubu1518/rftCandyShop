<?php

/**
 * Created by PhpStorm.
 * User: ngg
 * Date: 12/4/2015
 * Time: 4:58 PM
 */
class Category
{
    private $id;
    private $name;

    /**
     * Category constructor.
     * @param $id
     * @param $name
     */
    public function __construct($id, $name)
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
     return $this->getId()." ".$this->getName();
    }

    /**
     * A Megadott azonosító alapján, megkeresi a kategória elnevezését.
     *
     * @param int $id
     * @return String name
     */
    public function selectName($id){
        $conn = new ConnectionHandler();
        $stmt = $conn->preparedQuery("SELECT kat_nev FROM Kategoriak WHERE kat_azon=?",array($id));
        $row = mysqli_fetch_array($stmt,MYSQLI_BOTH);

        return $row[1];
    }
}