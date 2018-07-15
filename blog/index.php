<?php
    session_start();

    try{
            $dbh = new PDO("mysql:host=localhost;dbname=blog","root",NULL);
    } catch (PDOException $e){
        exit('Database connection failed: ' . $e->getMessage());
    }
    
    $stmt = $dbh->prepare("SELECT username FROM users");
    $stmt->execute() or exit("SELECT failed.");
   
?> 

<h1>Welcome to My Blog</h1>


<?php if(isset($_SESSION['username'])){ ?>
        <form action ="logout.php" method ="post">
            <input type ="submit" value ="Logout"/>
        </form>
        
<?php } else { ?>
        <form action="login.php" method="post" style = "text-align:center; width:400px;height:100px;border:10px solid white;">
                Username: <input type="text" name ="username" value = "fred" size="36" /> <br>
                Password: <input type="password" name="password" value = "1234" size = "36" /> <br>
                <input type="submit" value="Login"/>
        </form>
<?php } ?>

<h2 style="color: black;">Recent Blogs by:</h2>
<ul>
    <?php 
        foreach ($stmt as $row){
            $u = $row['username'];
            echo '<li><a href ="viewblog.php?u=' . $u .'">' . $u . '</a></li>';
        }
    ?>
</ul>
