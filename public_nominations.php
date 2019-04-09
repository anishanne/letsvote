<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/admin.css">
    <style type="text/css">
        body{
            color: #54575B;
        }
    </style>
</head>
<div class="topbar" style="text-align: left">
  <a href="/homepage.php" style="color: white; text-decoration:none;">
      < Back to Home Page
    </a>
</div>
<body>
<center>
    <h2 style="font-size:36px;">Nominations</h2>
<?php
require_once "mysql_config.php";
$sql = "SELECT * FROM resultsPageText WHERE 1";
$result = $db->query($sql);
if ($result->num_rows > 0) {
    // output data of each row1
    while($row = $result->fetch_assoc()) {
        echo $row["text"];
    }
} else {
    echo "0 results";
}
?>
        <br>
        <br>
<?php
require_once "mysql_config.php";

$result = mysqli_query($db, "SELECT * FROM candidates");

echo "<table border='1'>
<tr>
<th>Users Nominated</th>
</tr>";
while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['user'] . "</td>";
    echo "</tr>";
}
echo "</table>";

mysqli_close($db);
?>
        <br>
<div style="text-align: center; margin: 0 35%"><a class="buttonLink" href="vote.php" style="color:white; background-color:#8AA4CE">To Voting</a></div>
    </center>
</body>
