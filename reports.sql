#COMPLEX QUERIES
-- #1. Output courses which have more than a certain number of secondary topics.
-- The information result should be sorted by the number #of secondary topics courses have, descending, then by the creators’ 
-- name #(alphabetically), then by the courses’ name (alphabetically).More than three tables joined(1 point), 1 subquery(1 point), 
-- has aggregate function(1 point), has grouping(1 point), 2 ordering fields(1 point), 2 Where/having conditions(1 point), 
-- strong motivation/justification(1 point)
-- Justification: This query is useful when an administrator wants to find out which course has a certain number of topics.

SELECT DISTINCT(`CourseName`) FROM
(
SELECT `Faculty`.`FacultyId` as `CreatorId`, `CourseInfo`.`Name` as `CourseName`,count(`SecondaryTopics`.`TopicName`) as `Counts`
FROM ((`CourseInfo` inner join `SecondaryTopics` on `CourseInfo`.`CourseId`=`SecondaryTopics`.`CourseId`) 
INNER JOIN `Course-Creation` on `Course-Creation`.`CourseId`=`CourseInfo`.`CourseId` )
INNER JOIN `Faculty` on `Faculty`.`FacultyId`=`Course-Creation`.`CreatorId` 
GROUP BY `CourseInfo`.`CourseId`, `Faculty`.`FacultyId`
HAVING Counts >=(?))as t
ORDER BY t.`Counts` DESC, `CreatorId`, `CourseName`;

-- #2. Output the Course Name, for which has more than a certain number of students and more than 1 #faculty creator, also output the average 
-- student rating for this course, and the #output is ordered first by the student number, then by the average student rating. 
-- More than three tables joined(1 point), 1 subquery(1 point), has aggregate function(1 point), has grouping(1 point), 
-- 2 ordering fields(1 point), 2 Where/having conditions(1 point), strong motivation/justification(1 point)
-- Justification: When an administrator wants to know which courses have multiple users and multiple creators, 
-- he can use this query, and it is also ordered by the student numbers. The administrator can also see the average user rating.

SELECT c.`Name` AS `Course Name`,COUNT(u.`Userid`) AS `StudentNumber`,AVG(cs.`UserRating`) AS `StudentRating`
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
ORDER BY `StudentNumber` DESC, AVG(cs.`UserRating`) DESC


-- #3. (PARAMETERIZED)Output a student's enrolled courses, and the course must have more than 1 links in its course materials, 
-- the output will extract the student's name and the course names that this student takes. And the user input in this query is the 
-- user email. when a user enter his email, the courses that have more than two links will show up. More than three tables 
-- joined(1 point), 2 subqueries(2 point), has aggregate function(1 point), has grouping(1 point), 2 ordering fields(1 point), 
-- 2 Where/having conditions(1 point), strong motivation/justification(1 point).
-- Justification: This query is userful when an administrator wants to see the courses which have multiple links for a student, it is useful because 
-- sometimes you want to find out the resources a course has, by using this query, we can know if the course has multiple link resources.
SELECT u.`FirstName`, c.`Name` as `CourseName`
FROM (`CourseInfo` c INNER JOIN `Course-Students` cs ON cs.`CourseId`= c.`CourseId`) INNER JOIN `UserInfo` u ON u.`Userid`=`StudentId`
WHERE u.`Userid`=
(
   SELECT Userid FROM UserInfo WHERE Email=(?))
AND c.`Name` IN
(
    SELECT c.`Name`
    FROM (`CourseInfo` c INNER JOIN `Course-Material` cm ON c.`CourseId`=cm.`CourseId`) INNER JOIN `Links` l ON cm.`Materialid`=l.`Materialid`
  GROUP BY c.`Name`
  HAVING COUNT(*)>1
)
ORDER BY c.`CourseId`;

-- #4. (PARAMETERIZED)For a particular topic/category, output the number of students enrolled in courses belonging to that topic, 
-- as well as return the count of courses belonging to that topic. 
-- The user input is the topic name that the user wants to get information about.
-- More than three tables connected(1 point), 2 subqueries(2 point), has aggregate function(1 point), 2 queries for union(1 point), 
-- 2 Where/having conditions(1 point), strong motivation/justification(1 point)
-- Justification: This query is useful when an administrator wants to know which topic is the hottest in all the topics, he can execute
-- this query so that he can get the student numbers for all the courses that have this topic. And he can also see the number of courses that have this topic.


SELECT (?) as Topic, 
(	SELECT COUNT(*) FROM 
    ( SELECT CourseId FROM `CourseInfo` c INNER JOIN `Topics` t ON c.PrimaryTopic=t.TopicNames
	  WHERE t.TopicNames=(?)
	  UNION ALL
	  SELECT CourseId 
	  FROM `SecondaryTopics` s
	  WHERE s.TopicName=(?)) AS q1
) AS `Number of Courses`,  COUNT(cs.StudentId) AS `Number of students enrolled/completed`
FROM `Course-Students` cs 
WHERE cs.CourseId IN
(SELECT CourseId 
FROM `CourseInfo` c INNER JOIN `Topics` t ON c.PrimaryTopic=t.TopicNames
WHERE t.TopicNames=(?)
UNION ALL
SELECT CourseId 
FROM `SecondaryTopics` s
WHERE s.TopicName=(?)) AND cs.PaymentDateTime IS NOT NULL;


-- #5. (PARAMETERIZED) the request5 is to help faculties look for the questions relating to the course they have created. 
#The faculty should input his email id and the course name he's looking for. If the faculty is not one of the course's creators, 
#there will not be any output. The output includes the first name of the student who asked that question, the question itself, 
#and the amount of students who liked it.
-- Justification: This is useful when a faculty wants to find out if their courses have any questions posted. 

SELECT `UserInfo`.`FirstName` as `Student`, `Questions`.`Question` AS `Question`, COUNT(`QuestionRating`.`LikedById`) AS `LikedBy`
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
ORDER BY `LikedBy` DESC, `Student`;