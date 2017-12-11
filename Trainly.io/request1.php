<!--  Output courses which have more than # secondary topics.
 The information result should be sorted by the number # of secondary topics courses have, descending, then by the creators’ name #(alphabetically), then by the courses’ name (alphabetically)
Done by the admin-->
<html>
<head>
    <title>request1</title>
</head>
<body>
    <body background="background_full.jpg">
        <form method="post" action="request1action.php">
            Enter number of topics to consider:
            <input name= 'num' type='text'> 
            <br><br>        
            
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
                        header('location: Adminpage.php');
                    }
                    ?>
                </body>
                </html>