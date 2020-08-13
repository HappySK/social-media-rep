<?php
    session_start();
    /* This file will get visited once the user presses logout button */
    if(isset($_SESSION['id']))
    {
        /* If the session is set, it will unset all the other session variable */
        session_unset();
    }
    /* Redirects to Index page */
    header('location:../public/index.html')
?>