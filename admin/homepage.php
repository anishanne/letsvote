<html lang="en">
<body background="background.jpeg">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/admin.css">
    <title>Let's Vote</title>
    <style type="text/css">
        body{
            background-size: cover !important;
            color: white
        }
    </style>

</head>

<center><h1> Welcome to NUVoting.</h1>
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
</center>
<br>
<br>
<br>
<font size="+2">
<form action="home.php">
    <div style="text-align: center;"><a class="buttonLink2" href="/vote.php">Let's Vote</a> <a class="buttonLink2" href="/public_nominations.php">Current Nominations</a></div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div style="text-align: center;"><a class="buttonLink2" href="/results.php">View Results</a> <a class="buttonLink2" href="/log.php">View The Log</a></div>
    <br>
    <br>
    <br>
    <br>
    <div style="text-align: center;"><a class="buttonLink" href="/home.php">Admin Login</a></div>
</form>
</font>
</html>