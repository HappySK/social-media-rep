<?php
    const ds = DIRECTORY_SEPARATOR;
    session_start();
    if(isset($_SESSION['id']))
    {
        defined('APPLICATION_PATH') || define('APPLICATION_PATH',dirname(__FILE__));
        $config=['CLASS_PATH'=>constant('APPLICATION_PATH').ds.'include'.ds.'classes'.ds];
        require $config['CLASS_PATH'].'connect.php';
        require $config['CLASS_PATH'].'dao.php';
        $data=$dao->getData($_SESSION['id']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Media Site | Welcome</title>
</head>
<link rel="stylesheet" href="./css/welcome-style.css">
<body>
    <section>
        <header>
            <marquee behavior="scroll" direction="left" scrollamount="20" onmouseover="this.stop()" onmouseout="this.start()">Welcome <?=$data->firstname?>  <a href="logout.php">Logout</a></marquee>
        </header>
        <div id="profile">
            <h1>
                <u>Profile</u>
            </h1>
            <h1><?=$data->firstname?></h1>           
        </div>
        <div id="newsfeed">
            <h1>
                <u>Newsfeed</u>
            </h1>
        </div>
        <div id="friend-request">
            <h1>
                <u>Friend-requests</u>
            </h1>
        </div>
    </section>
</body>
</html>