<?php
    const ds = DIRECTORY_SEPARATOR;
    session_start();
    if(isset($_SESSION['id']))
    {
        defined('APPLICATION_PATH') || define('APPLICATION_PATH',dirname(__FILE__));
        $config=['CLASS_PATH'=>constant('APPLICATION_PATH').ds.'include'.ds.'classes'.ds];
        require $config['CLASS_PATH'].'connect.php';
        require $config['CLASS_PATH'].'dao.php';
        $user_data=$dao->getUserData($_SESSION['id']);
        setcookie('session',$_SESSION['id']);
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
            <marquee behavior="scroll" direction="left" scrollamount="20" onmouseover="this.stop()" onmouseout="this.start()">Welcome <?=$user_data->firstname?>  <a href="logout.php">Logout</a></marquee>
        </header>
        <div id="profile">
            <div>
                <h1 id="title">
                    Profile
                </h1>
            </div>
            <div id="user_media">
                <img src="../app/images/avatar_preset.png" alt="preset_avatar">
                <h1><?=ucwords($user_data->firstname).' '.ucwords($user_data->lastname)?></h1>
            </div>
            <div id="update_post">
                <h4>Post Your Update</h4>
                <textarea name="current_status" id="status" cols="30" rows="5" maxlength="100" placeholder="Hey, <?=ucwords($user_data->firstname)?> What's happening ?"></textarea>
                    <span>
                        <input type="button" id="post" value="Post">
                        <input type="reset" value="Cancel">
                    </span>
                <p id="feedback"></p>
            </div>     
            <div id="my_posts">
                <h1>My Posts</h1>
                <ul id="contents">
                    
                </ul>
            </div>  
        </div>
        <div id="newsfeed">
            <h1>
                <u>Newsfeed</u>
            </h1>
            <p>
                
            </p>
        </div>
        <div id="friend-request">
            <h1>
                <u>Friend-requests</u>
            </h1>
            <p>
                
            </p>
        </div>
    </section>
    <script src="../app/js/jquery.js"></script>
    <script>var session_id=<?=$_SESSION['id']?></script>
    <script src="../app/js/welcome-main.js"></script>
</body>
</html>