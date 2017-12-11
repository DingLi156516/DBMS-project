<!--  To process data from TaskFnext.php and students selects the material completed -->
<html>

<body background="background_full.jpg">

	<form method="post" action="TaskFaction.php">
		Enter Material Name:
		<?php
		session_start();
		$useremail = $_SESSION['userEmail']; 
     
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "group3project";
                $cname=$_POST['cname'];

// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 

            
            $_SESSION["cname"] = $cname;
            	// Material drop down
		$sql = "SELECT cm.`Name`as `Material` FROM `Course-Material` cm 
                INNER JOIN `Material-Confirmation` m ON m.Materialid=cm.Materialid
                WHERE m.CompletionDateTime IS NULL AND cm.CourseId = (SELECT CourseId FROM CourseInfo WHERE Name='$cname') 
                AND m.StudentId=(SELECT UserId FROM UserInfo WHERE Email='$useremail') ";
		$result = $conn -> query($sql);

		while($row = $result->fetch_array())
		{
			$rows[] = $row;
		}

		echo '<select name = "mname">';
                echo '<option value="none">--Select a material--</option>';

		foreach ($rows as $row) {
			echo '<option value="'.$row['Material'].'">'.$row['Material'].'</option>';

		}
		echo '</select>';

		

			?>

                <input name= "regis" type="submit" value ="Submit"></form>
			<br>
			<br>
                        <form method="post" action="TaskF.php">
				<input name= "Back" type="submit" value ="Back"></form><br><br>
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
						header("Location: Studentpage.php");
					}
//                                        if(isset($_POST['regis'])) { 
//                                            include "TaskFaction.php";
//					}
					?>

				</form>
			</body>
			</html>


            


