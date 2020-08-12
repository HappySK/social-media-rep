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
        function addFriend($s_id,$r_id)
        {
            $sql="INSERT INTO friend_requests(`sender_id`,`receiver_id`)VALUES(:uid,:fid)";
            $stmt=$this->conn->prepare($sql);
            $stmt->bindParam(':uid',$s_id);
            $stmt->bindParam(':fid',$r_id);
            if(!$stmt->execute())
            {
                echo "Something went wrong";
            }
        }
        function not_friends($s_id,$r_id)
        {
            $sql="SELECT * FROM friend_requests WHERE `sender_id`=:s_id AND `receiver_id`=:r_id AND `status`=:states";
            $stmt=$this->conn->prepare($sql);
            $stmt->bindParam(':s_id',$s_id);
            $stmt->bindParam(':r_id',$r_id);
            $stmt->bindValue(':states','not_friends');
            if($stmt->execute()&&$stmt->rowCount()>0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        function isRequestSent($s_id,$r_id)
        {
            $sql="SELECT * FROM friend_requests WHERE `sender_id`=:s_id AND `receiver_id`=:r_id AND `status`=:states";
            $stmt=$this->conn->prepare($sql);
            $stmt->bindParam(':s_id',$s_id);
            $stmt->bindParam(':r_id',$r_id);
            $stmt->bindValue(':states','requested');
            if($stmt->execute()&&$stmt->rowCount()>0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        function isAlreadyFriends($s_id,$r_id)
        {
            $sql="SELECT * FROM friend_requests WHERE `sender_id`=:s_id AND `receiver_id`=:r_id AND `status`=:states";
            $stmt=$this->conn->prepare($sql);
            $stmt->bindParam(':s_id',$s_id);
            $stmt->bindParam(':r_id',$r_id);
            $stmt->bindValue(':states','friends');
            if($stmt->execute()&&$stmt->rowCount()>0)
            {
                return true;
            }
            else
            {
                return false;
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
    if(isset($_POST['sender_id'])&&isset($_POST['receiver_id']))
    {
        if(!empty($_POST['sender_id'])&&!empty($_POST['receiver_id']))
        {
            $suggestions->addFriend($_POST['sender_id'],$_POST['receiver_id']);
        }
    }
    if(isset($_GET['section'])&&isset($_GET['sender_id'])&&isset($_GET['receiver_id']))
    {
        if(!empty($_GET['section'])&&!empty($_GET['sender_id'])&&!empty($_GET['receiver_id']))
        {
            if($suggestions->not_friends($_GET['sender_id'],$_GET['receiver_id']))
            {
                echo "Add Friends";
            }
            else if($suggestions->isAlreadyFriends($_GET['sender_id'],$_GET['receiver_id']))
            {
                echo "Continue";
            }
            else if($suggestions->isRequestSent($_GET['sender_id'],$_GET['receiver_id']))
            {
                echo "Cancel";
            }
        }
    }
?>