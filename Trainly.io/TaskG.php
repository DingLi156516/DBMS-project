<!-- In this task we have a certificationlink for each student, and the user input here are the coursename and the user email, when a user enter these, it will list the student name, course name,completion date nad time, and a link for his certificate.-->

<html>

<body background="background_full.jpg">
 
    <form method="post" action="TaskGprocess.php">
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
        // Student drop down
        $stuemail = " SELECT email from userinfo where AsFaculty = 'No' and AsAdmin = 'No'";
        $result = $conn -> query($stuemail);

        while($row = $result->fetch_array())
        {
            $rows[] = $row;
        }
        
        echo '<select name = "sname">';

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
                        header("Location: Adminpage.php");// Homepage
                    }
                    ?>
                    
                </form>
            </body>
            </html>
