<!-- To process data from TaskDnext.php and display result -->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "group3project";
if(!isset($_SESSION)){
    session_start();
    $useremail=$_SESSION['userEmail'];
    $useremail2= "'".$_SESSION['userEmail']."'";
}

$email = $_SESSION['sname'];
$cname = $_POST['cname'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
// Random confirmation code
$confcode = substr(md5(mt_rand()), 0, 7);

// Query for enrollment
$stmt = "INSERT INTO `Course-Students` (`CourseId`,`StudentId`,`PaymentDateTime`,`AmountPaid`,`ConfirmationCode`,`CompletionDateTime`,`UserComment`,`UserRating`,`CertificateLink`) VALUES ((Select `CourseId` from `CourseInfo` where `Name` = '$cname'),(Select Userid from Userinfo where email = '$email'),NOW(),(Select `Cost` from `CourseInfo` where `Name` = '$cname'),'$confcode',null,null,null,null);";
$stmt1 = $conn -> query($stmt);

if ($stmt1== true) {
    echo "New record created successfully";
    header("Refresh: 1, url = adminpage.php");
} else {
    echo "Error";
    header("Refresh: 1, url = taskd.php");
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
    <body background="background_full.jpg">
    </body>
    </html>