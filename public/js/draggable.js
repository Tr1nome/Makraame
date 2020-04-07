$(document).ready(function(){

    //grab
    $(".dragger").mousedown(function(){
        $('audio#grabSound')[0].play();
        $(".dragger:hover").css( "cursor","grabbing"),cancelable = false;
        $(this).css("opacity", "0.5");
        
        
    });
    //release
    $(".dragger").mouseup(function(){
        $('audio#releaseSound')[0].play();
        $(".dragger:hover").css( "cursor","grab");
        $(this).css("opacity", "1");
        
        
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
        containment: ".main-page",
        scroll: false,
        stop: function (event, ui) {
            positions[this.id] = ui.position
            localStorage.positions = JSON.stringify(positions)
            
        }
    });
});
    
});
