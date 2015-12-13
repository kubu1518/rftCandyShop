<?php
session_start();
if($_SESSION["right_level"] != 1){
    echo '<a href="index.php">Kezdő oldal</a>';
    session_destroy();
    die("Nincs ehhez jogosultságod!");

}
/**
 * Created by PhpStorm.
 * User: ngg
 * Date: 12/10/2015
 * Time: 9:47 PM
 */

//include $_SERVER['DOCUMENT_ROOT'] . "/git/rftCandyShop/Model/database/ConnectionHandler.class.php";
include $_SERVER['DOCUMENT_ROOT'] . "/git/rftCandyShop/Model/Product.class.php";
include $_SERVER['DOCUMENT_ROOT'] . "/git/rftCandyShop/Model/UserAsLeader.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['submit'])) {

        $name = $_POST["name"];
        $category = $_POST["category"];
        $package = $_POST["package"];
        $weight = $_POST["weight"];
        $price = $_POST["price"];
        $recQ = $_POST["recQ"];
        $minO = $_POST["minO"];
        $highlight = $_POST["highlight"];
        $action = $_POST["action"];
        //$details = $_POST["details"];
        $details = str_replace(PHP_EOL,"<br>",$_POST["details"]);
        //$img = $_POST["file"];


        foreach ($_POST as $key => $value) {
            echo $value . '<br/>';
        }

        $img_name       = $_FILES['file']['name'];
        $temp_name  = $_FILES['file']['tmp_name'];
        $img_name = substr_replace(" ","_",$name);
        $img_name.=".jpg";
        $newfilename = "";

        if(isset($name)){
            if(!empty($name)){

                $location = 'images/product/';
                /*if(move_uploaded_file($temp_name, $location.$img_name)){
                    echo 'uploaded';
                }*/
                $temp = explode(".", $_FILES["file"]["name"]);
                $newfilename = round(microtime(true)) . '.' . end($temp);
                move_uploaded_file($_FILES["file"]["tmp_name"], "images/Product/" . $newfilename);
            }
        }  else {
            echo 'please uploaded';
        }
       //kontruktor $id, $name, $package, $category, $weight, $price, $min_order, $min_stock, $discount, $highlight, $img, $description)

        $product = new Product(null, $name,$package,$category,$weight,$price,$minO,$recQ,$action,$highlight,$newfilename,$details);

        $leader = new UserAsLeader($_SESSION["id"],$_SESSION["email"],$_SESSION["password"]);
        $message = $leader->productAddStore($product);

        $_SESSION["message"] = $message;

        header("Location: Leader_Add_Product.php");

//echo $product."<br>";

/*
        $conn = new ConnectionHandler();

        $conn->preparedInsert("termekek",
            array("nev", "kat_azon", "kisz_azon", "suly", "egysegar", "min_keszlet", "min_rend", "kim_azon", "akcio", "reszletek"),
            array($name, $categ, $package, $weight, $price, $recQ,$minO,$highlight,$action,$details));
/*
        $stmt = $conn->preparedQuery("SELECT t_azon FROM termekek WHERE nev=?",array("$name"));
        $id = -1;
        while($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)){
            $id = $row[0];
        }

        $name = $id;

*/


    }}
        //do something
/*
        echo $name."_".$price;

        $validextensions = array("jpeg", "jpg", "png");
        $temporary = explode(".", $_FILES["file"]["name"]);
        $file_extension = end($temporary);
        if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
            ) && ($_FILES["file"]["size"] < 100000)//Approx. 100kb files can be uploaded.
            && in_array($file_extension, $validextensions)) {
            if ($_FILES["file"]["error"] > 0)
            {
                echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
            }
            else
            {
                if (file_exists("upload/" . $_FILES["file"]["name"])) {
                    echo $_FILES["file"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
                }
                else
                {
                    $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
                    $targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored
                    move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
                    echo "<span id='success'>Image Uploaded Successfully...!!</span><br/>";
                    echo "<br/><b>File Name:</b> " . $_FILES["file"]["name"] . "<br>";
                    echo "<b>Type:</b> " . $_FILES["file"]["type"] . "<br>";
                    echo "<b>Size:</b> " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
                    echo "<b>Temp file:</b> " . $_FILES["file"]["tmp_name"] . "<br>";
                }
            }
        }
        else
        {
            echo "<span id='invalid'>***Invalid file Size or Type***<span>";
        }



    } else {

        return "fail";
    }
}*/
?>