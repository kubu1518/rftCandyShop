<?php
include('dbLoginData.php');


class ConnectionHandler
{

    private $conn = null;

    function __construct()
    {
        $this->connect();
    }


    private function connect()
    {
        try {
            $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    function preparedInsert($table, $fields, $values)
    {
        $qmarks = array_fill(0, count($values), '?');
        $fields = implode(", ", $fields);
        $qmarks = implode(", ", $qmarks);
        //echo "INSERT INTO $table ($fields) VALUES($qmarks)";
        $stmt = $this->conn->prepare("INSERT INTO $table ($fields) VALUES($qmarks)");
        $stmt->execute($values);
    }


    function preparedQuery($sql, $parameters = array())
    {
        if (substr_count($sql, "?") == count($parameters)) {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($parameters);
            return $stmt;
        } else die("preparedQuery: A parameterszam nem egyezik");
    }

    function preparedUpdate($table, $columns, $values, $where, $parameters)
    {
        $noc = count($columns);

        $colval = [];
        if ($noc == count($values)) {
            for ($i = 0; $i < $noc; ++$i) {
                $colval[] = $columns[$i] . " = ?";
            }
            $colval = implode(", ", $colval);
        } else die("preparedUpdate: Oszlop- es ertekszam nem egyezik");

        if (substr_count($where, "?") == count($parameters)) {
            $parameters = array_merge($values, $parameters);
            $sql = "UPDATE $table SET " . $colval . " WHERE " . $where;
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($parameters);
        } else die("preparedUpdate: A parameterszam nem egyezik");
    }

    function preparedDelete($table, $where, $parameters)
    {
        if (substr_count($where, "?") == count($parameters)) {
            $stmt = $this->conn->prepare("DELETE FROM $table WHERE " . $where);
            $stmt->execute($parameters);
            return $stmt;
        } else die("preparedDelete: A parameterszam nem egyezik");
    }

    function close()
    {
        $this->conn = null;
    }

    /**
     * Visszatér az érintett sorok számával.
     *
     * @param $sql select
     * @param array $parameters
     * @return int count(*)
     */
    function preparedCountQuery($sql, $parameters = array())
    {
        if (substr_count($sql, "?") == count($parameters)) {

            $stmt = $this->conn->prepare($sql);

            $stmt->execute($parameters);

            return $stmt->fetchColumn();

        } else die("preparedQuery: A parameterszam nem egyezik");
    }
}


?>