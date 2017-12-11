<!--To help faculties look for the questions relating to the course they have created. 
The faculty should input his email id and the course id he’s looking for. If the faculty is not one of the course’s creators, there will not be any output. The output includes the first name of the student who asked that question, the question itself, and the number of students who liked it -->
<html>
<head>
    <title>request5</title>
</head>
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

            $sql = "SELECT `CourseInfo`.`Name` as `Course`
            FROM (`CourseInfo` INNER JOIN `Course-creation` ON `CourseInfo`.`CourseId`=`Course-creation`.`CourseId`)
            INNER JOIN `UserInfo` ON `UserInfo`.`Userid`=`Course-creation`.`CreatorId`
            WHERE `UserInfo`.`Email`=?";
            // prepared statement
            $stmt=$conn->prepare($sql);
            $stmt->bind_param('s', $useremail2);
            $stmt->execute();
            
            $result=$stmt->get_result();
            $i=0;
            // To display the request
            while($row = $result->fetch_array()){   
                $rows[] = $row;
            }
            
            echo 'Select the course: ';
            echo '<select name = "cname">';
            echo '<option>--Select Course--</option>';
            foreach($rows as $row){
                
                echo '<option value="'.$row['Course'].'">'. $row['Course'] .'</option>';
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
                        header('location: Facultypage.php');// Head to the homepage
                    }
                    
                    $useremail = "'".$_SESSION['userEmail']."'";
           if(isset($_POST['regis'])){ //check if form was submitted
            include 'request5action.php';//get output text
        }
        ?>

    </body>
    </html>