<!-- Provide a categorized list of a student's courses (each with primary/secondary topics, ranked by average evaluation score): currently enrolled, completed, of interest -->
<html>

<body background="background_full.jpg">
 
    <form method="post" action="">
        Select user email:
        <?php
        if(!isset($_SESSION)) { 
            session_start(); 
        }
        $useremail = "'".$_SESSION['userEmail']."'"; 
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "GROUP3project";

// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }   
        $stuemail = "SELECT `email` from `userinfo` where AsFaculty = 'No' and AsAdmin = 'No'";
        $result = $conn -> query($stuemail);
        // Student list
        while($row = $result->fetch_array())
        {
            $rows[] = $row;
        }
        
        echo '<select name = "sname">';
        echo '<option>--Select user--</option>';
        foreach ($rows as $row) {
            echo '<option value ="'.$row['email'].'">'.$row['email'].'</option>';

        }
    echo '</select>';  ?>   
    
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
                header('location: Adminpage.php');// Head back to the homepage
            }
            ?>
            
            <?php    
            if(isset($_POST['regis'])){ //check if form was submitted
                
            include 'TaskCactionadmin.php';//get output text
        }    
        ?>
    </body>
    </html>