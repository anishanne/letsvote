<html lang="en">
<body background="background.jpeg">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="vote.css">
    <title>Let's Vote</title>
</head>
<?php
require_once "mysql_config.php";
$sql = "SELECT * FROM frontPageText WHERE 1";
$result = $db->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row["text"];
    }
} else {
    echo "0 results";
}
$db->close();


?>
<center><h1> Welcome to NUVoting.</h1></center>
<form action="vote.php">
    <div class="container">
        <button type="submit">Let's Vote</button>
    </div>
</form>
<form action="public_nominations.php">
    <div class="container">
        <button type="submit">Current Nominations</button>
    </div>
</form>
<form action="results.php">
    <div class="container">
        <button type="submit">View Results</button>
    </div>
</form>
<form action="log.php">
    <div class="container">
        <button type="submit">Log</button>
    </div>
</form>
<form action="home.php">
    <div class="container">
        <button type="submit">Admin Login</button>
    </div>
</form>
</html>