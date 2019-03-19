<?php
session_start();

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location: login.php");
    exit;
}
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
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Nerds United Election Rules.<br/></h1>
        <h3>By voting an any NU Election, you agree to the following rules.<br/><br/></h3>
        <p>
            - I am using the voting code PMed to me by an admin/mod, and not any other voting code.<br/><br/>
            - I may vote for myself.<br/><br/>
            - I may not put the same user in multiple choice spots.<br/><br/>
            - I may not change my vote after I have voted .<br/><br/>
            - If I misclick, I may report voting errors in the voting errors thread in NU, after which my code will be reset
        </p>
    </div>

<p></p>
</body>
</html>
