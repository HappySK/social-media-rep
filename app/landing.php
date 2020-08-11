<li class="bgcolor">
    <h3>H3 Tag</h3>
    <cite>Date</cite>
</li>
<script src="">
    var li=document.createElement('li');
    var h1=codument.createElement('h1');
    var cite=document.createElement('cite');
    var message=document.createTextNode(item.message);
    var date=document.createTextNode(item.date);
    h1.appendChild(message);
    cite.appendChild(date);
    li.appendChild(h1);
    li.appendChild(cite);
    document.getElementById('contents').appendChild(li);
</script>