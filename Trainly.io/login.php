<!-- Process the information from the index page. Checks username and password against the database-->
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Group3project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


$email_enter =  $_POST['email_id'];
$pass_enter = $_POST['pass'];
// Taking salt from the database
$sqlsalt= "SELECT Salt from UserPasswords WHERE Userid = (Select Userid FROM UserInfo WHERE Email= '$email_enter') ";
$resultsalt = $conn->query($sqlsalt);
$saltarray = mysqli_fetch_array($resultsalt);
$saltvalue = $saltarray['Salt'];

$newpass = $saltarray['Salt'].$pass_enter;


if($resultsalt -> num_rows > 0) {   
    $pass_hash= hash('SHA256', $newpass);

    $uid = "SELECT Userid from userinfo where email= '$email_enter' ";
    $resultusers = $conn->query($uid); 
    $userarray = mysqli_fetch_array($resultusers);
    $useridval = $userarray['Userid'];
    $sqlpass = "SELECT Password FROM userpasswords where Userid = '$useridval' ";
    $resultpass = $conn->query($sqlpass);
    $passarray = mysqli_fetch_array($resultpass);
    $userpass = $passarray['Password'];

    // Comparing password entered by the user with the password in database
    if (strtolower($userpass) == strtolower($pass_hash)){
        
        $sqlall= " Select * from UserInfo WHERE Email='$email_enter'";
        
        $resultallusers = $conn->query($sqlall);

        $alluserarray = $resultallusers->fetch_assoc();
        
        session_start();
        $_SESSION["userEmail"] = $email_enter;
        $_SESSION["FacultyApproved"] = $alluserarray['FacultyApproved'];
        $_SESSION["AdminApproved"] = $alluserarray['AdminApproved'];
        $_SESSION["FirstName"] = $alluserarray['FirstName'];
        $_SESSION["LastName"] = $alluserarray['LastName'];
        
        if($alluserarray['FacultyApproved']==1)
        {
            
          header("Location: Facultypage.php");// For faculty homepage
      }
      else if($alluserarray['AdminApproved']==1){
       
        header("Location: Adminpage.php");// For Administrator homepage
    }
    else if($alluserarray['AdminApproved']==0 && $alluserarray['FacultyApproved']==0){
  
       header("Location: Studentpage.php");// For Student homepage
       
   }
}
// If the password is incorrect
else if(strtolower($userpass) != strtolower($pass_hash)) {
    ?>Wrong Password <a href="index.php">Please try again</a><?php

}
}
else{
    ?>
    Wrong Email <a href="index.php">Please try again</a><?php
}

$conn->close();
?>