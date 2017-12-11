<!-- In task D if we want a student to enroll in a course we just need to update the course-students table which has the course information for students and the user inputs here are the email address and course name. And the $confcode is a variable which represent a function in PHP that is used to generate random confirmation code.-->
<html>

<body background="background_full.jpg">
 
    <form method="post" action="TaskDnext.php">
        Enter Student Email:
        <?php
        if(!isset($_SESSION)) { 
            session_start(); 
        }
        $useremail = "'".$_SESSION['userEmail']."'"; 
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
        
        $stuemail = " SELECT email from userinfo where AsFaculty = 'No' and AsAdmin = 'No'";
        $result = $conn -> query($stuemail);

        while($row = $result->fetch_array())
        {
            $rows[] = $row;
        }
        
        echo '<select name = "sname">';
        // Display data
        foreach ($rows as $row) {
            echo '<option value ='.$row['email'].'>'.$row['email'].'</option>';

        }
        echo '</select>';

        if(!isset($_SESSION)){
            session_start();
            $useremail=$_SESSION['userEmail'];
            $useremail2= "'".$_SESSION['userEmail']."'";}
            
            ?>

            <input name= "emailsub" type="submit" value ="Next">
            
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
                        header("Location: Adminpage.php");// Head to homepage
                    }
                    ?>
                    
                </form>
            </body>
            </html>
