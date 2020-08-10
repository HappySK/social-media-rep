msg=$('#status').val();
query_string='id='+session_id+'&msg='+msg;
$(document).ready(function(){
    //ajax_posts(query_string);
    alert(window.query_string);
    $('#post').click(function(){
    });
});
function ajax_posts(query_string)
{
    $.ajax({
        url:'../app/include/classes/profile.php',
        type:'POST',
        dataType:'JSON',
        data:query_string,
        success:function(data)
        {
            $.each(data,function(index,item){
                $('#contents').after('<p>'+item.message+' '+item.date+'</p>');
            });
        }
    });
}