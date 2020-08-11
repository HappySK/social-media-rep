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
    ajax_newsfeed(session_id);
    ajax_suggestions(session_id);
    $('.btns').click(function(){
        alert('Working');
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
function ajax_newsfeed(session_id)
{
    $.ajax({
        url:'../app/include/classes/newsfeed.php',
        data:'id='+session_id,
        dataType:'JSON',
        type:'POST',
        success:function(data)
        {
            $.each(data,function(index,item){
                var li = document.createElement('li');
                var h3=document.createElement('h3');
                var p=document.createElement('p');
                var cite=document.createElement('cite');
                var fname=document.createTextNode(item.firstname);
                var lname=document.createTextNode(item.lastname);
                var msg=document.createTextNode(item.message);
                var date=document.createTextNode(item.date);
                h3.appendChild(fname);
                p.appendChild(msg);
                cite.appendChild(date);
                li.appendChild(h3);
                li.appendChild(p);
                li.appendChild(cite);
                document.getElementById('newsfeed_contents').appendChild(li);
                li.classList.add("newsfeed_data")
            });
        }
    });
}
function ajax_suggestions(session_id)
{
    $('#suggestions').click(function(){
        $.ajax({
            url:'../app/include/classes/suggestions.php',
            type:'POST',
            data:'id='+session_id,
            dataType:'JSON',
            success:function(data)
            {
                $.each(data,function(index,item){
                    var div=document.createElement('div');
                    var fullname=item.firstname+' '+item.lastname;
                    var h3=document.createElement('h3');
                    var name=document.createTextNode(fullname);
                    var input_add=document.createElement('input');
                    input_add.setAttribute('type','button');
                    input_add.setAttribute('value','Add Friend');
                    h3.appendChild(name);
                    div.appendChild(h3);
                    div.appendChild(input_add);
                    input_add.classList.add("btns");
                    document.getElementById('friend-suggestions').appendChild(div);
                });
            }
        });
    });
}
