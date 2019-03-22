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
    $result = mysqli_query($db, "SELECT * FROM candidates");

    echo "<table border='1'>
<tr>
<th>Users Nominated</th>
</tr>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $row['user'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    mysqli_close($db);
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
            text-align: center;

        }
    </style>
</head>
<body>
<div class="page-header">
</div>
<a href="/" class="btn btn-primary">Back to Home Page</a>
<a href="vote.php" class="btn btn-primary">I'm ready to vote!</a>
</body>
</html>
