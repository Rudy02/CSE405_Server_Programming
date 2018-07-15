<?php
    session_start();
    
    if(!isset($_SESSION['username'])) {
          exit();
    }

    $username = $_SESSION['username'];
    
    try {
        $dbh = new PDO("mysql:host=localhost;dbname=react", "rudydiaz02" , NULL);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $dbh->prepare("UPDATE users SET click_count=click_count + 1 WHERE username=:username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $stmt = $dbh->prepare('SELECT click_count FROM users WHERE username=:username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if( $stmt ->rowCount()==0) {
            $response = array('error' => 'Something has happened');
            print(json_encode($response));
            exit();
        } 
 
        $row = $stmt->fetch();
       } catch (PDOException $e) {
         $response = array('result' => 'error', 'msg' => $e->getMessage());
         print(json_encode($response));
         exit();
    }

    $clickCount = $row["click_count"];
    
    $response = array('result' => 'success', 'clickCount' => $clickCount);
    print(json_encode($response));
?>