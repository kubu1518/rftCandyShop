/**
 * Created by ngg on 12/15/2015.
 */

$(document).ready(function(){
    $("#logout").click(function(){
        //alert("#############");
        $.get("../../rftCandyShop/Controll/ControllLogoutAdmin.php",{},function(data){
           // alert(data);
            window.location = "http://localhost/rftCandyShop/View/index.php";
        })
    })
});

