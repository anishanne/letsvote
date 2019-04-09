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
<div class="topbar">
    <a href="/homepage.php" style="color:white; text-decoration: none;">< Back to Homepage</a>
</div>
<body>
<center><h2 style="font-size:36px;">Action Log</h2>
<?php
require_once "mysql_config.php";

$result = mysqli_query($db, "SELECT * FROM log");

echo "<table border='1'>
<tr>
<th>User</th>
<th>Action</th>
</tr>";
while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['user'] . "</td>";
    echo "<td>" . $row['action'] . "</td>";
    echo "</tr>";
}
echo "</table>";

mysqli_close($db);
?>
</body>
</html>


