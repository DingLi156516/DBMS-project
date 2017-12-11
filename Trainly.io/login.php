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
$sqlsalt= "SELECT Salt from UserPasswords WHERE Userid = (Select Userid FROM UserInfo WHERE Email= ?) ";
$resultsalt = $conn->prepare($sqlsalt);
$resultsalt->bind_param('s',$email_enter);
$resultsalt->execute();
$result=$resultsalt->get_result();
$saltarray=$result->fetch_assoc();
$saltvalue = $saltarray['Salt'];

$newpass = $saltarray['Salt'].$pass_enter;


if($result -> num_rows > 0) {   
    $pass_hash= hash('SHA256', $newpass);

    $uid = "SELECT Userid from userinfo where email= ? ";
    $resultsalt1 = $conn->prepare($uid);
    $resultsalt1->bind_param('s',$email_enter);
    $resultsalt1->execute();
    $result=$resultsalt1->get_result();
    $userarray=$result->fetch_assoc();
    $useridval = $userarray['Userid'];
    $sqlpass = "SELECT Password FROM userpasswords where Userid = ? ";
    $resultsalt2 = $conn->prepare($sqlpass);
    $resultsalt2->bind_param('s',$useridval);
    $resultsalt2->execute();
    $result=$resultsalt2->get_result();
    $passarray=$result->fetch_assoc();
    $userpass = $passarray['Password'];

    // Comparing password entered by the user with the password in database
    if (strtolower($userpass) == strtolower($pass_hash)){
        
        $sqlall= " Select * from UserInfo WHERE Email=?";
        $user = $conn->prepare($sqlall);
        $user->bind_param('s',$email_enter);
        $user->execute();
     
        $resultallusers=$user->get_result();

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