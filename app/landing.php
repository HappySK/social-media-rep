<!-- <input type="button" class="btns" value="One">
<input type="button" class="btns" value="Two"> -->
<div id="sample"></div>
<script src="../app/js/jquery.js"></script>
<script type="text/javascript">
    for(i=0;i<5;i++)
    {
        var div=document.createElement("div");
        var input=document.createElement("input");
        input.setAttribute("type","button");
        input.setAttribute("value","Add Friend");
        input.classList.add("btns");
        div.appendChild(input);
        document.getElementById("sample").appendChild(div);
    }
    $('.btns').click(function(){
        alert('Working');
    });
</script>