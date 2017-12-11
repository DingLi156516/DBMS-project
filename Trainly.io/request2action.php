<!-- To process the data from request2.php-->
<html>
<head>
  <style type="text/css">
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

<body>
  <body background="background_full.jpg">
    <table id="table">


      <?php
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

      $sql1 = "SELECT c.`Name` AS `Course Name`,COUNT(u.`Userid`) AS `StudentNumber`,AVG(cs.`UserRating`) AS `StudentRating`
      FROM (`CourseInfo` c  INNER JOIN `Course-Students` cs ON cs.`CourseId` = c.`CourseId`) INNER JOIN `UserInfo`u ON u.`Userid` = cs.`StudentId`
      WHERE c.`Name` IN
      (
      SELECT c.`Name`
      FROM (((`CourseInfo` c NATURAL JOIN `Course-Creation` cc) INNER JOIN `Faculty` f ON cc.`CreatorId`=f.`FacultyId`) INNER JOIN `UserInfo` u ON u.`Userid`=f.`FacultyId`)
      GROUP BY c.`Name`
      HAVING COUNT(*) > 1
      ORDER BY c.`Name`

    ) 
    GROUP BY c.`Name`
    HAVING COUNT(u.`Userid`)>?
    ORDER BY `StudentNumber` DESC, AVG(cs.`UserRating`) DESC;";

    // prepared statements
    $stmt = $conn->prepare($sql1);

    $stmt->bind_param("s",$_POST['num']);
    $stmt->execute();
    $result1 = $stmt->get_result();
    // Display the result
    if ($result1->num_rows > 0) {
      ?>
      <tr>
        <th><?php echo "Course Name";?></th>
        <th><?php echo "StudentNumber";?></th>
        <th><?php echo "StudentRating";?></th>
      </tr>
      <?php
      while($row1 = $result1->fetch_assoc()) {
        ?><tr class="alt">
          <td><?php echo $row1["Course Name"] ?></td>
          <td><?php echo $row1["StudentNumber"] ?></td>
          <td><?php 
          if(is_null($row1["StudentRating"]))
          {
           ?><?php echo "Coming Soon"; ?>
           <?php
         } 
         else 
         {
          echo $row1["StudentRating"]; 
        }?></td>
        </tr> <?php
      }
    }else {
      ?>
      <tr class="alt">
        <td><?php  echo "Sorry, we can't find any results";?></td>
        </tr><?php
      }
      $conn->close();
      ?>
      
      <form method="post" action= "request2.php">
        <input name= "back" type="submit" value ="Back"></form><br><br>
        
        <form method="post" action="">
          <input name= "home" type="submit" value ="Homepage"></form><br><br>
          
          <?php 
          if(!isset($_SESSION)) 
          { 
            session_start(); 
          } 
          $useremail = $_SESSION['userEmail'];
          if(isset($_POST['home'])) {
            header('location: Adminpage.php');// Go back to the homepage
          }
          ?>

        </table>
      </body>