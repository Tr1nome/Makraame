$(document).ready(function(){
    $("#createPI").click(function() {
        $(".centerDiv").show();
    });
    $("#cancel").click(()=> {
        $(".centerDiv").hide();
    });
    $("#create").click(()=> {
        $(".centerDiv").hide();
    });

    $(".centerDiv").css("background-color", "#ffffff");

    $('#color-picker').spectrum({
        type: "color",
        color: "#ffffff",
        showInitial: "true",
        showPaletteOnly: "true",
        change: function(color) {
            $(".centerDiv").css("background-color", color.toHexString());
            console.log(color);
        },
        hideAfterPaletteSelect: "true",
      });

      
})