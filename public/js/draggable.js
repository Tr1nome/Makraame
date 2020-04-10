$(document).ready(function(){

    //grab
    $(".dragger").mousedown(function(){
        $('audio#grabSound')[0].play();
        
        
        
    });
    //release
    $(".dragger").mouseup(function(){
        $('audio#releaseSound')[0].play();
        
        
        
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
        grid:[50,50],
        containment:[350,10,1150,650],
        opacity: 0.35,
        addClasses: false,
        snap:true,
        refreshPositions: true,
        cursor: "grabbing",
        scroll: false,
        stop: function (event, ui) {
            positions[this.id] = ui.position
            localStorage.positions = JSON.stringify(positions)
            
        }
    });
    var positionsS = JSON.parse(localStorage.positionsS || "{}");
    $(function () {
    var s = $("[id=sticker]").attr("id", function (i) {
        return "sticker_" + i
    })
    $.each(positionsS, function (id, pos) {
        $("#" + id).css(pos)
    })

    s.draggable({
        addClasses: false,
        containment: "body",
        cursor: "grabbing",
        scroll: false,
        stop: function (event, ui) {
            positionsS[this.id] = ui.position
            localStorage.positionsS = JSON.stringify(positionsS)
            
        }
    });
});
    
});
});
