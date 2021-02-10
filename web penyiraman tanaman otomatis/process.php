<?php
include "database.php";

if (isset($_POST['aktifTimer'])) {
  $time = $_POST['time'];
  $state = ($_POST['aktifTimer'] == "Aktif") ? 1 : 0;

  $db->setMode("timer", $state, $time);
}

if (isset($_POST['aktifSensor'])) {
  $state = ($_POST['aktifSensor'] == "Aktif") ? 1 : 0;

  $db->setMode("sensor", $state, "");
}

if (isset($_POST['clear'])) {
  $db->deleteData();
}

header("Location: index.php");
