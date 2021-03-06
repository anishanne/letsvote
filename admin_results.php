<?php
session_start();

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: home.php");
    exit;
}?>
<!DOCTYPE html>
<html lang="en">
<body background="background.jpeg">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="stylesheet" type="text/css" href="vote.css">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <title>Vote</title>
    <style type="text/css">
        body{
            background-size: cover !important;
            color: white
        }
    </style>
</head>

<body>
<?php
require_once "mysql_config.php";

$result = mysqli_query($db, "SELECT * FROM votes");

echo "<table border='1'>
<tr>
<th>Voting Code</th>
<th>First Choice For Mod/Admin</th>
<th>Second Choice For Mod/Admin</th>
<th>Third Choice For Mod/Admin</th>
</tr>";

while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['vote_code'] . "</td>";
    echo "<td>" . $row['candidate_one'] . "</td>";
    echo "<td>" . $row['candidate_two'] . "</td>";
    echo "<td>" . $row['candidate_three'] . "</td>";
    echo "</tr>";
}
echo "</table>";

mysqli_close($db);
?>
<a href="home.php" class="btn btn-primary">Back to Admin Dashboard</a>
</body>

</html>

