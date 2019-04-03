
<!DOCTYPE html>
<html lang="en">
<body>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="stylesheet" type="text/css" href="vote.css">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <title>Vote</title>
    <style type="text/css">
        body{
            background-size: cover !important;
            color: black
        }
    </style>
</head>
<h1>Method 1</h1>
Copy everything below and go the the STV Counter.
<br>
<body>
<?php
require_once "mysql_config.php";

$result = mysqli_query($db, "SELECT * FROM votes");

$list1 = "";

while ($row = mysqli_fetch_array($result)) {
    echo strtolower(nl2br($row['candidate_one']." \r\n "));
    echo strtolower(nl2br($row['candidate_two']."\r\n "));
    echo strtolower(nl2br($row['candidate_three']." \r\n \r\n "));
}
$list = strtolower($list1);
echo $list;

mysqli_close($db);
?>
<a href="/homepage.php" class="btn btn-primary">Back to Home Page</a>   <a href="/public_stvcounter.html" class="btn btn-primary">To STV Counter</a>
