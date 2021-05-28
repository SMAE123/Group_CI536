<?php
// modify env.php with your values
require 'env.php';

$serverName = getenv('SERVER_NAME');
$username = getenv('USER_NAME');
$password = getenv('PASSWORD');
$dbName = getenv('DATABASE_NAME');

// Create connection
$conn = new mysqli($serverName, $username, $password, $dbName);
