<!-- In task H we need to populate 2 tables, one table shows the date of enrollment and completion, amount paid, one shows the total spent for each course, and the user input here is user email, when you enter an email address, this table will show up. - Done by admin-->

<html>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
<style>

form{
    padding: 10px;
}

</style>
<body>
    <body background="background_full.jpg">
        <form method="post" action="">
           Enter User Email:

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
        // Drop down student emails
        $stuemail = "SELECT `email` from `userinfo` where AsFaculty = 'No' and AsAdmin = 'No'";
        $result = $conn -> query($stuemail);

        while($row = $result->fetch_array())
        {
            $rows[] = $row;
        }
        
        echo '<select name = "sname">';

        foreach ($rows as $row) {
            echo '<option value ="'.$row['email'].'">'.$row['email'].'</option>';

        }
        echo '</select>';
        ?>
        
        <input name= "regis" type="submit" value ="Submit"></form>
        
        <form method="post" action="logout.php">
            <input name= "logout" type="submit" value ="Logout"></form><br><br>
            
            <form method="post" action="">
                <input name= "Homepage" type="submit" value ="Homepage"></form><br><br>
                <?php 

                if(isset($_POST['Homepage'])) {
                    header("Location: Adminpage.php");// Homepage
                }
                
                
            if(isset($_POST['regis'])){ //check if form was submitted           
            include 'TaskHprocessadmin.php';//get output text
        }    
        ?>

    </body>
    </html>



    
    
