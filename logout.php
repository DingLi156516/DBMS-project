<!-- Logout page -->
<?php
session_start();
session_destroy();  // To end the session

header("Location: Index.php");// head back to login page
exit();
?>