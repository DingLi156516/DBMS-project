<!-- To process the data from request4.php -->
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
      $topicname = $_POST['tname'];
// Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      } 

      $sql = "SELECT (?) as Topic, 
      ( SELECT COUNT(*) FROM 
      ( SELECT CourseId FROM `CourseInfo` c INNER JOIN `Topics` t ON c.PrimaryTopic=t.TopicNames
      WHERE t.TopicNames=?
      UNION ALL
      SELECT CourseId 
      FROM `SecondaryTopics` s
      WHERE s.TopicName=?) AS q1
    ) AS `Number of Courses`,  COUNT(cs.StudentId) AS `Number of students enrolled/completed`
    FROM `Course-Students` cs 
    WHERE cs.CourseId IN
    (SELECT CourseId 
    FROM `CourseInfo` c INNER JOIN `Topics` t ON c.PrimaryTopic=t.TopicNames
    WHERE t.TopicNames=?
    UNION ALL
    SELECT CourseId 
    FROM `SecondaryTopics` s
    WHERE s.TopicName=?) AND cs.PaymentDateTime IS NOT NULL;";

    // prepared statements
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("sssss",$topicname,$topicname,$topicname,$topicname, $topicname);
    $stmt->execute();
    $result1 = $stmt->get_result();
    ?>
    <tr>
      <th><?php echo "Topic";?></th>
      <th><?php echo "Number of Courses";?></th>
      <th><?php echo "Number of students enrolled/completed";?></th>
    </tr>
    <?php
    // To display the result
    while($row1 = $result1->fetch_assoc()) {
      ?><tr class="alt">
        <td><?php
        if($row1["Number of Courses"]==0)
        {
          echo"There is no such topic!";
        }
        else {
          echo $row1["Topic"];
        }
        ?></td>
        <td><?php echo $row1["Number of Courses"] ?></td>
        <td><?php echo $row1["Number of students enrolled/completed"] ?></td>
        </tr> <?php

      }
      $conn->close();
      ?>
    </table>
  </body>
  </html>