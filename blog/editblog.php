<?php
    session_start();
    
    try{
            $dbh = new PDO("mysql:host=localhost;dbname=blog","root",NULL);
    } catch (PDOException $e){
            exit('Database connection failed: ' . $e->getMessage());
    }
    
    $stmt = $dbh->prepare("SELECT blogtext FROM users WHERE username = :username");
    $stmt->bindParam(':username',$_SESSION['username']);
    $stmt->execute() or exit("SELECT failed.");
    
    if ($stmt->rowcount() == 0){
        header('Location: ./');
        exit();
    }
    
    $row = $stmt->fetch() or exit("fetch failed.");
    $blogtext = $row["blogtext"];
?>


<h1> Edit Blog Page</h1>

<p><a href="./">Home</a></p>

<form action="saveblog.php" method ="post" style="color:white">
        <textarea name="blogtext" rows="12" cols="80" style="background-color:#009FD4; color: white"><?php print($blogtext) ?></textarea><br>
        <input type="submit" name="cancel" value = "Cancel" size = "24" />
        <input type="submit" value = "Save" size = "24" />
</form>