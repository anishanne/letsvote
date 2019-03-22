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

<?php
    session_start();

    if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
        header("location: home.php");
        exit;
    } ?>
<!DOCTYPE html>
<html lang="en">
<body background="background.jpeg">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="stylesheet" type="text/css" href="vote.css">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <title>Vote</title>
</head>

<body>
<?php
    require_once "../system/mysql_config.php";

    $result = mysqli_query($db, "SELECT * FROM votes");

    echo "<table border='1'>
<tr>
<th>Voting Code</th>
<th>First Choice For Mod/Admin</th>
<th>Second Choice For Mod/Admin</th>
<th>Third Choice For Mod/Admin</th>
</tr>";

    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $row['vote_code'] . "</td>";
        echo "<td>" . $row['candidate_one'] . "</td>";
        echo "<td>" . $row['candidate_two'] . "</td>";
        echo "<td>" . $row['candidate_three'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    mysqli_close($db);
?>
<a href="home.php" class="btn btn-primary">Back to Admin Dashboard</a>
</body>

</html>

