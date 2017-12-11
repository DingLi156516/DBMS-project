<!-- FACULTY HOME PAGE -->
<?php include 'PagePrepare.php' ?>
<html>
<body id='Facultypage' background="background_full.jpg">
    
    <header>
        <span>
        FACULTY HOME PAGE</span>
    </header>
    
    Welcome, <?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    }  echo $_SESSION["FirstName"]. " ".$_SESSION["LastName"] ;?>
    <!-- Tasks performed by a faculty-->
    <form method="post" action="request4.php">
        Query1: Details by topic
        <input name= "query1" type="submit" value ="Go"></form><br><br>
        
        <form method="post" action="request5.php">
            Query2: Questions relating to the courses you created
            <input name= "query2" type="submit" value ="Go"><div style="clear:both"></div></form><br><br>
            
            
            <center>
                <form method="post" action="logout.php">
                    <input name= "logout" style="float:none;" type="submit" value ="Logout"></form><br><br>
                    
                    
                    <?php  
                    $useremail = "'".$_SESSION['userEmail']."'";
                    $useremail2 = $_SESSION['userEmail'];
                    ?>
                    
                    
                </body>
                </html>

