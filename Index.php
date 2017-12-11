<!-- The login page -->
<?php include 'PagePrepare.php' ?>

<html>
<head>
    <header>

        <span>
        LOGIN PAGE</span>
    </header>

    Please Login to Continue<br><br>
    
</head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" type="text/css" rel="stylesheet" />

<body background="background_full.jpg">
    <style>
    body {
        margin: 10;
        text-align: center;
    }
    
</style>

<form method="post" action="login.php">
	

    Email ID: <input name="email_id" type="Email">
    <br><br>
    Password: <input name="pass" type="Password">
    <br><br>

    <input name="login" type="submit" value = "Login">

    <br><br>
    <!-- Sign up option for a new user -->
    New User? <a href="user_registration.php" style="color:honeydew;">Sign Up!</a></p>

</form>

</body>
</html>