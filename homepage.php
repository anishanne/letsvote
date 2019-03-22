<!--
    letsvote - STV voting system
    Copyright (C) 2019 anishanne

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
-->

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
        while ($row = $result->fetch_assoc()) {
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