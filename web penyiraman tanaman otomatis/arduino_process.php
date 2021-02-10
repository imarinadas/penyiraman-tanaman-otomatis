<?php
include "database.php";

if (isset($_GET['humidity'])) {
  date_default_timezone_set('Asia/Jakarta');
  $humidity = $_GET['humidity'];
  $date = date("Y-m-d");
  $time = date("H:i");

  $db->insertData($humidity, $date, $time);
}

if (isset($_GET['mode'])) {
  $mode = $db->getMode();
  echo $mode['StateTimer'] . "=" . $mode['StateHumidity'] . "=" . $mode['Time'];
}
