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
</head>
<body>
<div class="page-header">
</div>
<a href="/" class="btn btn-primary">Back to Home Page</a>
</body>
</html>
