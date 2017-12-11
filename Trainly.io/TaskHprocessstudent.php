<!-- In task H we need to populate 2 tables, one table shows the date of enrollment and completion, amount paid, one shows the total spent for each course, and the user input here is user email, which is a session variable and it goes in, this table will show up. - Done by Student-->
<html><head><style type="text/css">
#table
{
  font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
  width:100%;
  border-collapse:collapse;
}

#table2
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

#table2 th 
{
  font-size:1.1em;
  text-align:left;
  padding-top:5px;
  padding-bottom:4px;
  background-color:#F7CA42;
  color:#ffffff;
}
#table2 td, #table2 th 
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
#table2 tr.alt td 
{
  color:#000000;
  background-color:#E7CA42;
}
#table tr.ass td 
{
  color:#000000;
  background-color:#EAF2F3;
}
#table tr.ass2 td 
{
  color:#000000;
  background-color:#EAF2A3;
}

</style>
<script>
  (function () {
    document.getElementById("scrollLink").click();
  })();
</script>
</head>
<body background="background_full.jpg">
 
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

  $result1 = 0;
  $result2 = 0;

  $sql1 = " SELECT a.`StudentId` as `ID`, c.`FirstName` as `First Name`,c.`LastName` as `Last Name`,b.`Name` as `COURSE`, a.`PaymentDateTime` as `Payment Details`,
  a.`CompletionDateTime` as Completion, a.`ConfirmationCode` as `Confirmation Code`, a.`AmountPaid` as `Amount paid`
  FROM (`course-students` a INNER JOIN courseinfo b on a.`CourseId` = b.`CourseId`)
  INNER JOIN `UserInfo` c ON c.Userid=a.StudentId
  WHERE studentid = (Select Userid from Userinfo where Email = (?))";

  $sql2 = "  SELECT a.`StudentId` as ID, c.`FirstName` as `First Name`,c.`LastName` as `Last Name`, SUM(a.`AmountPaid`) as `Total Spent`
  FROM `course-students` a INNER JOIN `UserInfo` c ON c.Userid=a.StudentId
  WHERE studentid = (Select Userid from Userinfo where email = (?))
  GROUP BY studentid";

  // prepared statements
  $stmt2 = $conn->prepare($sql2);
  $stmt2->bind_param("s",$useremail2);
  $stmt2->execute();
  $result2=$stmt2->get_result();
  // display results
  if ($result2->num_rows > 0) {
    // output data of each row
    ?>
    <table id="table">
      <tr>
        <th colspan="3"><?php echo "The total amount paid by the student"?></th><tr></tr>
        <th><?php echo "Student ID";?></th>
        <th><?php echo "Student Name"?></th>
        <th><?php echo "Total Spent"?></th>
      </tr>
      <?php
      while ($row1 = $result2->fetch_assoc()) {
        ?><tr class="alt">
        </td>
        <td><?php echo $row1["ID"] ?></td>
        <td><?php echo $row1["First Name"] ?><?php echo " ".$row1["Last Name"]?></td>
        <td><?php echo $row1["Total Spent"]?></td>
        </tr> <?php
      }
    } else {
      ?><tr class="alt"> 
      </td>
      <td><?php echo "0 results";?>
        <?php
      }
      $stmt1 = $conn->prepare($sql1);                     
      $stmt1->bind_param("s",$useremail2);
      $stmt1->execute();                   
      $result1= $stmt1->get_result();   
      if ($result1->num_rows > 0) {
        
       ?>
       <br><br>
       <table id="table2">
        <tr>
          <th colspan="7"><?php echo "The account history of the user"?></th><tr></tr>
          <th><?php echo "Student ID";?></th>
          <th><?php echo "Student Name"?></th>
          <th><?php echo "Course"?></th>
          <th><?php echo "Payment Details"?></th>
          <th><?php echo "Completion"?></th>
          <th><?php echo "Confirmation Code"?></th>
          <th><?php echo "Amount Paid"?></th>
        </tr>
        <?php
        while ($row1 = $result1->fetch_assoc()) {

          ?><tr class="alt">
          </td>
          <td><?php echo $row1["ID"] ?></td>
          <td><?php echo $row1["First Name"] ?><?php echo " ".$row1["Last Name"]?></td>
          <td><?php echo $row1["COURSE"]?></td>
          <td><?php echo $row1["Payment Details"]?></td>
          <td><?php echo $row1["Completion"]?></td>
          <td><?php echo $row1["Confirmation Code"]?></td>
          <td><?php echo $row1["Amount paid"]?></td>

          </tr> <?php

        }
      } else {
        ?><tr class="alt"> 
        </td>
        <td><?php echo "0 results";?>
          <?php
        }
        ?>

      </body></html>