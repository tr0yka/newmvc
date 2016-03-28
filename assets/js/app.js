$(document).ready(function(){
    $('#sort').tablesorter();

    $('#addBtn').click(function(){
        $('#popup').css({"display":"block"});
    });
    $('#close').click(function(){
        $('#popup').css({"display":"none"});
    });
});