<!--  To process the data from TaskGaction.php and display the result-->
<html><head><style type="text/css">
#table
{
  font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
  width:100%;
  border-collapse:collapse;
}

#table td, #table th 
{
  font-size:1em;
  border:1px solid #98bf21;
  padding:3px 7px 2px 7px;
}

#table th 
{
  font-size:1.1em;
  text-align:left;
  padding-top:5px;
  padding-bottom:4px;
  background-color:#A7C942;
  color:#ffffff;
}

#table tr.alt td 
{
  color:#000000;
  background-color:#EAF2D3;
}
</style>
</head>
<body background="background_full.jpg">
  <?php

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "group3project";
  session_start();
  $email = $_SESSION['sname'];
  $cname = $_POST['cname'];
// Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  } 
  
  // Query 1
  $sql1 = " UPDATE `Course-Students` SET CertificateLink = IF(CompletionDateTime IS NOT NULL,'Link to certificate/', 
  CertificateLink) WHERE StudentId = (SELECT Userid FROM UserInfo WHERE Email=(?)) AND 
  CourseId= (SELECT Courseid FROM CourseInfo WHERE Name=(?))";
  // Query 2
  $sql2 = "  SELECT u.`FirstName` as `First Name`, u.`LastName` as `Last Name`, ci.`Name` AS `Course Name`, c.`CompletionDateTime` as `Completion Details`, c.`CertificateLink` as `Link to Certificate`
  FROM (`Course-Students` c INNER JOIN `UserInfo` u ON u.`Userid`=c.`StudentId`)
  INNER JOIN `CourseInfo` ci ON ci.`CourseId`=c.`CourseId`
  WHERE c.`StudentId`=(Select Userid from Userinfo where email = (?))
  AND ci.`Name`=(?) AND c.`CompletionDateTime` IS NOT NULL";


  // prepared statements
  $stmt1 = $conn->prepare($sql1); 
  $stmt1->bind_param("ss",$email ,$cname);
  $stmt1->execute();
  $stmt2 = $conn->prepare($sql2);                
  $stmt2->bind_param("ss",$email ,$cname);                   
  $stmt2->execute();
  
  $result2=$stmt2->get_result();

  if ($result2->num_rows > 0) {
    // output data of each row
    ?>
    <table id="table">
      <tr>
        <th><?php echo "Student Name";?></th>
        <th><?php echo "Course Name"?></th>
        <th><?php echo "Completion Details"?></th>
        <th><?php echo "Link to Certificate"?></th>
      </tr>
      <?php
      while($row1 = $result2->fetch_assoc()) {
        ?><tr class="alt">
        </td>
        <td><?php echo $row1["First Name"] ?><?php echo " ".$row1["Last Name"]?></td>
        <td><?php echo $row1["Course Name"]?></td>
        <td><?php echo $row1["Completion Details"]?></td>
        <td><?php echo $row1["Link to Certificate"].$cname ?></td>
        </tr> <?php
      }
      
    }
    else {
     ?><tr class="alt"> 
     </td>
     <td><?php echo "Student hasn't completed the course";?>
      <?php
    }
    

    ?>

    <form method="post" action="logout.php">
      <input name= "logout" type="submit" value ="Logout"></form><br><br>
      
      <form method="post" action="">
        <input name= "back" type="submit" value ="Homepage"></form><br><br>
        <?php 
        
        if(isset($_POST['back'])) { 
          header("Location: Adminpage.php");
        }
        ?>
      </body></html>