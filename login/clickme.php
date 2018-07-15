<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('Location:./');
    }
  //connect to the database
     try {
        $dbh = new PDO("mysql:host=localhost;dbname=login", "root", NULL);
    }catch(PDOException $e){
         exit('Database connection failed:'. $e->getMessage());
    }
    
    //retrieve the actual password for the given user
    $stmt = $dbh->prepare("SELECT click_count FROM users WHERE username = :username");
    $stmt->bindParam(':username',$_SESSION['username']);
    $stmt->execute() or exit("select failed.");
    
    //if there is no such user, then redirect to login page.
    if ($stmt->rowCount() == 0) {
        // If there is no such user, then redirect to login page.
        header('Location: ./'); 
        exit();
    }
    
    //extract the click count
    $row = $stmt->fetch() or exit("fetch failed.");
    $click_count= $row["click_count"];

 ?>
<h1>Clickme Page</h1>

<form action="logout.php" method="post">
    <input type="submit" value="Logout" />
</form>

<p id="counter"><?php print ($click_count)?></p>

<button id="button">Click me!</button>

<script>  // Double check this script.. 4:45 on youtube vid 
    function record_click(){
        var httpRequest = new XMLHttpRequest();
    if (!httpRequest) {
        alert('Browser not supported.');
        return;
    }
    httpRequest.onreadystatechange = function() {
        var responseObject;
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status === 200) {
                if (httpRequest.responseText.length > 0) { 
                    document.getElementById('error_message').innerHTML = httpRequest.responseText;
                }
                
            } else {
                alert('There was a problem with the request.');
                return;
            }
        }
    };
    httpRequest.open('POST', 'http://server-program-fohi08.c9users.io/login/record_click.php');
    httpRequest.send();
    }
    
    var count = <?php print($click_count)?>;
    var counter = document.getElementById('counter');
    var button= document.getElementById('button');
    button.onclick = function(){
       counter.innerHTML = ++count;
       record_click();
    }
</script>