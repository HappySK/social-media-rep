<?php
    require 'connect.php';
    class suggestions extends register
    {   
        function __construct()
        {
            parent::__construct();
        }

        function getFriendsData($id)
        {
            $sql="SELECT * FROM reg_table WHERE `id`!=:id";
            $stmt=$this->conn->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            $data=array();
            while($row=$stmt->fetchObject())
            {
                $record['id']=$row->id;
                $record['firstname']=ucwords($row->firstname);
                $record['lastname']=ucwords($row->lastname);
                array_push($data,$record);
            }
            echo json_encode($data);
        }
        function addFriend($fid,$uid)
        {
            $sql="INSERT INTO friend_requests(`user_id`,`friend_id`)VALUES(:uid,:fid)";
            $stmt=$this->conn->prepare($sql);
            $stmt->bindParam(':uid',$uid);
            $stmt->bindParam(':fid',$fid);
            if(!$stmt->execute())
            {
                echo "Something went wrong";
            }
        }
    }
    $suggestions=new suggestions();
    if(isset($_POST['id']))
    {
        if(!empty($_POST['id']))
        {
            $suggestions->getFriendsData($_POST['id']);
        }
    }
    if(isset($_POST['f_id'])&&isset($_POST['u_id']))
    {
        if(!empty($_POST['f_id'])&&!empty($_POST['u_id']))
        {
            $suggestions->addFriend($_POST['f_id'],$_POST['u_id']);
        }
    }
?>