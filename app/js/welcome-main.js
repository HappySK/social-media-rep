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
    $(document).on("click",'.btns',function(){
        if($(this).val()=="Add Friend")
        {
            $.post('../app/include/classes/suggestions.php','action=insert&sender_id='+session_id+'&receiver_id='+$(this).attr('session'));
            $(this).val('Cancel');
        }
        else if($(this).val()=="Cancel")
        {
            $.post('../app/include/classes/suggestions.php','action=delete&sender_id='+session_id+'&receiver_id='+$(this).attr('session'));
            $(this).val("Add Friend");
        }
    });
    ajax_requests(session_id);
    $(document).on('click','.req-btns',function(){
        if($(this).val()=='Accept')
        {
            $(this).next().hide(100);
            $.post('../app/include/classes/requests.php','action=update&sender_id='+$(this).attr('session')+'&receiver_id='+session_id);
            $(this).val('Accepted');
        }
        else if($(this).val()=='Reject')
        {
            $(this).prev().hide(100);
            $.post('../app/include/classes/requests.php','action=notfriends&sender_id='+$(this).attr('session')+'&receiver_id='+session_id);
            $(this).val('Rejected');
        }
    });
    ajax_friends(session_id);
    $('#friends').click(function(){
        ajax_friends(session_id);
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
                $('#friend-suggestions').empty();
                $.each(data,function(index,item){
                    var div=document.createElement("div");
                    var fullname=item.firstname+' '+item.lastname;
                    var h3=document.createElement("h3");
                    var name=document.createTextNode(fullname);
                    var inputadd=document.createElement("input");
                    inputadd.setAttribute("type","button");
                    if(val=suggestion(session_id,item.id))
                    {
                        if(val=='Continue')
                        {
                            return;
                        }
                        inputadd.setAttribute("value",val);
                    }
                    else
                    {
                        inputadd.setAttribute("value","Add Friend");
                    }
                    inputadd.setAttribute("class","btns");
                    inputadd.setAttribute('session',item.id);
                    h3.appendChild(name);
                    div.appendChild(h3);
                    div.appendChild(inputadd);
                    document.getElementById("friend-suggestions").appendChild(div);
                });
            }
        });
        
    });
}
function suggestion(session_id,friend_id)
{
    $.ajax({
        url:'../app/include/classes/suggestions.php',
        type:'GET',
        dataType:'html',
        async:false,
        data:'section=suggestions'+'&sender_id='+session_id+'&receiver_id='+friend_id,
        success:function(data)
        {
            result=data;
        }
    });
    return result;
}

function ajax_requests(session_id)
{
    $('#requests').click(function(){
        $.ajax({
            url:'../app/include/classes/requests.php',
            type:'POST',
            dataType:'JSON',
            data:'s_id='+session_id,
            success:function(data)
            {
                $('#friend-requests').empty();                
                $.each(data,function(index,item){
                    var div=document.createElement('div');
                    var h3 = document.createElement('h3');
                    var accept_input=document.createElement('input');
                    var reject_input=document.createElement('input');
                    var span=document.createElement('span');
                    var name=item.firstname+' '+item.lastname;
                    var text_name=document.createTextNode(name);
                    accept_input.setAttribute('type','button');
                    accept_input.setAttribute('value','Accept');
                    reject_input.setAttribute('type','button');
                    reject_input.setAttribute('value','Reject');
                    accept_input.setAttribute('class','req-btns');
                    accept_input.setAttribute('session',item.id);
                    reject_input.setAttribute('class','req-btns');
                    reject_input.setAttribute('session',item.id);
                    h3.appendChild(text_name);
                    span.appendChild(accept_input);
                    span.appendChild(reject_input);
                    div.appendChild(h3);
                    div.appendChild(span);
                    document.getElementById('friend-requests').appendChild(div);
                });
            }
        });
    });
}
function ajax_friends(session_id)
{
    $('#friends-section').empty();
    $.ajax({
        url:'../app/include/classes/friends.php',
        dataType:'JSON',
        type:'POST',
        data:'session_id='+session_id,
        success:function(data)
        {
            $.each(data,function(index,item){
                var img=document.createElement('img');
                var h3 = document.createElement('h3');
                img.setAttribute('src','../app/images/avatar_preset.png');
                img.setAttribute('width','70px');
                img.setAttribute('height','70px');
                var name=item.firstname+' '+item.lastname;
                var text=document.createTextNode(name);
                h3.appendChild(text);
                document.getElementById('friends-section').appendChild(img);
                document.getElementById('friends-section').appendChild(h3);
            });
        }
    });
}