<?php
session_start();

if (!isset($_SESSION['login']))
  header("Location: login.php");
if (!$_SESSION['login'])
  header("Location: login.php");

include "database.php";

$dataSetting = $db->getMode();
$dataLog = $db->readData();

$time = $dataSetting['Time'];
$stateTimer = $dataSetting['StateTimer'];
$stateHumidity = $dataSetting['StateHumidity'];

function formattingDate($date)
{
  $result = date("d-m-Y", strtotime($date));
  return $result;
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
      <div class="top mb-5">
        <h3>Mode</h3>
        <form class="m-2" action="process.php" method="POST">
          <div class="row g-3 align-items-center">
            <div class="col-auto">
              <label class="col-form-label">Timer (hour) : </label>
            </div>
            <div class="col-auto">
              <input type="number" min="1" class="form-control" style="width: 100px;" name="time" value="<?= $time ?>">
            </div>
            <div class="col-auto">
              <div class="btn-group">
                <?php
                $stateText = ($stateTimer == 1) ? "Aktif" : "Tidak Aktif";
                $state1 = ($stateTimer == 1) ? "active" : "";
                $state2 = ($stateTimer == 0) ? "active" : "";
                ?>
                <button class="btn btn-dark btn-sm dropdown-toggle" type="button" id="modeTimer" data-bs-toggle="dropdown" aria-expanded="false">
                  <?= $stateText ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="modeTimer">
                  <li><input type="submit" class="dropdown-item <?= $state1 ?>" value="Aktif" name="aktifTimer"></input></li>
                  <li><input type="submit" class="dropdown-item <?= $state2 ?>" value="Tidak Aktif" name="aktifTimer"></input></li>
                </ul>
              </div>
            </div>
          </div>
        </form>
        <form class="m-2" action="process.php" method="POST">
          <div class="row g-3 align-items-center">
            <div class="col-auto">
              <label class="col-form-label">Sensor : </label>
            </div>
            <div class="col-auto">
              <div class="btn-group">
                <?php
                $stateText = ($stateHumidity == 1) ? "Aktif" : "Tidak Aktif";
                $state1 = ($stateHumidity == 1) ? "active" : "";
                $state2 = ($stateHumidity == 0) ? "active" : "";
                ?>
                <button class="btn btn-dark btn-sm dropdown-toggle" type="button" id="modeSensor" data-bs-toggle="dropdown" aria-expanded="false">
                  <?= $stateText ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="modeSensor">
                  <li><input type="submit" class="dropdown-item <?= $state1 ?>" value="Aktif" name="aktifSensor"></input></li>
                  <li><input type="submit" class="dropdown-item <?= $state2 ?>" value="Tidak Aktif" name="aktifSensor"></input></li>
                </ul>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="bottom" style="width: 60%; margin:auto;">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
          <form action="process.php" method="POST">
            <input type="submit" class="btn btn-danger" value="Clear All Data" name="clear">
          </form>
        </div>
        <table class="text-center table table-dark table-striped table-sm mx-auto">
          <thead>
            <th>Humidity</th>
            <th>Date</th>
            <th>Time</th>
          </thead>
          <tbody>
            <?php
            if ($dataLog != null) {
              foreach ($dataLog as $item) {
            ?>
                <tr>
                  <td><?= $item['Humidity'] ?></td>
                  <td><?= formattingDate($item['Date']) ?></td>
                  <td><?= $item['Time'] ?></td>
                </tr>
              <?php
              }
            } else {
              ?>
              <tr>
                <td colspan="3">Tidak Ada Data</td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>