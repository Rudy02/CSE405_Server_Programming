<?php
    session_start();
    
    
    
    try{
            $dbh = new PDO("mysql:host=localhost;dbname=blog","root",NULL);
    } catch (PDOException $e){
            exit('Database connection failed: ' . $e->getMessage());
    }
    
    $stmt = $dbh->prepare("SELECT blogtext FROM users WHERE username = :username");
    $stmt->bindParam(':username', $_GET['u']);
    $stmt->execute() or exit("SELECT failed.");
    
    if ($stmt->rowcount() == 0){
        header('Location: ./');
        exit();
    }
    
    $row = $stmt->fetch() or exit("fetch failed.");
    $blogtext = $row["blogtext"];
?>

<h1 style="text-align: center;">Here's the Blog!</h1>

<p><a href = "./"> Home </a></p>

<div id ="blogtext" style="color: black"><?php print ($blogtext) ?> </div>

<?php if (isset($_SESSION['username']) and $_SESSION['username'] == $_GET['u']) { ?>
    <div style="align: center;">
    <button onclick ="window.location='editblog.php'">Edit</button>
<?php } ?>