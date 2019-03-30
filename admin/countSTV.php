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
<h1>STV Counter</h1>
<br>
<a href="/method1.php" class="btn btn-primary">Method 1</a> 1 candidate per line, empty line between votes. This method has an automated  counter built in.<br><br>
<a href="/method2.php" class="btn btn-primary">Method 2</a> 1 vote per line, candidates separated by commas.<br><br>
<a href="/method3.php" class="btn btn-primary">Method 3 - Not Working Right Now</a> CSV File, 1 vote per line, 1 candidate per column. No Voting Codes. <br><br>
<br>
<br>
<a href="/home.php" class="btn btn-primary">Back to Admin Dashboard</a>
</body>

</html>

