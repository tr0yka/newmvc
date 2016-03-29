$(document).ready(function(){
    $('#sort').tablesorter();

    $('#addBtn').click(function(){
        $('#popup').css({"display":"block"});
    });
    $('#close').click(function(){
        $('#popup').css({"display":"none"});
    });


    $('#uploadFile').click(function(){
        var formData = new FormData();
        formData.append('userfile',$('#userfile').prop('files')[0]);
        formData.append('comment',$('#comment').val());
        formData.append('description',$('#description').val());
        formData.append('fileUpload','1');


        $.ajax({
            method: 'POST',
            url: '/files/upload',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data){
                console.log(data);
            }
        });
        return false;
    });
});