<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>

<?php
$code = $_POST["code"];
$c1 = $_POST["c1"]; 
$c2 = $_POST["c2"]; 
$c3 = $_POST["c3"];
$servername = "sql206.epizy.com";
$username = "epiz_23503671";
$password = "QwuJ3LzEeZ";
$dbname = "epiz_23503671_codes";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM `031519` WHERE 1";
$result = $conn->query($sql);
$valid="false";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		
        /*echo "username: " . $row["username"]. " - Password: " . $row["password"]. " " . $row["email"]. "<br>";*/
		if ($code == $row[code]){
			$valid = "true";
		}
	}
}

if ($valid == "false"){
	echo "Bad code. Sorry.";
}
else{
	echo "Valid code." ;
}
?>
<!--
<?php
$servername = "sql206.epizy.com";
$username = "epiz_23503671";
$password = "QwuJ3LzEeZ";
$dbname = "epiz_23503671_votes";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM `users` WHERE 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		
        /*echo "username: " . $row["username"]. " - Password: " . $row["password"]. " " . $row["email"]. "<br>";*/
		if ($uname == $row[username]){
			if ($psw == $row[password]){
				/*echo "Valid Details.";
				echo $uname,$psw,$row[username],$row[password];*/
				$_SESSION["uname"] = $uname;
				/*echo $_SESSION["uname"] ;
				echo $uname ;*/
				header('Location: welcome.php');
			}
		}
	}
}
 else {
    echo "0 results";
}
$conn->close();
?>-->


</body>
<!--<meta http-equiv='refresh' content='0; URL=http://reapnow.ml/login.php'>-->
</html>
