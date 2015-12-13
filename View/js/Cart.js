function modifyQuantity(input) {
    var id = input.attr("name");
    var value = input.val();
    $.get("../../rftCandyshop/Controll/ControlCartModifyQuantity.php", {
        id: id,
        value: value
    }, function () {
        showCart();
    })
}
function deleteProduct(button) {
    var id = button.attr("name");
    $.get("../../rftCandyshop/Controll/ControlCartDeleteProduct.php", {
        id: id
    }, function () {
        authButtonsLoad();
        showCart()
    })
}
function showOrderPage() {
    $("#workzone").load("../../rftCandyshop/Controll/ControlCart.php",function (){

    })
}


function showCart() {
    $("#workzone").load("../../rftCandyshop/Controll/ControlCart.php", function () {
        $(".numinput").change(function () {
            modifyQuantity($(this))
        });

        $(".delete").click(function () {
            deleteProduct($(this))
        })

        $("#nexttoorder").click(function () {
            showOrderPage()
        })
    })
}
/**
 * Created by István on 2015.12.13..
 */

$(document).ready(function () {
    showCart();
});
