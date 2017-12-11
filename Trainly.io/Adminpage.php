<!-- Admin homepage-->
<?php include 'PagePrepare.php' ?>
<html>


<body id='adminPage' background="background_full.jpg">
    <h5>Welcome, <?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    }  echo $_SESSION["FirstName"]. " ".$_SESSION["LastName"] ;?></h5>
    
    <header>
        <span>
        ADMINISTRATOR HOME PAGE</span>
    </header>
    <a id="scrollLink" href="#here"></a>
    <!-- Tasks performed by an admin-->
    <form method="post" action="TaskB.php">
        Authenticate a user
        <input name= "query1" type="submit" value ="Go"></form>
        
        <form method="post" action="TaskH.php">
            Show a user account history
            <input name= "query2" type="submit" value ="Go"></form>
            
            <form method="post" action="TaskCadmin.php">
                Provide a categorized list of a student's courses (each with primary/secondary topics, ranked by
                average evaluation score): currently enrolled, completed, of interest
                <input name= "query3" type="submit" value ="Go"></form>
                
                <form method="post" action="TaskD.php">
                    Enroll a student in a course
                    <input name= "query4" type="submit" value ="Go"></form>
                    
                    <form method="post" action="TaskG.php">
                        Provide certificate of completion
                        <input name= "query5" type="submit" value ="Go"></form>
                        
                        <form method="post" action="request1.php">
                            Output courses with multiple secondary topics
                            <input name= "query6" type="submit" value ="Go"></form>
                            
                            <form method="post" action="request2.php">
                                Courses with multiple students and more than 1 faculty creator
                                <input name= "query7" type="submit" value ="Go"><div style="clear: both;"></div></form>
                                
                                <form method="post" action="logout.php">
                                    <input style="float:none;" name= "logout" type="submit" value ="Logout"></form><br><br>
                                    
                                    <?php 
                                    if(!isset($_SESSION)){
                                        session_start();
                                        // Sending email as session variable
                                        $useremail=$_SESSION['userEmail'];
                                        $useremail2= "'".$_SESSION['userEmail']."'";
                                    } 
                                    
                                    
                                    if(isset($_POST['logout'])) {
                                        session_abort();
                                        header("Location: Index.php");
                                    }

        
                                    ?>
                                    
                                </body>
                                </html>
