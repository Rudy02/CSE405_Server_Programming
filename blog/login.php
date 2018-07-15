<?php

    session_start();
    
    $username = $_POST['username'];
    $submitted_password = $_POST['password'];
    
    if (!isset($username) or !isset($submitted_password)){
        header('Location: ./');
        exit();
    }
    
    try{
        $dbh = new PDO("mysql:host=localhost;dbname=blog","root",NULL);
    } catch (PDOException $e){
        exit('Database connection failed: ' . $e -> getMessage());
    }
    
    $stmt = $dbh->prepare("SELECT password FROM users WHERE username = :username");
    $stmt->bindParam(':username',$username);
    $stmt->execute() or exit("SELECT failed.");
    
    if ($stmt->rowCount()==0){
        header('Location: ./');
        exit();
    }
    
    $row = $stmt->fetch() or exit("fetch failed.");
    $actual_password = $row["password"];
    
    if($submitted_password != $actual_password){
        header('Location: ./');
        exit();
    }
    
    //Logged in
    $_SESSION['username'] = $username;
    
    header('Location: ./');
?> 