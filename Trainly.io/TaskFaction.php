<!-- To process TaskFnext.php and display result -->
<html><body background="background_full.jpg"></body></html>
    
    <?php
    
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "group3project";
session_start();
$useremail=$_SESSION['userEmail'];
$cname = $_SESSION['cname'];
$mname=$_POST['mname'];



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Material completion and possible course completion queries
$sql1= "SELECT `Material-Confirmation`.`Materialid`, `Material-Confirmation`.`CompletionDateTime`
FROM ((`Material-Confirmation` INNER JOIN `UserInfo` ON `UserInfo`.`Userid`=`Material-Confirmation`.`StudentId`)
INNER JOIN `Course-Material` ON `Course-Material`.`Materialid`=`Material-Confirmation`.`Materialid`)
INNER JOIN `CourseInfo` ON `CourseInfo`.`CourseId`=`Course-Material`.`CourseId`
WHERE `UserInfo`.`Email`=? AND `Course-Material`.`Name`=? AND `CourseInfo`.`Name`=?";

$sql2 = "UPDATE `Material-Confirmation` SET `CompletionDateTime`=NOW() WHERE `Materialid`=(SELECT Materialid FROM `Course-Material` WHERE name= ? AND CourseId = (SELECT CourseId FROM CourseInfo WHERE Name= ?)) AND `StudentId` = (Select Userid from Userinfo where email = ?)";
$sql3="SELECT `Material-Confirmation`.`Materialid`, `Material-Confirmation`.`CompletionDateTime`
FROM ((`Material-Confirmation` INNER JOIN `UserInfo` ON `UserInfo`.`Userid`=`Material-Confirmation`.`StudentId`)
INNER JOIN `Course-Material` ON `Course-Material`.`Materialid`=`Material-Confirmation`.`Materialid`)
INNER JOIN `CourseInfo` ON `CourseInfo`.`CourseId`=`Course-Material`.`CourseId`
WHERE `UserInfo`.`Email`=? AND `CourseInfo`.`Name`=?";
$sql4="UPDATE `Course-Students` SET `CompletionDateTime`=NOW() WHERE `CourseId`=
(
SELECT `CourseInfo`.`CourseId` FROM `CourseInfo` WHERE `CourseInfo`.`Name`=?
) 
and 
`StudentId` =
(
SELECT `UserInfo`.`Userid` FROM `UserInfo` WHERE `UserInfo`.`Email`=?
)";
// prepared statments
$stmt1=$conn->prepare($sql1);
$stmt1->bind_param("sss", $useremail,$mname,$cname);
$stmt1->execute();
$result1 = $stmt1->get_result();

if($result1->num_rows > 0)
{
$row1 = $result1->fetch_assoc();
	if(!is_null($row1["CompletionDateTime"]))
	{
		echo "This material has already completed, please try again";
	}
	else
	{
		// prepared statements
	$stmt2=$conn->prepare($sql2);
	$stmt2->bind_param("sss", $mname, $cname, $useremail);
	$stmt2->execute();
	$result2 = $stmt2->get_result();
	echo "Records updated successfully!";

	$stmt3=$conn->prepare($sql3);
	$stmt3->bind_param("ss",$useremail, $cname);
	$stmt3->execute();
	$result3 = $stmt3->get_result();
			if($result3->num_rows > 0)
			{
			$flag=1;
			$row3 = $result3->fetch_assoc();
				while($row3)
				{
					if(is_null($row3["CompletionDateTime"]))
					{
					$flag=0;
					}
				$row3 = $result3->fetch_assoc();
				}
			if($flag==1)
				{
		$stmt4=$conn->prepare($sql4);
		$stmt4->bind_param("ss",$cname,$useremail);
		$stmt4->execute();
		
		echo "The course ".$cname." has been completed, congrats!";
				}

			}

	}
}
else
{
	echo "Incorrect input, please try again.";
}

$conn->close();
?>
        
			<br>
			<br>
                        
			<form method="post" action="logout.php">
				<input name= "logout" type="submit" value ="Logout"></form><br><br>

				<form method="post" action="">
					<input name= "back" type="submit" value ="Homepage"></form><br><br>
					<?php 
					if(!isset($_SESSION)) 
					{ 
						session_start(); 
					}
					if(isset($_POST['back'])) { 
						header("Location: Studentpage.php");// homepage
					}