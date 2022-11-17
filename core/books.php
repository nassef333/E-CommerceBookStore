<?php

class book{

public $connection;

public function __construct(){
    $this->connection = mysqli_connect("localhost","root","","online_library");
   }

   public function execute($sql){
    return mysqli_query($this->connection,$sql);
   }
   public function addBook($name, $description, $author, $category, $noPages, $price, $img, $state, $cdn, $category_id){
        $sql = "INSERT INTO `books` (`name`, `description`, `author`, `category`, `noPages`, `price`, `img`, `state`, `cdn`, `category_id`) VALUES ('$name', '$description', '$author', '$category', '$noPages', '$price', '$img', '$state', '$cdn', '$category_id')";
        $this->execute($sql);
        return($this->connection->affected_rows);
    }

    public function removebook($id){
        $sql = "DELETE FROM `books` WHERE `id` = '$id'";
        $this->execute($sql);
        return($this->connection->affected_rows);
    }

    public function editBook($id, $name, $description, $author, $category, $noPages, $price, $img, $state, $cdn, $category_id){
        $sql = "UPDATE `books` SET `name` = '$name', `description` = '$description', `author` = '$author', `category` = '$category', `img` = '$img', `cdn` = '$cdn', `category_id` = '$category_id' WHERE `books`.`id` = '$id'";
        $this->execute($sql);
        return($this->connection->affected_rows);
    }

    public function getBook($id){
        $sql = "SELECT * FROM `books` WHERE `id` = $id";
        return mysqli_fetch_all($this->execute($sql), MYSQLI_ASSOC);
    }


    public function rateBook($user_id, $book_id, $rate){
        $sql = "INSERT INTO `rating` (`user_id`, `book_id`, `rate`) VALUES ('$user_id', '$book_id', '$rate')";
        $this->execute($sql);
        return($this->connection->affected_rows);
    }
    public function rateById($id){
        $sql = "SELECT AVG(rate) FROM `rating` WHERE `book_id` ='$id'";
        return mysqli_fetch_column($this->execute($sql));
    }
    public function topRated(){
        $sql = "SELECT `book_id`, AVG(rate) FROM `rating` GROUP BY `book_id` ORDER BY `AVG(rate)` DESC";
        return mysqli_fetch_all($this->execute($sql), MYSQLI_ASSOC);
    }


    public function interestBook($user_id, $book_id){
        $sql = "INSERT INTO `interests` (`user_id`, `book_id`) VALUES ('$user_id', '$book_id')";
        $this->execute($sql);
        return($this->connection->affected_rows);
    }
    public function userInterests($id){
        $sql = "SELECT * FROM `interests` WHERE `user_id` ='$id'";
        return mysqli_fetch_all($this->execute($sql), MYSQLI_ASSOC);
    }

    public function wishlistBook($user_id, $book_id){
        $sql = "INSERT INTO `wishlist` (`user_id`, `book_id`) VALUES ('$user_id', '$book_id')";
        $this->execute($sql);
        return($this->connection->affected_rows);
    }
    public function userWishlists($id){
        $sql = "SELECT * FROM `wishlist` WHERE `user_id` ='$id'";
        return mysqli_fetch_all($this->execute($sql), MYSQLI_ASSOC);
    }

    public function getCategory($category_id){
        $sql = "SELECT * FROM `books` WHERE `category_id` = $category_id";
        return mysqli_fetch_all($this->execute($sql), MYSQLI_ASSOC);
    }


    
}


//$obj = new book;
//$obj->addBook("name", "description", "author", "category", "noPages", "price", "img", "state", "cdn", "category_id");
//$obj->editBook(6, "name", "dess", "author", "category", "255", "55", "img", "state", "cdn", "2");
//$obj->removebook(5);
//print_r($obj->rateById(6));
//echo "<pre>"; 
//print_r($obj->topRated());
//print_r($obj->getBook(9));

//$obj->userInterests(4);
