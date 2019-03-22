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
