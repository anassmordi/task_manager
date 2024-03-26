<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['username'])) {
  header('Location: signin.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $priority = $_POST['priority'];
  $dueDate = $_POST['due_date'];
  $categoryId = $_POST['category_id'];


  $stmt = $conn->prepare("UPDATE tasks SET title = :title, description = :description, priority = :priority, due_date = :due_date, category_id = :category_id WHERE id = :id");
  $stmt->bindParam(':id', $id);
  $stmt->bindParam(':title', $title);
  $stmt->bindParam(':description', $description);
  $stmt->bindParam(':priority', $priority);
  $stmt->bindParam(':due_date', $dueDate);
  $stmt->bindParam(':category_id', $categoryId);

  $stmt->execute();

  header('Location: index.php');
  exit();
}

// Fetch the task to be updated
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = :id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  $task = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Update Task</title>
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

  <div class="container mt-5 mb-3">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="card bg-dark">
          <div class="card-header bg-dark">
            <h3 class="title">Update Task</h3>
          </div>
          <div class="card-body bg-dark">
            <form action="update_task.php" method="POST">
              <input type="hidden" name="id" value="<?= $task['id']; ?>">
              <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= $task['title']; ?>" required>
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?= $task['description']; ?></textarea>
              </div>
              <div class="mb-3">
                <label for="priority" class="form-label">Priority</label>
                <select class="form-select" id="priority" name="priority" required>
                  <option value="Low" <?= $task['priority'] === 'Low' ? 'selected' : ''; ?>>Low</option>
                  <option value="Medium" <?= $task['priority'] === 'Medium' ? 'selected' : ''; ?>>Medium</option>
                  <option value="High" <?= $task['priority'] === 'High' ? 'selected' : ''; ?>>High</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="due_date" class="form-label">Due Date</label>
                <input type="date" class="form-control" id="due_date" name="due_date" value="<?= $task['due_date']; ?>" required>
              </div>
              <div class="mb-3">
                <label for="categorie_id" class="form-label">Category</label>
                <select class="form-select" id="categorie_id" name="category_id" required>
                  <?php
                  $stmt = $conn->prepare("SELECT * FROM categories");
                  $stmt->execute();
                  $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($categories as $category) {
                    $selected = ($category['id'] == $task['category_id']) ? 'selected' : '';
                    echo "<option value='{$category['id']}' $selected>{$category['name']}</option>";
                  }
                  ?>
                </select>
              </div>

              <button type="submit" class="btn btn-primary">Update Task</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>