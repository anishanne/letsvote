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
    define('DB_SERVER', 'localhost:3306');
    define('DB_USERNAME', 'username');
    define('DB_PASSWORD', 'password');
    define('DB_DATABASE', 'database');
    $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if ($db === false)
        die("Uh-oh, MySQL connection error: " . mysqli_connect_error());