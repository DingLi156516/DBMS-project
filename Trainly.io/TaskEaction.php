<!-- To process TaskE.php and display the result -->
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

      // Query 
      $stmt = $conn->prepare( "SELECT a.`Name` as `Material Name`, a.`Materialid` as `Material ID`, a.`MaterialSeqId`, c.Name as `Course Name`, 'YES' as `Completion Status`
        FROM ((`Course-Material` a INNER JOIN `Material-Confirmation` b ON a.Materialid = b.Materialid)
        INNER JOIN `CourseInfo` c ON a.CourseId = c.CourseId) INNER JOIN `Course-Students` cs ON cs.CourseId = c.CourseId
        WHERE b.StudentId= (Select Userid from Userinfo where email = (?)) AND cs.CourseId = (Select CourseId from CourseInfo where Name = (?))
        AND b.`CompletionDateTime` IS NOT NULL
        UNION
        SELECT a.`Name` as `Material Name`, a.`Materialid`as `Material ID`, a.`MaterialSeqId`, c.Name as `Course Name`, 'NO' as `Completion Status`
        FROM ((`Course-Material` a INNER JOIN `Material-Confirmation` b ON a.Materialid = b.Materialid)
        INNER JOIN `CourseInfo` c ON a.CourseId = c.CourseId)INNER JOIN `Course-Students` cs ON cs.CourseId = c.CourseId
        WHERE b.StudentId=(Select Userid from Userinfo where email = (?)) AND cs.CourseId = (Select CourseId from CourseInfo where Name = (?))
        AND b.`CompletionDateTime` IS NULL");
      // prepared statements
      $stmt->bind_param("ssss", $useremail2, $cname, $useremail2, $cname);
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        ?>
        <tr>
          <th><?php echo "Material Name";?></th>
          <th><?php echo "Material ID";?></th>
          <th><?php echo "MaterialSeqId";?></th>
          <th><?php echo "Course Name";?></th>
          <th><?php echo "Completion Status";?></th>
        </tr>
        <?php
        while($row1 = $result->fetch_assoc()){
         ?><tr class="alt">
          <td><?php echo $row1["Material Name"] ?></td>
          <td><?php echo $row1["Material ID"] ?></td>
          <td><?php echo $row1["MaterialSeqId"] ?></td>
          <td><?php echo $row1["Course Name"] ?></td>
          <td><?php echo $row1["Completion Status"] ?></td>
          <?php
        }
      } 
      else {
        ?><tr class="alt">
          <td><?php echo "Error: 0 results" . $conn->error;?></td>
          <?php
        }

        $conn->close();
        ?>
      </table>
    </body>
    </html>