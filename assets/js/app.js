$(document).ready(function(){
    $('#sort').tablesorter();

    $('#addBtn').click(function(){
        $('#popup').css({"display":"block"});
    });
    $('#close').click(function(){
        $('#popup').css({"display":"none"});
    });
    $('#closeErrors').click(function(){
        $('#errors').css({'display':'none'})
    });

    $('#filter>input').keypress(function(e){
        var text = $(this).val();
        if(e.keyCode == 13){
            $.get('/files/filter/?filter='+text).done(function(data){
                $('#sort tbody').html(data);
            });
        }
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
                $('#popup').css({"display":"none"});
                $('#userfile').val('');
                var file = JSON.parse(data);
                if(file.errors == ''){
                    var tr = '<tr>'+
                                '<td><a href="/files/download/?file='+file.file.id+'">'+file.file.originalName+'</a></td>'+
                                '<td>'+parseInt(file.file.fileSize/1024)+'</td>'+
                                '<td>'+file.file.fileType+'</td>'+
                                '<td>'+file.file.description+'</td>'+
                                '<td>'+file.file.added+'</td>'+
                             '</tr>';
                    $('#sort tbody').prepend(tr);
                    console.log(tr,file);
                }else{
                    var str = '';
                    for(var i=0; i<file.errors.length;i++){
                        str += file.errors[i]+'<br>';
                    }
                    $('#contentErrors').html(str);
                    $('#errors').css({'display':'block'})
                }

            }
        });
        return false;
    });
});