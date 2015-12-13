/**
 * Created by István on 2015.12.12..
 */
$(document).ready(function () {
    $("#logout").click(function () {
        $.get("../../rftCandyshop/Controll/ControlLogout.php", {}, function (data) {
            //alert(data);
            location.reload()
        })
    });

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



    $(".category").click(function () {
        var id = $(this).attr("id");
        $("#searchName").val("");
        console.log(id);
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
    },function(data){
        alert(data)
    })
}