<!-- Output the Course Name, for which has more than a certain number of students and more than 1 #faculty creator, also output the average student rating for this course, and the #output is ordered first by the student number, then by the average student rating.-->
<html>
<head>
    <title>request2</title>
</head>
<body>
    <body background="background_full.jpg">
        <form method="post" action="request2action.php">
            Enter number of students to consider:
            <input name= 'num' type='text'> 
            <br><br>        
            
            <input name= "regis" type="submit" value ="Submit"></form><br><br>
            
            <form method="post" action="logout.php">
                <input name= "logout" type="submit" value ="Logout"></form><br><br>
                
                <form method="post" action="">
                    <input name= "home" type="submit" value ="Homepage"></form><br><br>
                    <?php 
                    if(!isset($_SESSION)) 
                    { 
                        session_start(); 
                    } 
                    if(isset($_POST['home'])) {
                        header('location: Adminpage.php');// Go back to the homepage
                    }
                    ?>
                </body>
                </html>