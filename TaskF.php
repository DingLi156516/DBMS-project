<!-- - In this task we need to update the material-confirmation table which is parameterized by the student email, course name and material name.-->

<html>

<body background="background_full.jpg">

	<form method="post" action="TaskFnext.php">
		Enter Course Name:
		<?php
		if(!isset($_SESSION)) { 
			session_start(); 
		}
		$useremail = $_SESSION['userEmail']; 
        //$useremail2 = $_SESSION['userEmail'];
        //$useremail3 = $_POST['userEmail'];
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
		// Course name drop down
		$courname = " SELECT (`courseinfo`.`Name`) as Name from `courseinfo` where `courseinfo`.`CourseId` in (SELECT `course-students`.`CourseId` from `course-students` WHERE `course-students`.`StudentId` = (SELECT `userid` from `userinfo` where 
		`email` = '$useremail'))";
		$result = $conn -> query($courname);

		while($row = $result->fetch_array())
		{
			$rows[] = $row;
		}

		echo '<select name = "cname">';

		foreach ($rows as $row) {
			echo '<option value="'.$row['Name'].'">'.$row['Name'].'</option>';

		}
		echo '</select>';

		if(!isset($_SESSION)){
			session_start();
                        
			$useremail=$_SESSION['userEmail'];
			}

			?>

                <input name= "next" type="submit" value ="Next"></form>
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
						header("Location: Studentpage.php"); // Homepage
					}
					?>

				</form>
			</body>
			</html>
