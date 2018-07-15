<?PHP

try {

    $dbh = new PDO('mysql:host=localhost;dbname=track2', "root", NULL);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $dbh->prepare("UPDATE page_views SET counter = counter +1");
    $stmt->execute();
    $stmt = ($dbh->prepare('SELECT counter from page_views'));
    $stmt->execute();
    $counter = $stmt->fetchColumn(0);
    $responseObject = array(counter => $counter);
    $jsonString = json_encode($responseObject);
   
    
} catch (PDOException $e) {
    exit($e->getMessage());
}
 print($jsonString);
?>

