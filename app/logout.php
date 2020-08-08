<?php
    session_start();
    if(isset($_SESSION['id']))
    {
        session_unset();
    }
    echo "Logged out";
?>