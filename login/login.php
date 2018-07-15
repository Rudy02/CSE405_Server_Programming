<?php
    session_start();
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    //echo $username;
    //echo $password;
    if(!isset($username) or !isset($password)){
        header('Location:./');
        exit();
    }
    
    //connect to the database
     try {
        $dbh = new PDO("mysql:host=localhost;dbname=login", "root", NULL);
    }catch(PDOException $e){
         exit('Database connection failed:'. $e->getMessage());
    }
    
    //retrieve the actual password for the given user
    $stmt = $dbh->prepare("SELECT password FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute() or exit("select failed.");
    
    //if there is no such user, then redirect to login page.
        if ($stmt->rowCount() == 0) {
            // If there is no such user, then redirect to login page.
            header('Location: ./'); 
            exit();
        }
        //extract the actual password
        $row = $stmt->fetch() or exit("fetch failed.");
        $actualPassword = $row["password"];
         //echo $actualPassword;
        //if the submitted password does not match the actual password
        if($password != $actualPassword){
            //header('Location:./');
            exit();
        }
        
        // Log the user in.
        $_SESSION['username'] = $username;
        header('Location: ./clickme.php'); 
        
 
?>