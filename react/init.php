<?php
    session_start();
    
   if (!isset($_SESSION['username'])) {
       //user is not logged in
        $response = array('result' => 'notLoggedIn');
        print(json_encode($response));
        exit();
   }
 
    $username = $_SESSION['username'];
    
     try {
        $dbh = new PDO("mysql:host=localhost;dbname=react", "rudydiaz02", NULL);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $dbh->prepare('SELECT click_count FROM users WHERE username=:username');
        $stmt->bindParam(':username' , $username);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            //user record was deleted after login
            exit();
        }
        $row = $stmt->fetch();
        $clickCount = $row["click_count"];
        } catch (PDOException $e) {
        $response = array('result' => 'error' , 'msg' => $e->getMessage());
        print(json_encode($response));
        exit();
    }
    
    $response = array('result' => 'LoggedIn' ,'clickCount' => $clickCount);
    print(json_encode($response));
?>