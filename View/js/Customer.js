/**
 * Created by István on 2015.12.12..
 */
$(document).ready(function () {
    $("#logout").click(function () {
        $.get("../../Candyshop/Controll/ControlLogout.php", {}, function (data) {
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
                $("#alterablecontent").html(data)
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