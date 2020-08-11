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
                $record['firstname']=ucwords($row->firstname);
                $record['lastname']=ucwords($row->lastname);
                array_push($data,$record);
            }
            echo json_encode($data);
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

?>