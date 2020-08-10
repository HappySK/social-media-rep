<?php
    require 'connect.php';
    class profile extends register
    {
        function __construct()
        {
            parent::__construct();
        }
        function insertMessage($id,$msg)
        {
            try
            {
                $sql="INSERT INTO posts(`id`,`message`,`date`)VALUES(:id,:msg,:date)";
                $stmt=$this->conn->prepare($sql);
                $stmt->bindParam(':id',$id);
                $stmt->bindParam(':msg',$msg);
                $date=date('Y-m-d H:i:s');
                $stmt->bindParam(':date',$date);
                if($stmt->execute())
                {
                    
                }
                else
                {
                    echo "Query Failed";
                }
            }
            catch(PDOException $e)
            {
                $e->getMessage();
            }
        }
        function getUserPosts($id)
        {
            $sql="SELECT * FROM posts WHERE `id`=:id ORDER BY date DESC";
            $stmt=$this->conn->prepare($sql);
            $stmt->bindParam(':id',$id);
            if($stmt->execute()&&$stmt->rowCount()>0)
            {
                $json_data=array();
                while($row=$stmt->fetchObject())
                {
                    $record['message']=$row->message;
                    $record['date']=$row->date;
                    array_push($json_data,$record);
                }
                echo json_encode($json_data);
            }
            else
            {
                echo "Display Query Failed";
            }
        }
    }
    $profile=new profile();
    if(isset($_POST['status']))
    {
        if(!empty($_POST['status']))
        {
            switch($_POST['status'])
            {
                case 'load':load($profile);
                case 'autoload':autoload($profile);
                                break;
                default: echo "Invalid Choice selected";
            }
        }
    }
    function load($profile)
    {
        if(isset($_POST['id'])&&isset($_POST['msg']))
        {
            if(!empty($_POST['id'])&&!empty($_POST['msg']))
            {
                $id=$_POST['id'];
                $msg=$_POST['msg'];
                $profile->insertMessage($id,$msg);
            }
        }
    }
    function autoload($profile)
    {
        if(isset($_POST['id']))
        {
            if(!empty($_POST['id']))
            {
                $id=$_POST['id'];
                $profile->getUserPosts($id);
            }
        }
    }
?>