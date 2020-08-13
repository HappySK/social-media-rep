<?php
    require 'connect.php';
    class friends extends register
    {
        function __construct()
        {
            parent::__construct();
        }
        function isFriends($s_id)
        {
            try
            {
                $sql="SELECT `id`,`firstname`,`lastname` FROM reg_table WHERE `id` IN (SELECT `receiver_id` FROM friend_requests WHERE `sender_id`=:s_id AND `status`=:status)";
                $stmt=$this->conn->prepare($sql);
                $stmt->bindParam(':s_id',$s_id);
                $stmt->bindValue(':status','friends');
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
    }
    $friends=new friends();
    if(isset($_POST['session_id']))
    {
        if(!empty($_POST['session_id']))
        {
            $friends->isFriends($_POST['session_id']);
        }
    }
?>