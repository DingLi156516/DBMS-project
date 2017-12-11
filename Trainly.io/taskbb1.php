<!-- Here admin selects the faculty to the authenticated -->
<html>
<body background="background_full.jpg">
    <form method="post" action="taskbfac.php">
        
       <?php 
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

    if(!isset($_SESSION)){
        session_start();
        $useremail=$_SESSION['userEmail'];
        $useremail2= "'".$_SESSION['userEmail']."'";}

        echo 'Enter Faculty email you want to authenticate: ';
        
        $sql = "Select DISTINCT(u.`Email`)as `Email` FROM UserInfo u WHERE AsFaculty ='Yes' AND FacultyApproved=0";
        $result=$conn->query($sql);
        
        while($row = $result->fetch_array()){   
            $rows[] = $row;
        }

        // Faculty dropdown
        echo '<select name = "facemail">';
        foreach($rows as $row){
            echo '<option>'. $row['Email'] .'</option>';
        }
        echo '</select>';
        ?>
        <input name= "submit" type="submit" value ="submit">
    </form>
    <form method="post" action="logout.php">
        <input name= "logout" type="submit" value ="Logout"></form><br><br>
        <form method="post" action="">
            <input name= "back" type="submit" value ="Homepage"></fo
            <?php  
            if(isset($_POST['back'])) 
            { 
                header("Location: Adminpage.php");
            } 
            ?>
        </body>
        </html>
