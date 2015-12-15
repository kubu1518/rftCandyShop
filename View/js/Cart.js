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
function finalizeOrder() {
    $("#workzone").load("../../rftCandyshop/Controll/ControlOrderFinalize.php")
}

function showPayChooser(array) {
    $.get("../../rftCandyshop/Controll/ControlOrderStart.php",{
        "data[]" : array
    },function(data){
        $("#workzone").html(data);
        $("#finorder").click(function(){
            finalizeOrder()
        })


    })
}

function showOrderPage() {
    var num = $(".basket_product .numinput:invalid").length;
    if (num > 0) {
        alert("Van olyan termék ami nem teljesíti a minimális mennyiség feltételt!")
    }
    else {
        $("#workzone").load("../../rftCandyshop/Controll/ControlOrder.php", function () {
            var delch = 1;
            $("#address").hide();
            $("input[name='delch']").change(function(){
                delch = $(this).val();
               if ($(this).val() == 1 ){
                    $("#address").hide();
                }else{
                    $("#address").show();
                }
            });

            $("input[name='showBA']").change(function(){
                if ($(this).is(":checked")){
                    $("#billingadd").hide();
                }
                else{
                    $("#billingadd").show();
                }
            });

            $("#pay").click(function(){
                var inputs = $("#address").find("table input[type='text']");
                var flag = true;
                send = false;
                array = [];
               if(delch == 2){
                   if(!$("input[name='showBA']").is(":checked")){
                        inputs.each(function(){
                        if ($(this).val() === "" ){
                            flag = false;
                        }
                            else {
                            array.push($(this).val())
                        }
                   });
                    if(!flag){
                     alert("Nincs kitöltve minden mező")
                   }else{
                        send = true
                    }
               }else{
                       if(inputs.eq(0).val() == "" || inputs.eq(0).val() == ""){
                           alert("Nincs kitöltve minden mező")
                       }else{
                            array.push(inputs.eq(0).val());
                            array.push(inputs.eq(1).val());
                           send = true
                       }
                   }

                   if(send){
                       showPayChooser(array)
                   }

               }
                else{
                   showPayChooser(array)
               }


            });

        })
    }
}


function showCart() {
    $("#workzone").load("../../rftCandyshop/Controll/ControlCart.php", function () {
        $(".numinput").change(function () {
            modifyQuantity($(this))
        });

        $(".delete").click(function () {
            deleteProduct($(this))
        });

        $("#nexttoorder").click(function () {
            if($(".basket_product").length == 0){
                alert("A kosarad üres!")
            }else {
                showOrderPage()
            }
        })
    })
}
/**
 * Created by István on 2015.12.13..
 */

$(document).ready(function () {
        showCart();
});
