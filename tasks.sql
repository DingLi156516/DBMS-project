#PART A
-- In the task A there are three possible options, because the user maybe a student or a faculty or a administrator, 
-- so we should consider all the possibilities and thus we have 3 queries. All the userinfo need to be parameterized since 
-- all the information is input by the user except FacultyApproved and AdminApproved, these two values are default 0. 
-- For faculty table the user also needs to input all the information in the faculty table except the authenticatorId and 
-- completion date/time.

INSERT INTO `userinfo` ( `AsFaculty`,  `AsAdmin`,  `FirstName`, `LastName`, `Email`, `ProfilePic`, `Street`, `City`, `Zipcode`, `Country`) 
           VALUES ( (?), (?), (?), (?), (?),  (?), (?), (?), (?), (?)) ;
INSERT INTO `UserPasswords` (`Userid`, `Salt`,`Password`) VALUES ((?), (?) ,(?))
INSERT into `usercontact` (`Userid`, `Phone`) VALUES ((?),(?));
INSERT INTO `Faculty`(`FacultyId`,`Title`,`WorkWebsite`, `Affiliation`, `AuthenticatorId`, `AuthenticationDateTime`) VALUES ( (?), (?), (?), (?),(?),(?));
INSERT INTO `Administrator` (`AdminId`,`GrantorId`,`ApprovalDatetime`) 
            VALUES ((?), null,null);


#PART B
-- In task B, authenticating a faculty/admin means update the table for the faculty/admin and userinfo, so we need to update both table, 
-- make the faculty approved. The parameterizations here are the faculty/admin email and the administrator email who can authenticate others, when administrator input his email and the faculty/admin email he wants to update, the table is automatically updated.

UPDATE `Faculty` SET `AuthenticatorId`=(SELECT Userid FROM UserInfo WHERE email=(?)),`AuthenticationDateTime`=NOW() 
WHERE `FacultyId` = (Select Userid from Userinfo where email = (?)) 
AND `Title` IS NOT NULL AND `WorkWebsite` IS NOT NULL AND `Affiliation` IS NOT NULL;

UPDATE `UserInfo` SET `FacultyApproved`=1 
WHERE `Email` = (?);

UPDATE `Administrator` SET `GrantorId`=(SELECT Userid FROM UserInfo WHERE email=(?)) ,`AuthenticationDateTime`=NOW() WHERE `AdminId` = (Select Userid from Userinfo where email = '$uname');
UPDATE `UserInfo` SET `AdminApproved`=1 WHERE `Email` = (?);


#PART C
-- In task C we need to select 3 different tables, one is for completed courses, one for currently enrolled and one 
-- for the interested courses, and each table provides with student's name, course name, the course's primary topic 
-- and secondary topics, and it is order by the average evaluation score. The user input here is user email, when a user 
-- enters an email for a student, the information will show up.

SELECT * FROM
    (SELECT b.StudentId as `Student`, e.FirstName as `First Name`, e.LastName as `Last Name`, a.`Name` as`Course name`, a.`PrimaryTopic` as `Primary Topic`, c.`TopicName` as `Secondary Topic`,
    AVG(b.`UserRating`) as `Avg Course Evaluation Score`, 'Completed' as Status
    FROM (((`CourseInfo` a INNER JOIN `Course-Students` b ON a.`CourseId`=b.`CourseId`)
    INNER JOIN `SecondaryTopics` c ON a.`CourseId`=c.`CourseId`)
    INNER JOIN `Topics` d ON c.`Topicname`=d.`TopicNames`)
    INNER JOIN UserInfo e ON b.StudentId=e.Userid
    WHERE b.`CompletionDateTime` IS NOT NULL AND b.`StudentId` = (Select Userid from Userinfo where email = (?))
    GROUP BY a.CourseId, c.TopicName) as ty 
    ORDER BY ty.`Avg Course Evaluation Score`;

SELECT * FROM
    (SELECT b.StudentId as `Student`, e.FirstName as `First Name`, e.LastName as `Last Name`, a.`Name` as`Course name`, a.`PrimaryTopic` as `Primary Topic`, c.`TopicName` as `Secondary Topic`,
    AVG(b.`UserRating`) as `Avg Course Evaluation Score`, 'Currently Enrolled' as Status
    FROM (((`CourseInfo` a INNER JOIN `Course-Students` b ON a.`CourseId`=b.`CourseId`)
    INNER JOIN `SecondaryTopics` c ON a.`CourseId`=c.`CourseId`)
    INNER JOIN `Topics` d ON c.`Topicname`=d.`TopicNames`)
    INNER JOIN UserInfo e ON b.StudentId=e.Userid
    WHERE b.`CompletionDateTime` IS NULL AND b.`StudentId` = (Select Userid from Userinfo where email = (?))
    GROUP BY a.CourseId, c.TopicName) as ty 
    ORDER BY ty.`Avg Course Evaluation Score`;

SELECT `student-interest`.`StudentID` as `Student`, `userinfo`.`FirstName` as `First Name`,`userinfo`.`LastName` as `Last Name`, `courseinfo`.`Name` as `Course name`, `courseinfo`.`PrimaryTopic` as `Primary Topic` , 
`secondarytopics`.`TopicName` as `Secondary Topic`, 
AVG(`course-students`.`UserRating`) as `Avg Course Evaluation Score`,
'Interested In' as `Status` from `student-interest`
inner join `userinfo` on `student-interest`.`StudentId` = `userinfo`.`Userid`
inner join `courseinfo` on `student-interest`.`CourseId`=`courseinfo`.`CourseId`
inner join `secondarytopics` on `secondarytopics`.`CourseId` = `student-interest`.`CourseId`
inner join `course-students`on `course-students`.`CourseId` = `courseinfo`.`CourseId`
where `student-interest`.`StudentId` = (Select Userid from Userinfo where email = (?))
GROUP by `courseinfo`.`CourseId`, `secondarytopics`.`TopicName`
order by `Avg Course Evaluation Score` DESC, `Course name` DESC;


