$(document).ready(function(){

    //grab
    $(".dragger").mousedown(function(){
        $(".dragger:hover").css( "cursor","grabbing"),cancelable = false;
        
    });
    //release
    $(".dragger").mouseup(function(){
        $(".dragger:hover").css( "cursor","grab");
        
    });

    var positions = JSON.parse(localStorage.positions || "{}");
    $(function () {
    var d = $("[id=draggable]").attr("id", function (i) {
        return "draggable_" + i
    })
    $.each(positions, function (id, pos) {
        $("#" + id).css(pos)
    })

    d.draggable({
        containment: "body",
        scroll: false,
        stop: function (event, ui) {
            positions[this.id] = ui.position
            localStorage.positions = JSON.stringify(positions)
        }
    });
});
    
});
