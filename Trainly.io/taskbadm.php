<!--  To process the data from taskbad.php -->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "group3project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}     
$uname = $_POST['amail'];

if(!isset($_SESSION)){
    session_start();
    $useremail=$_SESSION['userEmail'];
    $useremail2= "'".$_SESSION['userEmail']."'";}
    // Authentication query
    $stmt1 = $conn->query("UPDATE `Administrator` SET `GrantorId`=(SELECT Userid FROM UserInfo WHERE email= '$useremail') ,`ApprovalDateTime`=NOW() 
      WHERE `AdminId` = (Select Userid from Userinfo where email = '$uname')");
    $stmt2 = $conn->query ("UPDATE `UserInfo` SET `AdminApproved`=1 
      WHERE `Email` = '$uname'");

    if (($stmt1 == true & $stmt2 == true)) {
        echo "success ";
    } else {
        echo "Please try again";
    }
    ?>

    <form method="post" action="logout.php">
        <input name= "logout" type="submit" value ="Logout"></form><br><br>
        <form method="post" action="">
            <input name= "back" type="submit" value ="Homepage"></form>
            
            <?php  
            if(isset($_POST['back'])) 
            { 
                header("Location: Adminpage.php");
            } 
            ?>