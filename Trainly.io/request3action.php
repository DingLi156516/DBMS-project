<!-- To process the data from request3.php-->
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
<script>
  (function () {
    document.getElementById("scrollLink").click();
  })();
</script>
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

      $sql = "SELECT u.`FirstName`, c.`Name` as `CourseName`
      FROM (`CourseInfo` c INNER JOIN `Course-Students` cs ON cs.`CourseId`= c.`CourseId`) INNER JOIN `UserInfo` u ON u.`Userid`=`StudentId`
      WHERE u.`Userid`=
      (
      SELECT Userid FROM UserInfo WHERE Email=?)
      AND c.`Name` IN
      (
      SELECT c.`Name`
      FROM (`CourseInfo` c INNER JOIN `Course-Material` cm ON c.`CourseId`=cm.`CourseId`) INNER JOIN `Links` l ON cm.`Materialid`=l.`Materialid`
      GROUP BY c.`Name`
      HAVING COUNT(*)>1
    )
    ORDER BY c.`CourseId`;";

    // Prepared statement
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s",$useremail2);
    $stmt->execute();
    $result1 = $stmt->get_result();
    // To display the data
    if ($result1->num_rows > 0) { ?>
    <tr>
      <th><?php echo "FirstName";?></th>
      <th><?php echo "CourseName";?></th>
    </tr>
    <?php
    while($row1 = $result1->fetch_assoc()) {
     ?><tr class="alt">
      <td><?php echo $row1["FirstName"] ?></td>
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
  </table>
</body>
</html>