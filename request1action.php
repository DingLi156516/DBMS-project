<!-- To process the data from request1.php -->
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
  <table id="table">
    <body background="background_full.jpg">
      <?php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "Group3project";
      $SecondaryTopics= $_POST['num'];

// Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      } 

      $sql = "SELECT DISTINCT(`CourseName`) FROM
      (
      SELECT `Faculty`.`FacultyId` as `CreatorId`, `CourseInfo`.`Name` as `CourseName`,count(`SecondaryTopics`.`TopicName`) as `Counts`
      FROM ((`CourseInfo` inner join `SecondaryTopics` on `CourseInfo`.`CourseId`=`SecondaryTopics`.`CourseId`) 
      INNER JOIN `Course-Creation` on `Course-Creation`.`CourseId`=`CourseInfo`.`CourseId` )
      INNER JOIN `Faculty` on `Faculty`.`FacultyId`=`Course-Creation`.`CreatorId` 
      GROUP BY `CourseInfo`.`CourseId`, `Faculty`.`FacultyId`
      HAVING Counts >=?)as t
      ORDER BY t.`Counts` DESC, `CreatorId`, `CourseName`";

      $stmt = $conn->prepare($sql);

      $stmt->bind_param("s",$SecondaryTopics);
      $stmt->execute();
      $result1 = $stmt->get_result();
      // To display to result
      if ($result1->num_rows > 0) { ?>
      <tr>
        <th><?php echo "The courses which have more than $SecondaryTopics secondary topics";?></th>
      </tr>
      <?php 
      while($row1 = $result1->fetch_assoc()) {
       ?><tr class="alt">
        <td><?php echo $row1["CourseName"] ?></td>
        </tr> <?php
        
      }
    }else {
      ?>
      <tr class="alt">
        <td><?php echo "Sorry, we can't find any results";?></td>
        </tr><?php
      }
      $conn->close();
      ?>
      
      <?php 
      if(!isset($_SESSION)) 
      { 
        session_start(); 
      } 
      if(isset($_POST['back'])) {
        header('location: Adminpage.php');// To go to the homepage
      }
      ?>
      <form method="post" action="request1.php">
        <input name= "logout" type="submit" value ="Back"></form><br><br>
        
        <form method="post" action="logout.php">
          <input name= "logout" type="submit" value ="Logout"></form><br><br>
          
          <form method="post" action="">
            <input name= "back" type="submit" value ="Homepage"></form><br><br>


          </table>
        </body>
        </html>
