<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['username'])) {
  header('Location: signin.php');
  exit();
}

if (isset($_GET['id'])) {
  $taskId = $_GET['id'];
  $stmt = $conn->prepare("UPDATE tasks SET completed = 'Yes' WHERE id = :taskId");
  $stmt->bindParam(':taskId', $taskId);
  $stmt->execute();

  header('Location: index.php');
  exit();
} else {
  echo "Task ID not provided.";
}
