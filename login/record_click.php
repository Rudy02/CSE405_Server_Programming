<?php 
    session_start();
    if(!isset($_SESSION['username'])){
        exit('Not logged in');
    }
    try {
        $dbh = new PDO("mysql:host=localhost;dbname=login", "root", NULL);
    } catch (PDOException $e) {
        exit('database connection failed.'.$e->getMessage());
    }   
        $stmt = $dbh->prepare("UPDATE users SET click_count = click_count + 1 WHERE username=:username");
        $stmt->bindParam(':username',$_SESSION['username']) or exit("bind failed.");
        $stmt->execute() or exit("update failed.");
?>