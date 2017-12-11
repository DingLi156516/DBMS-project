<!-- To process the data from taskbb1.php-->
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
if(!isset($_SESSION)){
  session_start();
  $useremail=$_SESSION['userEmail'];
  $useremail2= "'".$_SESSION['userEmail']."'";}

  $uname = $_POST['facemail'];
  // Authentication query
  $stmt1 = $conn->query("UPDATE `Faculty` SET `AuthenticatorId`=(SELECT Userid FROM UserInfo WHERE email = $useremail2) ,`AuthenticationDateTime`=NOW() 
    WHERE `FacultyId` = (Select Userid from Userinfo where email = '$uname') 
    AND `Title` IS NOT NULL AND `WorkWebsite` IS NOT NULL AND `Affiliation` IS NOT NULL");
  $stmt2 = $conn->query ("UPDATE `UserInfo` SET `FacultyApproved`=1 
    WHERE `Email` = '$uname'");

  if (($stmt1===True & $stmt2===True)) {
    echo "success ";
} else {
    echo "Please try again";
}
?>

<form method="post" action="logout.php">
    <body background="background_full.jpg">
        <input name= "logout" type="submit" value ="Logout"></form><br><br>
        <form method="post" action="">
            <input name= "back" type="submit" value ="Homepage"></fo
            <?php  
            if(isset($_POST['back'])) 
            { 
                header("Location: Adminpage.php");// Head to the homepage
            } 
            ?>
