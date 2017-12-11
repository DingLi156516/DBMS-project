<!-- To process the data from request5.php -->
<html>
<head>
  <style type="text/css">
  #studentsquestions
  {
    font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
    width:100%;
    border-collapse:collapse;
  }

  #studentsquestions td, #studentsquestions th 
  {
    font-size:1em;
    border:1px solid #98bf21;
    padding:3px 7px 2px 7px;
  }

  #studentsquestions th 
  {
    font-size:1.1em;
    text-align:left;
    padding-top:5px;
    padding-bottom:4px;
    background-color:#A7C942;
    color:#ffffff;
  }

  #studentsquestions tr.alt td 
  {
    color:#000000;
    background-color:#EAF2D3;
  }
</style>
</head>

<body>
  <body background="background_full.jpg">
    <table id="studentsquestions">


      <?php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "Group3project";
      $useremail2=$_SESSION['userEmail'];
      

      $courseid=$_POST['cname'];
// Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      } 
      $sql=  "SELECT `UserInfo`.`FirstName` as `Student`, `Questions`.`Question` AS `Question`, COUNT(`QuestionRating`.`LikedById`) AS `LikedBy`
      FROM (`UserInfo` INNER JOIN `Questions` ON `Questions`.`StudentId`=`UserInfo`.`Userid`)
      INNER JOIN `QuestionRating` ON `QuestionRating`.`QuestionLineId`=`Questions`.`QuestionLineId`
      WHERE `Questions`.`CourseId` IN 
      ( 
      select `CourseInfo`.`CourseId`
      FROM (`CourseInfo` INNER JOIN `Course-creation` ON `CourseInfo`.`CourseId`=`Course-creation`.`CourseId`)
      INNER JOIN `UserInfo` on `UserInfo`.`Userid`=`Course-creation`.`CreatorId`
      WHERE `CourseInfo`.`Name`=? and `Course-creation`.`CreatorId`= (SELECT UserId FROM UserInfo WHERE `Email`=?)
    )
    GROUP BY `Questions`.`QuestionLineId`
    ORDER BY `LikedBy` DESC, `Student`";

    // prepared statements
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $courseid, $useremail2);
    $stmt->execute();
    $result1 = $stmt->get_result();
    if ($result1->num_rows > 0) {
      ?>
      <tr>
        <th>Student</th>
        <th>Question</th>
        <th>LikedBy</th>
      </tr>
      <?php
      // To display the result
      while ($row1 = $result1->fetch_assoc()) {
        ?><tr class="alt">
          <td><?php echo $row1["Student"] ?></td>
          <td><?php echo $row1["Question"] ?></td>
          <td><?php echo $row1["LikedBy"] ?></td>
          </tr> <?php
        }
      }else {?>
      <tr class="alt">
        <td><?php echo "Sorry, we can't find any results"?></td>
        <?php
      }
      $conn->close();
      ?>

    </table>
  </body>
  </html>


