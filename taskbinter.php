  <!-- Intermediate file to redirect user to Faculty authentication or Admin authentication depending on the selection -->
   <?php 
   $user_type = $_POST['user_type'];
   if ($user_type == 'Faculty') {
    header("Location: taskbb1.php"); // If the admin selects Faculty as the type of user to be authenticated
}
elseif ($user_type == 'Administrator') {
    header("Location: taskbad.php");// If the admin selects Administrator as the type of user to be authenticated
}


if(!isset($_SESSION)){
    session_start();
    $useremail=$_SESSION['userEmail'];
    $useremail2= "'".$_SESSION['userEmail']."'";}
    ?>

    <form method="post" action="logout.php">
        <input name= "logout" type="submit" value ="Logout"></form><br><br>
        <form method="post" action="">
            <input name= "back" type="submit" value ="Homepage"></fo
            <?php  
            if(isset($_POST['back'])) 
            { 
                header("Location: Adminpage.php");// To head back to the Homepage
            } 
            ?>