<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['username'])) {
  header('Location: signin.php');
  exit();
}

if (isset($_GET['id'])) {
  $taskId = $_GET['id'];

  $stmt = $conn->prepare("DELETE FROM tasks WHERE id = :id");
  $stmt->bindParam(':id', $taskId);
  $stmt->execute();
}

header('Location: index.php');
exit();
