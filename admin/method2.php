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
</head>
<h1>Method 2</h1>
<body>
<?php
require_once "mysql_config.php";

$result = mysqli_query($db, "SELECT * FROM votes");

$list1 = "";

while ($row = mysqli_fetch_array($result)) {
    echo strtolower(nl2br($row['candidate_one'].","));
    echo strtolower(nl2br($row['candidate_two'].","));
    echo strtolower(nl2br($row['candidate_three']." \r\n "));
}
$list = strtolower($list1);
echo $list;

mysqli_close($db);
?>
<br />
<a href="/home.php" class="btn btn-primary">Back to Admin Dashboard</a>