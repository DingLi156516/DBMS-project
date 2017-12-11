 <!-- Authentication of a faculty/admin means update the table for the faculty/admin and userinfo, so we need to update both table,make the faculty approved-->
 <html>
 <body background="background_full.jpg">
    
    <form method="post" action="taskbinter.php">
        Select user type to authenticate:    <?php 
        $utype = array('Faculty', 'Administrator');
        // Admin selects the type of user to be authenticated
        echo '<select name = "user_type">';
        for ($i = 0; $i <count($utype); $i++)
        {
            echo '<option>'. $utype[$i] .'</option>';
        }
        echo '</select>';

        if(!isset($_SESSION)){
            session_start();
            $useremail=$_SESSION['userEmail'];
            $useremail2= "'".$_SESSION['userEmail']."'";
        } 
        ?>

        
        <input name= "typeinput" type="submit" value ="Next"></form><br><br>


        <form method="post" action="logout.php">
            <input name= "logout" type="submit" value ="Logout"></form><br><br>
            <form method="post" action="">
                <input name= "back" type="submit" value ="Homepage"></fo
                <?php  
                if(isset($_POST['back'])) 
                { 
                    header("Location: Adminpage.php");// To go back to the homepage
                } 
                ?>

                <br><br>
            </body>
            
            </html>

            

