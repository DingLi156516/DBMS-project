<!--  To process the data from TaskG.php and then user chooses the desired course name -->

<html>
<body background="background_full.jpg">
    <form method="post" action="TaskGlast.php">

      <?php
      $email = $_POST['sname']; 
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "group3project";

      $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    session_start();
    $_SESSION["sname"] = $email;
    
    if(!isset($_SESSION)){
        session_start();
        $useremail=$_SESSION['userEmail'];
        $useremail2= "'".$_SESSION['userEmail']."'";}

        echo "Enter course name";
        
        // Course name selection dropdown
        $coursename = "SELECT `courseinfo`.`Name` from `courseinfo` where `courseinfo`.`CourseId` IN 
        (SELECT DISTINCT `Courseid` from `course-students` WHERE `CertificateLink` is not null and `StudentId`= (Select `Userid` from `userinfo` where `email` = '$email'))";
        
        $result1 = $conn -> query($coursename);
        
        
        while($row = $result1->fetch_array())
        {
            $rows[] = $row;

        }
        
        echo '<select name = "cname">';

        foreach ($rows as $row) {
            echo '<option>'.$row['Name'].'</option>';

        }
        echo '</select>';
        ?>

        <br><br>        
        
        <input name= "regis" type="submit" value ="Submit"></form>
        
        <form method="post" action="logout.php">
            <input name= "logout" type="submit" value ="Logout"></form><br><br>
            
            <form method="post" action="">
                <input name= "back" type="submit" value ="Homepage"></form><br><br>
                <?php 
                
                if(isset($_POST['back'])) { 
                    header("Location: Adminpage.php");// Homepage
                }
                ?>
                <?php    
            if(isset($_POST['regis'])){ //check if form was submitted
                $cname = $_POST['cname'];
            }    
            ?>
        </body>
        </html>