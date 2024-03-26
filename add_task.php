<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['username'])) {
  header('Location: signin.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $priority = $_POST['priority'];
  $dueDate = $_POST['due_date'];
  $userId = $_SESSION['user_id'];

  $stmt = $conn->prepare("INSERT INTO tasks (title, description, priority, due_date, user_id) VALUES (:title, :description, :priority, :due_date, :user_id)");
  $stmt->bindParam(':title', $title);
  $stmt->bindParam(':description', $description);
  $stmt->bindParam(':priority', $priority);
  $stmt->bindParam(':due_date', $dueDate);
  $stmt->bindParam(':user_id', $userId);
  $stmt->execute();

  header('Location: index.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Add Task</title>
  <link rel="stylesheet" href="./css/add_task.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <span class="navbar-brand mb-0 h1 mx-auto"><a class="nav-link" href="./index.php">Task Manager</a></span>
      <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header bg-dark">
          <h5 class="offcanvas-title text-white" id="offcanvasNavbarLabel">Menu</h5>
          <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body bg-dark">
          <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link" href="./add_task.php">Add Task</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./add_categorie.php">Add Category</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php" style="color: red;">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="card bg-dark">
          <div class="card-header bg-dark">
            <h3 class="title">Add Task</h3>
          </div>
          <div class="card-body bg-dark">
            <form action="add_task.php" method="POST">
              <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
              </div>
              <div class="mb-3">
                <label for="priority" class="form-label">Priority</label>
                <select class="form-select" id="priority" name="priority" required>
                  <option value="Low">Low</option>
                  <option value="Medium">Medium</option>
                  <option value="High">High</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="due_date" class="form-label">Due Date</label>
                <input type="date" class="form-control" id="due_date" name="due_date" required>
              </div>
              <button type="submit" class="btn btn-primary">Add Task</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>