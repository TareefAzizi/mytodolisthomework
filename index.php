<?php

$database = new PDO('mysql:host=devkinsta_db;dbname=mytodolisthomework', 'root', 'viLXjKTLEziaMJLz');



$query = $database->prepare('SELECT * FROM students');
$query->execute();


//Global Variables
// $_GET
// $_POST
// $_REQUEST
// $_SERVER
// var_dump($_POST['student']);
$students = $query->fetchAll();

if (
  $_SERVER['REQUEST_METHOD'] == 'POST'
) {
  if ($_POST['action'] == 'add') {

      $statement = $database->prepare(
          'INSERT INTO students (name)
          VALUES (:name)'
      );
      $statement->execute([
          'name' => $_POST['student']
      ]);
      header('Location: /');
      exit;
  }
  if ($_POST['action' ] == 'delete'){
    $statement = $database -> prepare(
      'DELETE FROM students WHERE id = :id'
    );
    $statement->execute([
      'id' => $_POST['student_id']
    ]);
    header('Location: /');
    exit;
  }

  if ($_POST ['action']=='correct'){
    if ($_POST['student_complete'] == 0) {
      $statement = $database->prepare(
        'UPDATE students SET complete = 1 WHERE id = :id'
      );
      $statement->execute([
        'id' => $_POST['student_id']
      ]);
      header('Location: /');
      exit;
    } if ($_POST['student_complete'] == 1)  {
      $statement = $database -> prepare(
        'UPDATE students SET complete = 0 WHERE id = :id'
      );

      $statement->execute([
        'id' => $_POST ['student_id']
      ]);
      header('Location: /');
      exit;
    }
  }
}
?>

<!DOCTYPE html>
    <html>
      <head>
        <title>TODO App</title>
        <link
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
          crossorigin="anonymous"
        />
        <link
          rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
        />
        <style type="text/css">
          body {
            background: #F1F1F1;
          }
        </style>
      </head>
      <body>
        <div
          class="card rounded shadow-sm"
          style="max-width: 500px; margin: 60px auto;"
        >


          <div  class="card-body">
            <h3 class="card-title mb-3">My Todo List</h3>
              <ul class="list-group">
              <?php foreach ($students as $student): ?>

                <li
                class="list-group-item d-flex justify-content-between align-items-center"
              >

                  <div class="d-flex">
                    <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                    <input
                      type="hidden"
                      name="student_id"
                      value="<?php echo $student['id'];?>"
                    />

                    <input
                      type="hidden"
                      name="student_complete"
                      value="<?php echo $student['complete'];?>"
                    />

                    <input
                      type="hidden"
                      name="action"
                      value="correct"
                    />

                    <?php if($student['complete'] == 1):?>
                      <button class="btn btn-sm btn-success">
                        <i class="bi bi-check-square"></i>
                      </button>
                    <?php else:?>
                      <button class="btn btn-sm">
                        <i class="bi bi-square"></i>
                      </button>
                    <?php endif;?>
                    </form>
                    <span class="ms-2 "><?php echo $student['name']?></span>
                  </div>
                  <div>

                    <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                    <input
                      type="hidden"
                      name="student_id"
                      value=" <?php echo $student['id'];?>"
                    />
                    <input
                      type="hidden"
                      name="action"
                      value="delete"
                    />
                    <button class="btn btn-sm btn-danger">
                      <i class="bi bi-trash"></i>
                    </button>
                    </form>
                  </div>
                </li>
              <?php endforeach;?>


              </ul>
              <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <div class="mt-4 d-flex justify-content-between align-items-center">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Add new item..."
                    name="student"
                    required
                  />

                  <input
                    type="hidden"
                    name="action"
                    value="add"
                  />

                  <button class="btn btn-primary btn-sm rounded ms-2">Add</button>
                </div>
            </form>
          </div>
        </div>
        <script
          src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
          crossorigin="anonymous"
        ></script>
    </body>
  </html>
