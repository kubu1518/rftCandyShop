<?php


require_once('ConnectionHandler.class.php');

/**
 * Created by PhpStorm.
 * User: István
 * Date: 2015.12.02.
 * Time: 15:32
 */
class Registration
{

    private $email, $password, $table;
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


   public function registration($pEmail, $pPassword)
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



            $fields = array('email', 'jelszo', 'jog_szint');

            $this->cleanPostedData();

            $errorMessages = $this->emailCheck().":".$this->passwordCheck();

            if($errorMessages != ":"){
                return $errorMessages;
            }
            else{
                $hPassword = password_hash($this->password,PASSWORD_DEFAULT);
                $values = array($this->email,$hPassword,"U");

                $this->ch->preparedInsert($this->table,$fields,$values);
                $this->ch->close();
                return "Sikeres Regisztráció";
            }

        } else {
            die('Az átküldött adatok nem a megfelelő oldalról jöttek.');
        }

    }

    private function cleanPostedData(){
            $this->email = filter_var($this->email,FILTER_SANITIZE_EMAIL);
            $this->password = filter_var($this->password,FILTER_SANITIZE_STRING);
    }

    private function emailCheck(){
        if(strlen($this->email) != 0) {
            if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $stmt = $this->ch->preparedQuery("SELECT * FROM $this->table WHERE email = ?", array($this->email));
                if (!$stmt->fetch(PDO::FETCH_BOTH)) {
                    return "";
                } else {
                    return "Ez az email cím már létezik";
                }
            } else {
                return "Az email formátuma nem megfelelő";
            }
        }
        else{
            return "Email cím nem lett megadva";
        }
    }

    private function passwordCheck(){
        if(strlen($this->password) >= 4) {
            if (!preg_match("/[A-Z]/", $this->password) ||
                !preg_match("/[a-z]/", $this->password) ||
                !preg_match("/[0-9]/", $this->password)) {
                return "A jelszónak kis- és nagybetűket, illetve számot kell tartalmaznia";
            } else {
                return "";
            }
        }
        else{
            return "Jelszónak legalább 4 karakter hosszúnak kell lennie";
        }
    }


}