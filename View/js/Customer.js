/**
 * Created by István on 2015.12.12..
 */

$( window ).unload(function() {
    authButtonsLoad();
});


$(document).ready(function () {

    $(".head.object1").click(function(){
       window.location = "http://localhost/rftCandyShop/View/index.php"
    });

    authButtonsLoad();


    $("#search").click(function () {
        var cat = $("#searchCategory option:selected").val();
        var name = $("#searchName").val();
        $.get("../../rftCandyshop/Controll/ControlSearch.php",
            {
                sName  : name,
                sCategory : cat
            },function(data){
                $("#alterablecontent").html(data);
                $(".pbdet").click(function (){
                    $(this).siblings(".details").slideToggle("slow");
                });
                $(".pbcart").click(function (){
                    addCart($(this))
                });
            })
    });


    $("#watchorders").click(function(){
        $("#alterablecontent").load("../../rftCandyshop/Controll/ControlWatchOrders.php")
    });


    $(".category").click(function () {
        var id = $(this).attr("id");
        $("#searchName").val("");
        $("#searchCategory").val(id);
        $("#search").trigger("click")
    })

});


function addCart(button){
    var tid = button.parent().attr("id");
    var qauntity = button.siblings("input").val();
    $.get("../../rftCandyshop/Controll/ControlAddCart.php",{
       t_id : tid,
        qauntity : qauntity
    },function(){
        authButtonsLoad();
    })
}

function authButtonsLoad (){
    $(".head.object2").load("../../rftCandyshop/Controll/ControlAuthButtons.php",function(){
        $("#logout").click(function () {
            $.get("../../rftCandyshop/Controll/ControlLogout.php", {}, function (data) {
                window.location = "http://localhost/rftCandyShop/View/index.php"
            })
        });
    });
}