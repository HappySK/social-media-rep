<?php
    const ds = DIRECTORY_SEPARATOR;
    if(isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['modal']))
    {
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        $modal=$_POST['modal'];
        $data=array('firstname'=>$fname,'lastname'=>$lname,'email'=>$email,'password'=>$password,'modal'=>$modal);
        define('CONFIG_PATH',dirname(__FILE__,3).ds.'config'.ds.'config.php');
        require constant('CONFIG_PATH');
        require $config['CLASS_PATH'].ds.'connect.php';
        if($data['modal']=='reg')
        {
            if($log->isRegistered($data))
            {
                echo 'User Already exists';
            }
            else
            {
                $log->register($data);
            }
        }
        else if($data['modal']=='log')
        {
            if(!$log->login($data))
            {
                echo "Invalid emailID or Password";
            }
        }
    }
    else
    {
        echo "All are not set";
    }

?>