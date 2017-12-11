<!-- To process the data from user registration and insert it into the database-->
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <body background="background_full.jpg"></body>
</body>
</html>

<?php 

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


$type =  $_POST['user_type'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$pass2 = $_POST['pass2'];
$profile_picture = $_POST['link'];
$street = $_POST['street'];
$city = $_POST['city'];
$zip = $_POST['zcode'];
$country = $_POST['country_name'];
$number = $_POST['phone'];
$number2 = $_POST['phone2'];

session_start();
$_SESSION["email"] = $email;
// if the user is an Admin
if ($type == 'As Admin')
{
 $ua = 'Yes';
 $uf = 'No';
}
// if the user is a Faculty
elseif ($type == 'As Faculty')
{
 $ua = 'No';
 $uf = 'Yes';
}
else
{
 $ua = 'No';
 $uf = 'No';
}

$salt = substr(md5(mt_rand()), 0, 7);		// To generate salt to the password
// To check the password
if($pass==$pass2)
{	
 
 $uinfo = " INSERT INTO userinfo ( AsFaculty,  AsAdmin,  FirstName, LastName, Email, ProfilePic, Street, City, Zipcode, Country) 
 VALUES ( (?), (?), (?), (?), (?),  (?), (?), (?), (?), (?)) " ;
 // prepared statements to prevent sql injection
 $stmt = $conn -> prepare($uinfo);
 $stmt -> bind_param("ssssssssss", $uf, $ua, $fname, $lname, $email,  $profile_picture, $street, $city, $zip, $country);
 $stmt -> execute();

 

 
 $idem = "SELECT Userid from userinfo where email= (?)";
 $stmt1 = $conn -> prepare($idem);
 $stmt1 -> bind_param("s",$email);
 $stmt1 -> execute();
 $result2 = $stmt1->get_result();


 $row = mysqli_fetch_array($result2);
 $row1 = $row['Userid'];
 

 $uphone = " INSERT into usercontact (Userid, Phone) VALUES ((?),(?))";
 $stmt3 = $conn -> prepare($uphone);
 $stmt3 -> bind_param("ss",$row1,$number);
 $stmt3 -> execute();

 
 if(!empty($number2))
 {
   
   $uphone2 = " INSERT into usercontact (Userid, Phone) VALUES ((?),(?))";
   $stmt4 = $conn -> prepare($uphone2);
   $stmt4 -> bind_param("ss",$row1,$number2);
   $stmt4 -> execute();
 }
 

 $joinsaltpass = $salt.$pass;// add salt to the password

           $hashed_and_salted = hash('SHA256', $joinsaltpass); // hash the joined password

           
           $upass = "INSERT INTO userpasswords (Userid, Salt,Password) VALUES ((?), (?) ,(?))";
           $stmt5 = $conn -> prepare($upass);
           $stmt5 -> bind_param("sss",$row1,$salt,$hashed_and_salted);
           $stmt5 -> execute();

           if ($type == 'As Faculty')
           {
             header("Location: faculty_info.php"); // for extra faculty realted info
           }
           elseif ($type == 'As Admin') { 
            
            $ainfo = " INSERT INTO administrator (AdminId,GrantorId,ApprovalDatetime) 
            VALUES ( '$row1', null,null)" ;
            $result = $conn->query($ainfo); 
          }

        }
        else
        {
         $_SESSION[ 'message' ] = " The two password do not match ";  
         echo "password mismatch"; 
       }
       
       echo "done";

       header("Refresh: 1, url = index.php");// go back to the login page after registration

       ?>