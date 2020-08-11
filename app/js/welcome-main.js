$(document).ready(function(){
    if($('#status').val()==='')
    {
        query_string='id='+session_id+'&status=autoload';
        ajax_posts(query_string);
    } 
    $('#post').click(function(){
        if($('#status').val()==='')
        {
            query_string='id='+session_id+'&status=autoload';
            ajax_posts(query_string);
        }
        else
        {
            msg=$('#status').val();
            query_string='id='+session_id+'&msg='+msg+'&status=load';
            ajax_posts(query_string);
            $('#status').val('');
        }
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
            $('#contents').empty();
            $.each(data,function(index,item){
                var li=document.createElement('li');
                var h3=document.createElement('h3');
                var cite=document.createElement('cite');
                var hr = document.createElement('hr');
                var message=document.createTextNode(item.message);
                var date=document.createTextNode(item.date);
                h3.appendChild(message);
                cite.appendChild(date);
                li.appendChild(h3);
                li.appendChild(cite);
                li.appendChild(hr);
                document.getElementById('contents').appendChild(li);
            });
        }
    });
}
