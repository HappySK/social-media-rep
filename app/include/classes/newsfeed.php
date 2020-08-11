<?php
require 'connect.php';
class newsfeed extends register
{
    function __construct()
    {
        parent::__construct();
    }
    function getFriendsMessages($id)
    {
        try
        {
            $sql="SELECT reg_table.firstname,reg_table.lastname,posts.message,posts.date FROM reg_table,posts WHERE (posts.id=reg_table.id AND posts.id != $id) ORDER BY posts.date DESC";
            $stmt=$this->conn->prepare($sql);
            $stmt->bindParam(':id',$id);
            if($stmt->execute())
            {
                $data=array();
               while($row=$stmt->fetchObject())
                {
                    $record['firstname']=$row->firstname;
                    $record['lastname']=$row->lastname;
                    $record['message']=$row->message;
                    $record['date']=$row->date;
                    array_push($data,$record);
                }
                echo json_encode($data);
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
}
$newsfeed=new newsfeed();
if(isset($_POST['id']))
{
    if(!empty($_POST['id']))
    {
        $newsfeed->getFriendsMessages($_POST['id']);
    }
}
?>