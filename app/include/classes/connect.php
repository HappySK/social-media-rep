<?php
class register
{
    protected $conn=null;

    function __construct()
    {
        try
        {
            $this->conn=new PDO('mysql:host=localhost;dbname=socialreplicate;charset=utf8','root','');
        }
        catch(PDOException $e)
        {
            $e->getMessage();
        }
    }
    public function isRegistered($data)
    {
        try
        {
            $sql="SELECT * FROM reg_table WHERE `email`=:email";
            $stmt=$this->conn->prepare($sql);
            $stmt->bindParam(':email',$data['email']);
            $stmt->execute();
            if($stmt->rowCount()>=1)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        catch(PDOExeption $e)
        {
            $e->getMessage();
        }
    }
    public function register($data)
    {
        try
        {
            $sql="INSERT INTO reg_table(`id`,`firstname`,`lastname`,`email`,`password`) VALUES(:id,:fname,:lname,:email,:pwd)";
            $stmt=$this->conn->prepare($sql);
            $stmt->bindParam(':id',$data['id']);
            $stmt->bindParam(':fname',$data['firstname']);
            $stmt->bindParam(':lname',$data['lastname']);
            $stmt->bindParam(':email',$data['email']);
            $stmt->bindParam(':pwd',$data['password']);
            if($stmt->execute())
            {
                session_start();
                $_SESSION['id']=$data['id'];
            }    
            else
            {
                echo "Something Went Wrong Please try again later";
            }        
        }
        catch(PDOException $e)
        {
            $e->getMessage();
        }
    }
    public function login($data)
    {
        try
        {
            $sql="SELECT * FROM reg_table WHERE `email`=:email AND `password`=:pwd";
            $stmt=$this->conn->prepare($sql);
            $stmt->bindParam(':email',$data['email']);
            $stmt->bindParam(':pwd',$data['password']);
            if($stmt->execute())
            {
               if($stmt->rowCount()>=1)
               {
                    session_start();
                    $db_data=$stmt->fetchObject();
                    $_SESSION['id']=$db_data->id;
                    return true;
               }
               else
               {
                   return false;
               }
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
$log=new register();
?>