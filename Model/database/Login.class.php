<?php

require_once('ConnectionHandler.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . "/Model/UserAsCustomer.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/Model/UserAsLeader.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/Model/UserAsStorekeeper.php");

/**
 * Created by PhpStorm.
 * User: István
 * Date: 2015.12.02.
 * Time: 15:30
 */
class Login
{
    private $uid, $email, $password, $table;
    private $ch;

    /**
     * Registration constructor.
     * @param $email
     * @param $password
     * @param $ch
     */
    public function __construct()
    {
        $this->ch = new ConnectionHandler();
    }


    public function logIn($pEmail, $pPassword)
    {

        $this->email = $pEmail;
        $this->password = $pPassword;
        $this->table = "felhasznalok";
        /**
         *
         */

        $current = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $referrer = $_SERVER['HTTP_REFERER'];


        if ($referrer == $current) {


            $this->cleanPostedData();


            $error = $this->checkLoginData();
            if (substr($error, 0, 2) !== "ok") {
                return $error;
            } else {
                $authLevel = substr($error, 2);
                return "ok" . $this->createSession($authLevel);
            }

        } else {
            die('Az átküldött adatok nem a megfelelő oldalról jöttek.');
        }

    }

    private function cleanPostedData()
    {
        $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
        $this->password = filter_var($this->password, FILTER_SANITIZE_STRING);
    }

    public function checkLoginData()
    {
        if ($this->email && $this->password) {
            $stmt = $this->ch->preparedQuery("SELECT * FROM $this->table where email = ?", array($this->email));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                if (password_verify($this->password, $result["jelszo"])) {
                    $this->uid = $result['uid'];
                    return "ok" . $result['jog_szint'];
                } else {
                    return "A jelszó nem megfelelő";
                }
            } else {
                return "Nem létezik ilyen email";
            }
        } else {
            return "Nincs megadva email vagy jelszó";
        }
    }

    private function createSession($authLevel)
    {
        $direct = "";
        session_start();
        switch ($authLevel) {
            case 'U' :
                $_SESSION['actUser'] = serialize(new UserAsCustomer($this->uid, $this->email, $this->password));
                $direct = "index.html";
                break;
            case 'R' :
                break;
            case 'V' :
                break;
        }

        return $direct;
    }

}