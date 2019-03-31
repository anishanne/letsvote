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

    <title>Welcome</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="admin.css">
    <style type="text/css">
        body {
            font: 20px sans-serif;
            text-align: left;
        }
        body{
            background-size: cover !important;
            color: white
        }

    </style>
</head>
<body>
<center>
    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to the admin panel.</h1>
    </div>
</center>
<form action="logout.php">
    <div style="text-align: center;"><a class="buttonLink3" href="/gen_code.php">Generate Code</a> <a class="buttonLink3" href="/delete_code.php">Delete Code</a> <a class="buttonLink3" href="/reset_code.php">Reset A Code</a></div>
    <br>
    <div style="text-align: center;"><a class="buttonLink3" href="/nominate.php">Nominate A Person</a> <a class="buttonLink3" href="/delete_nomination.php">Delete A Nomination</a> <a class="buttonLink3" href="/current_nominations.php">View Current Nominations</a></div>
    <br><br>
    <div style="text-align: center;"><a class="buttonLink2" href="/admin_results.php">View Results</a> <a class="buttonLink2" href="/countSTV.php">Tabulate Results</a></div>
    <br>
    <div style="text-align: center;"><a class="buttonLink2" href="/stop_voting.php">Stop/Start Voting</a> <a class="buttonLink2" href="/reset_election.php">Reset Election</a></div>
    <br>
    <div style="text-align: center;"><a class="buttonLink2" href="/front_text.php">Change Front Page Text</a> <a class="buttonLink2" href="/reset_password.php">Reset Your Password</a></div>
    <br>
    <div style="text-align: center;"><a class="buttonLink2" href="/homepage.php">Go To Home Page</a> <a class="buttonLink2" href="/logout.php">Logout</a></div>
    <br><br>



</form>
<!--<p><a href="gen_code.php" class="btn btn-danger"> Generate a Code </a> This will generate a new code, be sure to click
    generate first.<br/><br/><br/>
    <a href="delete_code.php" class="btn btn-danger"> Disable a Code </a> This will deactivate a code.<br/><br/><br/>
    <a href="reset_code.php" class="btn btn-danger"> Reset a Code </a> This will allow the code to be used to vote
    again.<br/><br/><br/>

    <a href="nominate.php" class="btn btn-warning"> Nominate A Person </a> This will allow to nominate people for the
    next election.<br/><br/><br/>
    <a href="delete_nomination.php" class="btn btn-warning"> Delete a Nomination </a> This will allow to remove
    nominations from the next election.<br/><br/><br/>
    <a href="current_nominations.php" class="btn btn-warning"> View Current Nominations </a> This will allow to view
    nominations for the next election.<br/><br/><br/>

    <a href="admin_results.php" class="btn btn-success"> View Results </a> This will allow to view
    the results for the elction with the voting codes.<br/><br/><br/>
    <a href="countSTV.php" class="btn btn-success"> Tabulate Results </a> This will take you to a page to count the results.<br/><br/><br/>
    <a href="stop_voting.php" class="btn btn-success"> Stop/Start Voting </a> This will stop/start voting.<br/><br/><br/>
    <a href="reset_election.php" class="btn btn-success"> Reset Election </a> WARNING: This command can not be reversed.<br/><br/><br/>

    <a href="front_text.php" class="btn btn-primary"> Change Front Page Text </a> This is to change the text on the front page.<br/><br/><br/>
    <a href="reset_password.php" class="btn btn-primary"> Reset Your Password </a> This is to reset your
    password.<br/><br/><br/>
    <a href="logout.php" class="btn btn-primary">Sign Out of Your Account</a> This is to logout.<br/><br/><br/><br/>
    <a href="/" class="btn btn-primary">Back to Home Page</a></p>-->

</body>
</html>
