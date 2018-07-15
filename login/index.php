<?php
    session_start();
    if (isset($_SESSION['username'])){
        header('Location: clickme.php');
        exit();
        }
?>
<h2> Time to login in</h2>

<form action="login.php" method="post">
    Username: <input type="text"     name="username"  size="36" /> <br>
    Password: <input type="password"  name="password"  size="36" /> <br>
    <input type="submit"   value = "Submit" />
</form>