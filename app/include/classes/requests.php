<?php
    require 'connect.php';
    class requests extends register
    {
        function __construct()
        {
            parent::__construct();
        }
        function isRequestsReceived($s_id)
        {
            try
            {
                $sql="SELECT `id`,`firstname`,`lastname` FROM reg_table WHERE `id` IN (SELECT `sender_id` FROM friend_requests WHERE `receiver_id`=:s_id AND `status`=:status)";
                $stmt=$this->conn->prepare($sql);
                $stmt->bindParam(':s_id',$s_id);
                $stmt->bindValue(':status','requested');
                $stmt->execute();
                $data=array();
                while($row=$stmt->fetchObject())
                {
                    $record['id']=$row->id;
                    $record['firstname']=$row->firstname;
                    $record['lastname']=$row->lastname;
                    array_push($data,$record);
                }
                echo json_encode($data);
            }
            catch(PDOException $e)
            {
                $e->getMessage();
            }
        }
        function isRequestAccepted($s_id,$r_id)
        {
            try
            {
                $sql="UPDATE friend_requests SET `status`=:status WHERE `sender_id`=:s_id AND `receiver_id`=:r_id";
                $stmt=$this->conn->prepare($sql);
                $stmt->bindParam(':s_id',$s_id);
                $stmt->bindParam(':r_id',$r_id);
                $stmt->bindValue(':status','friends');
                if($stmt->execute())
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch(PDOException $e)
            {
                $e->getMessage();
            }
        }
        function isRequestRejected($s_id,$r_id)
        {
            try
            {
                $sql="UPDATE friend_requests SET `status`=:status WHERE `sender_id`=:s_id AND `receiver_id`=:r_id";
                $stmt=$this->conn->prepare($sql);
                $stmt->bindParam(':s_id',$s_id);
                $stmt->bindParam(':r_id',$r_id);
                $stmt->bindValue(':status','not_friends');
                if($stmt->execute())
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch(PDOException $e)
            {
                $e->getMessage();
            }
        }
    }
    $requests=new requests();
    if(isset($_POST['s_id']))
    {
        if(!empty($_POST['s_id']))
        {
            $requests->isRequestsReceived($_POST['s_id']);
        }
    }
    if(isset($_POST['action'])&&isset($_POST['receiver_id'])&&isset($_POST['receiver_id']))
    {
        if(!empty($_POST['action'])&&!empty($_POST['sender_id'])&&!empty($_POST['receiver_id']))
        {
            if($_POST['action']=='update')
            {
                if($requests->isRequestAccepted($_POST['sender_id'],$_POST['receiver_id']))
                {
                    echo "Query Updated";
                }
                else
                {
                    echo "Query Failed";
                }
            }
            else if($_POST['action']=='notfriends')
            {
                if($requests->isRequestRejected($_POST['sender_id'],$_POST['receiver_id']))
                {
                    echo "Query Updated";
                }
                else
                {
                    echo "Query Failed";
                }
            }
        }
    }
?>