<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="admin.css">
    <title>Let's Vote</title>
    <style type="text/css">
        body{
            background-color: white;
            color: #54575B;
        }
    </style>

</head>
<div class="topbar" style="text-align: right">
  <a href="login.php" style="color: white; text-decoration:none;">
      Admin Login >
      </a>
</div>
<center><div class="header"> Welcome to NUVoting.</div>
<br>
<br>
    <?php
    require_once "mysql_config.php";
    $sql = "SELECT * FROM frontPageText WHERE 1";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row1
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
<font size="+2">
<form action="home.php">
    <div style="text-align: center; margin: 0 25%;"><a class="buttonLink" href="vote.php" style="color:white; background-color: #002C73;">Let's Vote</a></div>
    <br>
    <br>
    <div style="text-align: center;"><a class="buttonLink2" href="public_nominations.php">Current Nominations</a> <a class="buttonLink2" href="results.php">View the Results</a></div>
    <br>
    <br>
    <div style="text-align: center; margin: 0 25%;"><a class="buttonLink" href="log.php">View the Action Log</a></div>
</form>
</font>
</html>
