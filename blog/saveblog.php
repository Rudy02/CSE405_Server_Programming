<?php
    session_start();
    
    if(!isset($_SESSION['username'])){
        header('Location: ./');
        exit();
    }
    
    if(isset($_POST['cancel'])){
            header('Location: viewblog.php?u=' . $_SESSION['username']);
            exit();
    }
    
    if(!isset($_POST['blogtext'])){
        header('Location: ./');
        exit();
    }
    $blogtext = $_POST['blogtext'];
    

    
    try{
            $dbh = new PDO("mysql:host=localhost;dbname=blog","root",NULL);
    } catch (PDOException $e){
        exit('Database connection failed: ' . $e->getmessage());
    }
    
    $stmt =  $dbh->prepare("UPDATE users SET blogtext = :blogtext WHERE username = :username");
    $stmt->bindParam(':blogtext',$blogtext);
    $stmt->bindParam(':username',$_SESSION['username']);
    $stmt->execute() or exit("UPDATE failed.");
    
    
    header('Location: viewblog.php?u= ' . $_SESSION['username']);
?>
    