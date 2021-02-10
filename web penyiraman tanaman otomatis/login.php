<?php
if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if ($username == "finawira" && $password == "finawira123") {
    session_start();
    $_SESSION['login'] = TRUE;
    header("Location: index.php");
  } else {
    header("Location: login.php");
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Penyiram Tanaman Otomatis</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>

<body class="bg-info">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="index.php">Penyiram Tanaman Otomatis</a>
    </div>
  </nav>

  <main class="container p-5">
    <div class="container">
      <div class="top mb-5" style="width: 50%; margin:auto;">
        <form action="login.php" method="POST">
          <div class="mb-3">
            <legend>Login</legend>
          </div>
          <div class="mb-3">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" required>
          </div>
          <div class="mb-3">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" required>
          </div>
          <div class="mb-3">
            <div class="d-grid gap-2 col-6 mx-auto">
              <input type="submit" class="btn btn-primary" name="submit" value="Login">
            </div>
          </div>
        </form>
      </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>