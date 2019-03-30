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
<!DOCTYPE html>
<html lang="en">
<body background="background.jpeg">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body {
            font: 14px sans-serif;
            text-align: center;

        }
    </style>
    <style type="text/css">
        body{
            background-size: cover !important;
            color: white
        }
    </style>
</head>
<body>
<div class="page-header">
</div>
<a href="/" class="btn btn-primary">Back to Home Page</a>
<a href="vote.php" class="btn btn-primary">I'm ready to vote!</a>
</body>
</html>
