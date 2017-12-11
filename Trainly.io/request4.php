<!--For a particular topic/category, output the number of students enrolled in courses belonging to that topic, as well as return the count of courses belonging to that topic. 
 The user input is the topic name that the user wants to get information about.-->
<html>
<head>
    <title>request4</title>
</head>
<body>
    <body background="background_full.jpg">
        <form method="post" action="">
            Enter topic name:
            
            <br><br>        
            
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

            $topic = "SELECT `TopicNames` as `Names` from `topics`";
            $result = $conn -> query($topic);
            // To display the result
            while($row = $result->fetch_array())
            {
                $rows[] = $row;
            }
            
            echo '<select name = "tname">';
            echo '<option>--Select Course--</option>';
            foreach ($rows as $row) {
                echo '<option value ="'.$row['Names'].'">'.$row['Names'].'</option>';

            }
            echo '</select>';
            ?>       
            
            <input name= "regis" type="submit" value ="Submit"></form><br><br>
            
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
                        header('location: Facultypage.php');// Head to homepage
                    }
                    
          if(isset($_POST['regis'])){ //check if form was submitted
            include 'request4action.php';//get output text
        }
        ?>

    </body>
    </html>
