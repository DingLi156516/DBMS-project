<!-- STUDENT HOMEPAGE-->
<?php include 'PagePrepare.php' ?>
<html>
<body id='Studentpage' background="background_full.jpg">

    <header>
        <span>
        STUDENT HOME PAGE</span>
    </header>
    Welcome, <?php
    if (!isset($_SESSION)) {
        session_start();
    } echo $_SESSION["FirstName"] . " " . $_SESSION["LastName"];
    ?>
    

    <a id="scrollLink" href="#here"></a>
    <!-- Tasks performed by a student-->
    <form method="post" action="">
        Query1: Categorized list of courses: currently enrolled, completed, of interest
        <input name= "query1" type="submit" value ="Go"  ></form><br><br>

        <form method="post" action="TaskE.php">
            Query2: List of Completed/Incomplete course materials for enrolled courses
            <input name= "query2" type="submit" value ="Go"></form><br><br>

            <form method="post" action="TaskF.php">
                Query3: Mark course materials as complete
                <input name= "query3" type="submit" value ="Go"></form><br><br>

                <form method="post" action="">
                    Query4: Show account history
                    <input name= "query4" type="submit" value ="Go"></form><br><br>

                    <form method="post" action="">
                        Query5: Enrolled Courses with multiple links
                        <input name= "query8" type="submit" value ="Go"><div style="clear:both"></div></form>

                        <form method="post" action="logout.php">
                            <input name= "logout" style="float:none;"type="submit" value ="Logout">
                        </form><br><br>
                        
                        <div id='here'></div>
                        <?php
                        if (isset($_POST['logout'])) {
                            session_abort();
                            header("Location: Index.php");
                        }
                        ?>
                        <?php
                        $useremail = "'" . $_SESSION['userEmail'] . "'";

            if (isset($_POST['query1'])) { //check if form was submitted
                $useremail2 = $_SESSION['userEmail'];
                include 'TaskCactionstudent.php'; //get output text
            }

            if (isset($_POST['query4'])) { //check if form was submitted
                $useremail2 = $_SESSION['userEmail'];
                include 'TaskHprocessstudent.php'; //get output text
            }

            if (isset($_POST['query8'])) { //check if form was submitted
                $useremail2 = $_SESSION['userEmail'];
                include 'request3action.php'; //get output text
            }
            ?>


        </body>
        </html>

