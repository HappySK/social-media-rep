<?php
    const ds = DIRECTORY_SEPARATOR;
    session_start();
    /* Checking whether the user is logged in */
    if(isset($_SESSION['id']))
    {
        defined('APPLICATION_PATH') || define('APPLICATION_PATH',dirname(__FILE__));
        $config=['CLASS_PATH'=>constant('APPLICATION_PATH').ds.'include'.ds.'classes'.ds];
        require $config['CLASS_PATH'].'connect.php';
        require $config['CLASS_PATH'].'dao.php';
        $user_data=$dao->getUserData($_SESSION['id']);
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
            <marquee behavior="scroll" direction="left" scrollamount="20" onmouseover="this.stop()" onmouseout="this.start()">Welcome <?=ucwords($user_data->firstname)?>  <a href="logout.php">Logout</a></marquee>
        </header>
        <div id="profile">
            <div>
                <h1 id="title">
                    Profile
                </h1>
            </div>
            <div id="user_media">
                <img src="../app/images/avatar_preset.png" alt="preset_avatar">
                <!-- Getting the firstname and lastname from the object $dao -->
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
            <br>     
            <div id="my_posts">
                <h1>My Posts</h1>
                <ul id="contents">
                    <!-- Data would be rendered using AJAX Calls  -->
                </ul>
            </div>  
        </div>
        <div id="newsfeed">
            <h1>
                Newsfeed
            </h1>
            <ul id="newsfeed_contents">
                <!-- Data to be rendered asynchronously -->
            </ul>
        </div>
        <div id="friend-request">
            <h1>
                Friend Request
            </h1>
            <div id="tabs">
                <!-- Tabs in Friend Requests Section -->
                <label for="friends">Friends</label>
                <label for="requests">Request</label>
                <label for="suggestions">Suggestions</label>
            </div>
            <div id="tab-contents">
                <!-- Tab contents that are displayed according to users check on the tabs -->
                <input type="radio" name="tabs" id="friends" checked hidden>
                <div class="disp-friends">
                    <div id="friends-section">
                        <!-- Files that are rendered dynamically by using jQuery and PHP -->
                    </div>
                </div>
                <input type="radio" name="tabs" id="requests" hidden>
                <div class="disp-requests">
                    Requests Section
                    <div id="friend-requests">
                        <!-- Files that are rendered dynamically by using jQuery and PHP -->
                    </div>
                </div>
                <input type="radio" name="tabs" id="suggestions" hidden>
                <div class="disp-suggestions">
                    Suggestions section
                    <div id="friend-suggestions">
                        <!-- Files that are rendered dynamically by using jQuery and PHP -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="../app/js/jquery.js"></script>
    <!-- This JS Variable is used in order to access session id in JS -->
    <script>var session_id=<?=$_SESSION['id']?></script>
    <script src="../app/js/welcome-main.js"></script>
</body>
</html>