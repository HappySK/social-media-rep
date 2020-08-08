<?php
    session_start();
    if(isset($_SESSION['id']))
    {
        echo 'Your session id is: '.$_SESSION['id'].'<a href="logout.php">Logout</a>';
    }
?>