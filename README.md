# groupproject3-DBMS
Trainly.io

For the ease of tesing of out project, here are three credentials for each type of users
Student example:
email: Huf@gmail.com
password: 1Sabra

Faculty example:
email: Gallardo@gmail.com
password: 23Romaine

Admin example:
email: Bivona@gmail.com
password: 31Vickey


The tasks and complex queries that student can perform:
Task C, Task E, Task F, Task H, Complex Query 3

The tasks and complex queries that admin can perform:
Task B, Task C, Task D, Task G, Task H, Complex Query 1, Complex Query 2

The tasks and complex queries that faculty can perform:
Complex Query 4, Complex Query 5

All the new users can perform Task A (user registration)


Here are each program files' name and what they do briefly:
user_registration.php - Basic information of the user. Used to create new users who can be a student, faculty or administrator. 
user_process.php - To process the data from user registration and insert it into the database
faculty_info.php - Part of user registration as faculty
Adminpage.php - Admin homepage
Facultypage.php - Faculty homepage
Studentpage.php - STUDENT HOMEPAGE
index.php - The login page
login.php - Process the information from the index page. Checks username and password against the database
logout.php - Logout page
Pageprepare.php - Stylesheet to use in other pages
request1.php - utput courses which have more than # secondary topics.
 The information result should be sorted by the number # of secondary topics courses have, descending, then by the creators name #(alphabetically), then by the courses name (alphabetically)
Done by the admin
request1action.php - To process the data from request1.php
request2.php - Output the Course Name, for which has more than a certain number of students and more than 1 #faculty creator, also output the average student rating for this course, and the #output is ordered first by the student number, then by the average student rating
request2action.php - To process the data from request2.php
request3.php - Output a studentís enrolled courses, and the course must have more than 1 links in its course materials, 
the output will extract the studentís name and the course names that this student takes. And the user input in this query is the 
user email. when a user enter his email, the courses that have more than two links will show up.
request3action.php - To process the data from request3.php
request4.php - For a particular topic/category, output the number of students enrolled in courses belonging to that topic, as well as return the count of courses belonging to that topic. 
 The user input is the topic name that the user wants to get information about.
request4action.php - To process the data from request4.php
request5.php - To help faculties look for the questions relating to the course they have created. 
The faculty should input his email id and the course id heís looking for. If the faculty is not one of the courseís creators, there will not be any output. The output includes the first name of the student who asked that question, the question itself, and the number of students who liked it 
request5action - To process the data from request5.php
taskb.php - Authentication of a faculty/admin means update the table for the faculty/admin and userinfo, so we need to update both table,make the faculty approved
taskbinter.php - Intermediate file to redirect user to Faculty authentication or Admin authentication depending on the selection
taskbb1.php - Here admin selects the faculty to the authenticated
taskbfac.php - To process the data from taskbb1.php
taskbad.php - Here admin selects the administrator to the authenticated
taskbadm.php - To process the data from taskbad.php
TaskCadmin.php - Provide a categorized list of a student's courses (each with primary/secondary topics, ranked by average evaluation score): currently enrolled, completed, of interest
TaskCactionadmin.php  - To process the data from TaskCadmin.php and display the result
TaskCactionstudent.php - Categorized list of courses: currently enrolled, completed, of interest 
TaskD.php - In task D if we want a student to enroll in a course we just need to update the course-students table which has the course information for students and the user inputs here are the email address and course name. And the $confcode is a variable which represent a function in PHP that is used to generate random confirmation code
TaskDnext.php - To process the data from TaskD.php and then user chooses the desired course name
TaskDaction.php - To process data from TaskDnext.php and display result
TaskE.php - In task E we need to create a new table which shows each course material information and give the status of the course material as completed or not completed. The user input is email and the course name , when a user input the email and course name he enrolled, the information will show up.
TaskEaction.php - To process TaskE.php and display the result 
TaskF.php - In this task we need to update the material-confirmation table which is parameterized by the student email, course name and material name.
TaskFnext.php - To process data from TaskFnext.php and students selects the material completed 
TaskFaction.php -  To process TaskFnext.php and display result 
TaskG.php - In this task we have a certificationlink for each student, and the user input here are the coursename and the user email, when a user enter these, it will list the student name, course name,completion date nad time, and a link for his certificate.
TaskGprocess.php - To process the data from TaskG.php and then user chooses the desired course name 
TaskGlast.php - To process the data from TaskGaction.php and display the result
TaskH.php - In task H we need to populate 2 tables, one table shows the date of enrollment and completion, amount paid, one shows the total spent for each course, and the user input here is user email, when you enter an email address, this table will show up. - Done by admin
TaskHprocessadmin.php - To process the data from TaskH.php and display a result
TaskHprocessstudent.php - In task H we need to populate 2 tables, one table shows the date of enrollment and completion, amount paid, one shows the total spent for each course, and the user input here is user email, which is a session variable and it goes in, this table will show up. - Done by Student


Here’s how the files are compared and combined:
In order to login, you will need the index.php, login.php.
For Task A, which is the user registration, it will require user_registration.php, user_process.php.
For Task B it requires taskb.php, taskbad.php, taskbadm.php, taskbb1.php and taskbinter.php.
For Task C TaskCactionadmin.php and TaskCadmin.php are required if an admin wnats to execute it. But for student only TaskCactionstudent.php is needed.
For Task D it requires TaskD.php, TaskDaction.php and TaskDnext.php.
For Task E it requires TaskE.php and TaskEaction.php.
For Task F it requires TaskF.php and TaskFaction.php.
For Task G it requires TaskG.php, TaskGlast.php and TaskFaction.php.
For Task H it requires TaskH.php, TaskHprocessadmin.php and TaskHprocessstudent.php for the both the administrator and the student to run.
For complex query 1 it requires request1.php and request1action.php.
For complex query 1 it requires request2.php and request2action.php.
For complex query 1 it requires request3.php and request3action.php.
For complex query 1 it requires request4.php and request4action.php.
For complex query 1 it requires request5.php and request5action.php.


Besides, for some tasks, when you login as some random user, the dropdown list for some specific tasks will be null, that is because there is no value related to it. We didn't implement another option for this situation because of time limit.