#PART D
-- In task D if we want a student to enroll in a course we just need to update the course-students table which has the 
-- course information for students and the user inputs here are the email address and course name. And the $confcode is a variable which represent a function in PHP that is used to generate random confirmation code. 

INSERT INTO `Course-Students` (`CourseId`,`StudentId`,`PaymentDateTime`,`AmountPaid`,`ConfirmationCode`,`CompletionDateTime`,`UserComment`,`UserRating`,`CertificateLink`)
VALUES ((Select CourseId from CourseInfo where Name = (?)),(Select Userid from Userinfo where email = (?)),NOW(),(Select Cost from CourseInfo where Name = (?)),'$confcode',null,null,null,null);

#PART E
-- In task E we need to create a new table which shows each course material information and give the status of the 
-- course material as completed or not completed. The user input is email and the course name , when a user input the email and course name he enrolled, the information will show up. 

SELECT a.`Name` as `Material Name`, a.`Materialid` as `Material ID`, a.`MaterialSeqId`, c.Name as `Course Name`, 'YES' as `Completion Status`
        FROM ((`Course-Material` a INNER JOIN `Material-Confirmation` b ON a.Materialid = b.Materialid)
        INNER JOIN `CourseInfo` c ON a.CourseId = c.CourseId) INNER JOIN `Course-Students` cs ON cs.CourseId = c.CourseId
        WHERE b.StudentId= (Select Userid from Userinfo where email = (?)) AND cs.CourseId = (Select CourseId from CourseInfo where Name = (?))
        AND b.`CompletionDateTime` IS NOT NULL
        UNION
        SELECT a.`Name` as `Material Name`, a.`Materialid`as `Material ID`, a.`MaterialSeqId`, c.Name as `Course Name`, 'NO' as `Completion Status`
        FROM ((`Course-Material` a INNER JOIN `Material-Confirmation` b ON a.Materialid = b.Materialid)
        INNER JOIN `CourseInfo` c ON a.CourseId = c.CourseId)INNER JOIN `Course-Students` cs ON cs.CourseId = c.CourseId
        WHERE b.StudentId=(Select Userid from Userinfo where email = (?)) AND cs.CourseId = (Select CourseId from CourseInfo where Name = (?))
        AND b.`CompletionDateTime` IS NULL;

#PART F
-- In this task we need to update the material-confirmation table which is parameterized by the student email, course name and material name.
UPDATE `Material-Confirmation` SET `CompletionDateTime`=NOW() 
       WHERE `Materialid`=(SELECT Materialid FROM `Course-Material` WHERE name= (?))
       AND CourseId = (SELECT CourseId FROM CourseInfo WHERE Name= (?))) 
       AND `StudentId` = (Select Userid from Userinfo where email = (?));

#PART G
-- In this task we have a certificationlink for each student, and the user input here are the coursename and the user email, 
-- when a user enter these, it will list the student name, course name,completion date nad time, and a link for his certificate.


UPDATE `Course-Students` SET CertificateLink = IF(CompletionDateTime IS NOT NULL,'Link to certificate/', CertificateLink) WHERE StudentId = (SELECT Userid FROM UserInfo WHERE Email=(?)) AND CourseId= (SELECT Courseid FROM CourseInfo WHERE Name=(?));

SELECT u.`FirstName` as `First Name`, u.`LastName` as `Last Name`, ci.`Name` AS `Course Name`, c.`CompletionDateTime` as `Completion Details`, c.`CertificateLink` as `Link to Certificate`
FROM (`Course-Students` c INNER JOIN `UserInfo` u ON u.`Userid`=c.`StudentId`)
INNER JOIN `CourseInfo` ci ON ci.`CourseId`=c.`CourseId`
WHERE c.`StudentId`=(Select Userid from Userinfo where email = (?))
AND ci.`Name`=(?) AND c.`CompletionDateTime` IS NOT NULL;

-- PART H
-- In task H we need to populate 2 tables, one table shows the date of enrollment and completion, amount paid, 
-- one shows the total spent for each course, and the user input here is user email, when you enter an email address, 
-- this table will show up.

SELECT a.`StudentId` as `ID`, c.`FirstName` as `First Name`,c.`LastName` as `Last Name`,b.`Name` as `COURSE`, a.`PaymentDateTime` as `Payment Details`,a.`CompletionDateTime` as Completion, a.`ConfirmationCode` as `Confirmation Code`, a.`AmountPaid` as `Amount paid`
FROM (`course-students` a INNER JOIN courseinfo b on a.`CourseId` = b.`CourseId`)
INNER JOIN `UserInfo` c ON c.Userid=a.StudentId
WHERE studentid = (Select Userid from Userinfo where Email = (?));

SELECT a.`StudentId` as ID, c.`FirstName` as `First Name`,c.`LastName` as `Last Name`, SUM(a.`AmountPaid`) as `Total Spent`
FROM `course-students` a INNER JOIN `UserInfo` c ON c.Userid=a.StudentId
WHERE studentid = (Select Userid from Userinfo where email = (?))
GROUP BY studentid;




 
