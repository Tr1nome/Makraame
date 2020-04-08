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
        containment:[300,0,1200,600],
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
});
    
});
