<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_manager";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // Set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // Set charset to utf8mb4 for emoji support
  $conn->exec("set names utf8mb4");
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  exit();
}
