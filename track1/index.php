<?php   
    try {  
        $dbh = new PDO("mysql:host=localhost;dbname=track1", "root", NULL);  
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
        $stmt = $dbh->prepare("UPDATE page_views SET counter = counter + 1");  
        $stmt->execute();  
        $stmt = $dbh->prepare('SELECT counter FROM page_views');  
        $stmt->execute();  
        $row = $stmt->fetch();  
        $counter = $row["counter"];  
    } catch (PDOException $e) {  
        exit($e->getMessage());  
    }  
?>  
  
<title>Track 1</title>  
  
<h1>Track 1 Assignment</h1>  
  
<p>Page views: <?php print($counter) ?> </p>