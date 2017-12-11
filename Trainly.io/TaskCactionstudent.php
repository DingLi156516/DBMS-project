<!--  Categorized list of courses: currently enrolled, completed, of interest -->
<html>

<head><style type="text/css">
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


<body background="background_full.jpg">

    <?php
    if (!isset($_SESSION)) {
        session_start();
    }
    $useremail = "'" . $_SESSION['userEmail'] . "'";
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "GROUP3project";


// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Query for courses completed
    $sql1 = "SELECT * FROM
    (SELECT b.StudentId as `Student`, e.FirstName as `First Name`, e.LastName as `Last Name`, a.`Name` as`Course name`, a.`PrimaryTopic` as `Primary Topic`, c.`TopicName` as `Secondary Topic`,
    AVG(b.`UserRating`) as `Avg Course Evaluation Score`, 'Completed' as Status
    FROM (((`CourseInfo` a INNER JOIN `Course-Students` b ON a.`CourseId`=b.`CourseId`)
    INNER JOIN `SecondaryTopics` c ON a.`CourseId`=c.`CourseId`)
    INNER JOIN `Topics` d ON c.`Topicname`=d.`TopicNames`)
    INNER JOIN UserInfo e ON b.StudentId=e.Userid
    WHERE b.`CompletionDateTime` IS NOT NULL AND b.`StudentId` = (Select Userid from Userinfo where email = ?)
    GROUP BY a.CourseId, c.TopicName) as ty 
    ORDER BY ty.`Avg Course Evaluation Score`;";
    // Query for courses enrolled
    $sql2 = "SELECT * FROM
    (SELECT b.StudentId as `Student`, e.FirstName as `First Name`, e.LastName as `Last Name`, a.`Name` as`Course name`, a.`PrimaryTopic` as `Primary Topic`, c.`TopicName` as `Secondary Topic`,
    AVG(b.`UserRating`) as `Avg Course Evaluation Score`, 'Currently Enrolled' as Status
    FROM (((`CourseInfo` a INNER JOIN `Course-Students` b ON a.`CourseId`=b.`CourseId`)
    INNER JOIN `SecondaryTopics` c ON a.`CourseId`=c.`CourseId`)
    INNER JOIN `Topics` d ON c.`Topicname`=d.`TopicNames`)
    INNER JOIN UserInfo e ON b.StudentId=e.Userid
    WHERE b.`CompletionDateTime` IS NULL AND b.`StudentId` = (Select Userid from Userinfo where email = ?)
    GROUP BY a.CourseId, c.TopicName) as ty 
    ORDER BY ty.`Avg Course Evaluation Score`;";
    // Query for interested courses
    $sql3 = "SELECT `student-interest`.`StudentID` as `Student`, `userinfo`.`FirstName` as `First Name`,`userinfo`.`LastName` as `Last Name`, `courseinfo`.`Name` as `Course name`, `courseinfo`.`PrimaryTopic` as `Primary Topic` , 
    `secondarytopics`.`TopicName` as `Secondary Topic`, 
    AVG(`course-students`.`UserRating`) as `Avg Course Evaluation Score`,
    'Interested In' as `Status` from `student-interest`
    inner join `userinfo` on `student-interest`.`StudentId` = `userinfo`.`Userid`
    inner join `courseinfo` on `student-interest`.`CourseId`=`courseinfo`.`CourseId`
    inner join `secondarytopics` on `secondarytopics`.`CourseId` = `student-interest`.`CourseId`
    inner join `course-students`on `course-students`.`CourseId` = `courseinfo`.`CourseId`
    where `student-interest`.`StudentId` = (Select Userid from Userinfo where email = ?)
    GROUP by `courseinfo`.`CourseId`, `secondarytopics`.`TopicName`
    order by `Avg Course Evaluation Score` DESC, `Course name` DESC;";
    // prepared statements
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("s", $useremail2);

    $stmt1->execute();
    $result1 = $stmt1->get_result();
    ?>
    <table id="table">
        <tr>
            <th><?php echo "Student ID"; ?></th>
            <th><?php echo "Student Name"; ?></th>
            <th><?php echo "Course Name" ?></th>
            <th><?php echo "Primary Topic" ?></th>
            <th><?php echo "Secondary Topic" ?></th>
            <th><?php echo "Avg Course Evaluation Score" ?></th>
            <th><?php echo "Status" ?></th>
        </tr>
        <?php
        // Display result
        if ($result1->num_rows > 0) {
                // output data of each row
            $row1 = $result1->fetch_assoc();
            if (!($row2 = $result1->fetch_assoc())) {
                ?><tr class="alt">
                </td>
                <td><?php echo $row1["Student"] ?></td>
                <td><?php echo $row1["First Name"] ?><?php echo " " . $row1["Last Name"] ?></td>
                <td><?php echo $row1["Course name"] ?></td>
                <td><?php echo $row1["Primary Topic"] ?></td>
                <td><?php echo $row1["Secondary Topic"] ?></td>
                <td><?php echo $row1["Avg Course Evaluation Score"] ?></td>
                <td><?php echo $row1["Status"] ?></td>
                </tr> <?php
            } else {
                while ($row2) {
                    ?><tr class="alt">
                    </td>
                    <td><?php echo $row1["Student"] ?></td>
                    <td><?php echo $row1["First Name"] ?><?php echo " " . $row1["Last Name"] ?></td>
                    <td><?php echo $row1["Course name"] ?></td>
                    <td><?php echo $row1["Primary Topic"] ?></td>
                    <td><?php
                    echo $row1["Secondary Topic"];
                    while ($row1["Course name"] == $row2["Course name"] and $row1["Status"] == $row2["Status"]) {
                        if ($row1["Secondary Topic"] == $row2["Secondary Topic"]) {
                            $row2 = $result1->fetch_assoc();
                        } else {
                            echo ", " . $row2["Secondary Topic"];
                            $row2 = $result1->fetch_assoc();
                        }
                    }
                    ?></td>
                    <td><?php echo $row1["Avg Course Evaluation Score"] ?></td>
                    <td><?php echo $row1["Status"] ?></td>
                    </tr> <?php
                    $row1 = $row2;
                }
            }
                        
        }
        // Prepared statments
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("s", $useremail2);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        // Display result
        if ($result2->num_rows > 0) {
                        // output data of each row
            $row1 = $result2->fetch_assoc();
            if (!($row2 = $result2->fetch_assoc())) {
                ?><tr class="alt">
                </td>
                <td><?php echo $row1["Student"] ?></td>
                <td><?php echo $row1["First Name"] ?><?php echo " " . $row1["Last Name"] ?></td>
                <td><?php echo $row1["Course name"] ?></td>
                <td><?php echo $row1["Primary Topic"] ?></td>
                <td><?php echo $row1["Secondary Topic"] ?></td>
                <td><?php echo $row1["Avg Course Evaluation Score"] ?></td>
                <td><?php echo $row1["Status"] ?></td>
                </tr> <?php
            } else {
                while ($row2) {
                    ?><tr class="alt">
                    </td>
                    <td><?php echo $row1["Student"] ?></td>
                    <td><?php echo $row1["First Name"] ?><?php echo " " . $row1["Last Name"] ?></td>
                    <td><?php echo $row1["Course name"] ?></td>
                    <td><?php echo $row1["Primary Topic"] ?></td>
                    <td><?php
                    echo $row1["Secondary Topic"];
                    while ($row1["Course name"] == $row2["Course name"] and $row1["Status"] == $row2["Status"]) {
                        if ($row1["Secondary Topic"] == $row2["Secondary Topic"]) {
                            $row2 = $result2->fetch_assoc();
                        } else {
                            echo ", " . $row2["Secondary Topic"];
                            $row2 = $result2->fetch_assoc();
                        }
                    }
                    ?></td>
                    <td><?php echo $row1["Avg Course Evaluation Score"] ?></td>
                    <td><?php echo $row1["Status"] ?></td>
                    </tr> <?php
                    $row1 = $row2;
                }
            }
                      
        }

         // Prepared statments
        $stmt3 = $conn->prepare($sql3);
        $stmt3->bind_param("s", $useremail2);
        $stmt3->execute();
        $result3 = $stmt3->get_result();
        // Display result
        if ($result3->num_rows > 0) {
                        // output data of each row
            $row1 = $result3->fetch_assoc();
            if (!($row2 = $result3->fetch_assoc())) {
                ?><tr class="alt">
                </td>
                <td><?php echo $row1["Student"] ?></td>
                <td><?php echo $row1["First Name"] ?><?php echo " " . $row1["Last Name"] ?></td>
                <td><?php echo $row1["Course name"] ?></td>
                <td><?php echo $row1["Primary Topic"] ?></td>
                <td><?php echo $row1["Secondary Topic"] ?></td>
                <td><?php echo $row1["Avg Course Evaluation Score"] ?></td>
                <td><?php echo $row1["Status"] ?></td>
                </tr> <?php
            } else {
                while ($row2) {
                    ?><tr class="alt">
                    </td>
                    <td><?php echo $row1["Student"] ?></td>
                    <td><?php echo $row1["First Name"] ?><?php echo " " . $row1["Last Name"] ?></td>
                    <td><?php echo $row1["Course name"] ?></td>
                    <td><?php echo $row1["Primary Topic"] ?></td>
                    <td><?php
                    echo $row1["Secondary Topic"];
                    while ($row1["Course name"] == $row2["Course name"] and $row1["Status"] == $row2["Status"]) {
                        if ($row1["Secondary Topic"] == $row2["Secondary Topic"]) {
                            $row2 = $result3->fetch_assoc();
                        } else {
                            echo ", " . $row2["Secondary Topic"];
                            $row2 = $result3->fetch_assoc();
                        }
                    }
                    ?></td>
                    <td><?php echo $row1["Avg Course Evaluation Score"] ?></td>
                    <td><?php echo $row1["Status"] ?></td>
                    </tr> <?php
                    $row1 = $row2;
                }
            }
        }

        if ($result1->num_rows == 0) {
            ?><tr class="alt">
            </td>
            <td colspan="7"><?php echo "No course has been completed by the student yet." ?></td>
        </tr>
        <?php
        $stmt1->free_result();
    }
    if ($result2->num_rows == 0) {
        ?><tr class="alt">
        </td>
        <td colspan="7"><?php echo "The student is not enrolled in any course currently." ?></td>
    </tr>
    <?php
    $stmt2->free_result();
}
if ($result3->num_rows == 0) {
    ?><tr class="alt">
    </td>
    <td colspan="7"><?php echo "The student is not interested in any course." ?></td>
</tr>
<?php
$stmt3->free_result();
}



$conn->close();
?>



</body></html>
