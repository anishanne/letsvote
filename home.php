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
<center>
    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to the admin panel.</h1>
    </div>
</center>
<p><a href="gen_code.php" class="btn btn-primary"> Generate a Code </a> This will generate a new code, be sure to click
    generate first.<br/><br/><br/>
    <a href="delete_code.php" class="btn btn-primary"> Disable a Code </a> This will deactivate a code.<br/><br/><br/>
    <a href="reset_code.php" class="btn btn-primary"> Reset a Code </a> This will allow the code to be used to vote
    again.<br/><br/><br/>
    <a href="stop_voting.php" class="btn btn-primary"> Stop/Start Voting </a> This will stop/start voting.<br/><br/><br/>
    <a href="admin_results.php" class="btn btn-primary"> View Results </a> This will allow to view
    the results for the elction with the voting codes.<br/><br/><br/>
    <a href="nominate.php" class="btn btn-danger"> Nominate A Person </a> This will allow to nominate people for the
    next election.<br/><br/><br/>
    <a href="delete_nomination.php" class="btn btn-danger"> Delete a Nomination </a> This will allow to remove
    nominations from the next election.<br/><br/><br/>
    <a href="current_nominations.php" class="btn btn-danger"> View Current Nominations </a> This will allow to view
    nominations for the next election.<br/><br/><br/>
    <a href="front_text.php" class="btn btn-warning"> Change Front Page Text </a> This is to change the text on the front page.<br/><br/><br/>
    <a href="reset_election.php" class="btn btn-warning"> Reset Election </a> WARNING: This command can not be reversed.<br/><br/><br/>
    <a href="reset_password.php" class="btn btn-warning"> Reset Your Password </a> This is to reset your
    password.<br/><br/><br/>
    <a href="logout.php" class="btn btn-warning">Sign Out of Your Account</a> This is to logout.<br/><br/><br/><br/>
    <a href="/" class="btn btn-warning">Back to Home Page</a></p>
</body>
</html>
