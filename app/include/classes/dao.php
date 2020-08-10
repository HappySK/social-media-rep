<?php
class dao extends register
{
    function __construct()
    {
        parent::__construct();
    }
    function getUserData($id)
    {
        $sql="SELECT * FROM reg_table WHERE `id`=:id";
        $stmt=$this->conn->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $data=$stmt->fetchObject();
        return $data;
    }
}
$dao=new dao();
?>