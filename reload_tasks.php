<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['username'])) {
  header('Location: signin.php');
  exit();
}

$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT t.id, t.title, t.description, t.priority, t.due_date, t.completed, t.date_created, c.name
FROM tasks t 
JOIN users u ON u.id = t.user_id
LEFT JOIN categories c ON c.id = t.category_id
WHERE u.username = :username 
ORDER BY t.completed DESC , t.date_created DESC");
$stmt->bindParam(':username', $username);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($tasks);
