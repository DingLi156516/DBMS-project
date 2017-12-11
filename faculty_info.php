
<!-- Part of user registration as faculty-->
<html>
<head> <script>
	function myFunction()
	{
		alert("Successful"); // Pop up after submit
	}
</script>
<body>
	<body background="background_full.jpg">
		<b><center>  
			<form method="post" action="faculty_info.php">

				You have been registered as a faculty. Please enter these details for authentication:-
				<br><br>
				Your email :<?php 
				session_start();
				echo $_SESSION["email"]; ?>
				<br> <br>
				Title <input name="title" type="text">
				<br><br>
				Work Website<input name="workweb" type="text">
				<br><br>
				Affiliation <input name="affi" type="text">
				<br><br>

				<input name= "submit" type="submit" value ="Submit" onclick="myFunction()">
			</form>


			<?php

			if (isset($_POST['submit'])){
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

				
				$title = $_POST['title'];
				$work = $_POST['workweb'];
				$affi = $_POST['affi'];
				$email = $_SESSION["email"];
				$null = null;
				// Prepared statements
				$idem = "SELECT Userid from userinfo where email= (?)";
				$stmt1 = $conn -> prepare($idem);
				$stmt1 -> bind_param("s",$email);
				$stmt1 -> execute();

				$result2 = $stmt1-> get_result(); 
				$row = mysqli_fetch_array($result2);
				$uid = $row['Userid'];
				
				
				$finfo = " INSERT INTO faculty(FacultyId,Title,WorkWebsite, Affiliation, AuthenticatorId, AuthenticationDateTime) 
				VALUES ( (?), (?), (?), (?),(?),(?))" ;
				$stmt2 = $conn -> prepare($finfo);
				$stmt2 -> bind_param("ssssss",$uid, $title, $work, $affi, $null, $null);
				$stmt2 -> execute();
       
				echo "done";
				header("Refresh: 0.001,url=Index.php");// Go back to the login page 
			}
			?>
		</b></center>
	</body>
	</html>