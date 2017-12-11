<!-- In task E we need to create a new table which shows each course material information and give the status of the course material as completed or not completed. The user input is email and the course name , when a user input the email and course name he enrolled, the information will show up.-->
<html>

<body>
 <body background="background_full.jpg">
    <form method="post" action="">

       
        <?php
        if(!isset($_SESSION)) { 
            session_start(); 
        }
        $useremail = "'".$_SESSION['userEmail']."'";
        $useremail2 = $_SESSION['userEmail'];
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
        // Course name drop down
        $sql = "Select DISTINCT(ci.`Name`)as `Course` FROM CourseInfo ci INNER JOIN `Course-Students` cs ON ci.CourseId=cs.CourseId WHERE cs.StudentId = (SELECT UserId FROM `UserInfo` WHERE Email=?) AND cs.CompletionDateTime IS NULL";
        $stmt=$conn->prepare($sql);
        $stmt->bind_param('s', $useremail2);
        $stmt->execute();
        
        $result=$stmt->get_result();
        
        while($row = $result->fetch_array()){   
            $rows[] = $row;
        }
        
        echo 'Select Course: ';
        echo '<select name = "cname">';
        foreach($rows as $row){
            echo '<option>'. $row['Course'] .'</option>';
        }
        echo '</select>';       
        
        ?>  
        
        <input name= "regis" type="submit" value ="Submit"></form>
        
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
                ?>
                
                <?php  
                $useremail = "'".$_SESSION['userEmail']."'";
            if(isset($_POST['regis'])){ //check if form was submitted
                $useremail2=$_SESSION['userEmail'];
                $cname = $_POST['cname'];
            include 'TaskEaction.php';//get output text
        }    
        ?>
    </body>
    </html>