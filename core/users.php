<?php

class user {
    public $connection;
    public $errors = [];
    public function __construct(){
        $this->connection = mysqli_connect("localhost","root","","online_library");
       }

       public function execute($sql){
        return mysqli_query($this->connection,$sql);
       }
    public function validatePass($password) {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        
        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8)
            return false;
        else
            return true;
    }
    
    //get all users
    public function allUsers() {
        $sql = "SELECT * FROM `user`";
        return mysqli_fetch_all($this->execute($sql), MYSQLI_ASSOC);
    }

    //get user by id
    public function getUser($id){
        $sql = "SELECT * FROM `user` WHERE `id` = $id";
        return mysqli_fetch_all($this->execute($sql), MYSQLI_ASSOC);
    }



    
    //email exist//username exist


    public function addUser($firstName, $lastName, $username, $email, $password, $img){
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && $this->validatePass($password)) {
            //$password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `user` (`firstName`, `lastName`, `username`, `email`, `password`, `img`) VALUES ('$firstName', '$lastName', '$username', '$email', '$password', '$img')";
            $this->execute($sql);
        }else{
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $this->errors[]="<p class='text-danger'>Error: Invalid Email provided.</p>";
        if (!$this->validatePass($password))
        $this->errors[]='<p class="text-danger">Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.</p>';
        }
    }
    
    public function editUser($id, $firstName, $lastName, $username, $email, $password, $img){
        //$password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE `user` SET `firstName` = '$firstName', `lastName` = '$lastName', `username` = '$username', `email` = '$email', `password` = '$password', `img` = '$img' WHERE `id` = '$id'";
        $this->execute($sql);
    }
   
//password validation at front with return value
    public function login($email, $password) {
        //if (filter_var($email, FILTER_VALIDATE_EMAIL) && $this->validatePass($password)) {
        //$result = mysqli_query($this->connection, "SELECT * FROM `user` WHERE `email` = '$email'");
        //}else{
        //    echo'<p>Please Try Again</p>';
        //}

        $sql = "SELECT * FROM `user` WHERE `email` = '$email' AND `password` = '$password'";
        $arr = mysqli_fetch_assoc($this->execute($sql));
        if(!empty($arr))
        return($arr);      
    }
    
}


//$obj = new user;
//$obj->addUser("ashraf", "emad", "ahraf123", "ashraf@gmail.com", "shrSaf@123", "");
//print_r($obj->login("ahmednassef8111@gmail.com", "Ahmed@123"));
