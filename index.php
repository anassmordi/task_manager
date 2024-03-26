<?php
session_start();
// require_once 'db.php';

if (!isset($_SESSION['username'])) {
  header('Location: signin.php');
  exit();
}

// $username = $_SESSION['username'];
// $stmt = $conn->prepare("SELECT t.id, t.title, t.description, t.priority, t.due_date, t.completed FROM tasks t JOIN users u ON u.id = t.user_id WHERE u.username = :username ORDER BY t.completed DESC");
// $stmt->bindParam(':username', $username);
// $stmt->execute();
// $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Task List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="./css/indexPage.css">
</head>

<body>
  <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">

      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <span class="navbar-brand mb-0 h1 mx-auto">Task Manager</span>
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
              <a class="nav-link" href="./add_categorie.php">Add Categorie</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php" style="color: red;">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <section class="">
    <div class="container py-5 h-100 ms-5">
      <div class="row d-flex justify-content-center align-items-start h-100">
        <div class="col-md-12 col-xl-10">

          <div class="card-body p-4 text-white">
            <div class="text-center pt-3 pb-2">
              <h2 class="my-4 title">Task List</h2>
            </div>
            <table class="table table-dark text-white mb-0">
              <thead>
                <tr>
                  <th scope="col">Task</th>
                  <th scope="col">Priority</th>
                  <th scope="col">Description</th>
                  <th scope="col">Due Date</th>
                  <th scope="col">Completion status</th>
                  <th scope="col">Category</th>
                  <th scope="col"></th>
                  <th scope="col"></th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    function reloadTasks() {
      $.ajax({
        url: 'reload_tasks.php',
        type: 'GET',
        success: function(data) {
          var tasks = JSON.parse(data);
          var tableBody = document.querySelector('tbody');
          if (tableBody) {
            tableBody.innerHTML = '';
            tasks.forEach(function(task) {
              var priorityClass = 'badge bg-success';
              var priorityText = 'Low priority';
              if (task.priority === 'Medium') {
                priorityClass = 'badge bg-warning text-dark';
                priorityText = 'Medium priority';
              } else if (task.priority === 'High') {
                priorityClass = 'badge bg-danger';
                priorityText = 'High priority';
              }

              var completionClass = task.completed === 'yes' ? 'bg-success' : 'bg-danger';

              var row = '<tr class="fw-normal">' +
                '<td class="align-middle">' + task.title + '</td>' +
                '<td class="align-middle"><h6 class="mb-0"><span class="' + priorityClass + '">' + priorityText + '</span></h6></td>' +
                '<td class="align-middle">' + task.description + '</td>' +
                '<td class="align-middle">' + task.due_date + '</td>' +
                '<td class="align-middle"><span class="badge ' + completionClass + '">' + task.completed + '</span></td>' +
                '<td class="align-middle">' + task.name + '</td>' +
                '<td class="align-middle"><a href="complete_task.php?id=' + task.id + '" data-mdb-toggle="tooltip" title="Completed"><i class="fas fa-check fa-lg text-success me-3"></i></a></td>' +
                '<td class="align-middle"><a href="delete_task.php?id=' + task.id + '" data-mdb-toggle="tooltip" title="Remove"><i class="fas fa-trash-alt fa-lg text-warning me-3"></i></a></td>' +
                '<td class="align-middle"><a href="update_task.php?id=' + task.id + '" data-mdb-toggle="tooltip" title="Remove"><i class="fas fa-pencil-alt fa-lg text-warning me-3"></i></a></td>' +
                '</tr>';
              tableBody.innerHTML += row;
            });
          } else {
            console.error('Table body not found');
          }
        },
        error: function(xhr, status, error) {
          console.error('AJAX request failed:', status, error);
        }
      });
    }


    $(document).ready(function() {
      reloadTasks(); // Load tasks on page load
      setInterval(reloadTasks, 3000); // Refresh tasks every 5 seconds
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var priorities = document.querySelectorAll('.priority');

      priorities.forEach(function(priority) {
        var priorityValue = priority.textContent.trim();
        var priorityClass = 'text-success'; // Default color

        if (priorityValue === 'Medium') {
          priorityClass = 'text-warning';
        } else if (priorityValue === 'High') {
          priorityClass = 'text-danger';
        }

        priority.classList.add(priorityClass);
      });
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>