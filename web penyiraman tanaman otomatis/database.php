<?php
$db = new Database();

class Database
{
  var $HOSTNAME = "sql104.epizy.com";
  var $USERNAME = "epiz_27718968";
  var $PASSWORD = "xJRAWLtSoWvEqV";
  var $DATABASE = "epiz_27718968_watering_system";

  var $connection;

  function __construct()
  {
    $this->connection = mysqli_connect($this->HOSTNAME, $this->USERNAME, $this->PASSWORD, $this->DATABASE);
    $this->initDB();
  }

  private function initDB()
  {
    $query = "SELECT * FROM `setting`";
    $data = mysqli_query($this->connection, $query);
    if (mysqli_num_rows($data) == 0) {
      $query = "INSERT INTO `setting` VALUES('8', '0', '0')";
      mysqli_query($this->connection, $query);
    }
  }

  function readData()
  {
    $query = "SELECT * FROM `datalog`";
    $data = mysqli_query($this->connection, $query);
    $hasil = null;
    while ($row = mysqli_fetch_array($data)) {
      $hasil[] = $row;
    }
    return $hasil;
  }

  function insertData($humidity, $date, $time)
  {
    $query = "INSERT INTO `datalog` VALUES('$humidity', '$date', '$time')";
    mysqli_query($this->connection, $query);
  }

  function deleteData()
  {
    $query = "TRUNCATE TABLE datalog";
    mysqli_query($this->connection, $query);
  }

  function setMode($mode, $state, $time)
  {
    $query = "UPDATE `setting`";
    if ($mode == "timer") {
      $query = "UPDATE `setting` SET `StateTimer` = '$state', `Time` = '$time'";
    } else if ($mode == "sensor") {
      $query = "UPDATE `setting` SET `StateHumidity` = '$state'";
    }
    mysqli_query($this->connection, $query);
  }

  function getMode()
  {
    $query = "SELECT * FROM `setting`";
    $data = mysqli_query($this->connection, $query);
    $hasil = null;
    while ($row = mysqli_fetch_array($data)) {
      $hasil = $row;
    }
    return $hasil;
  }
}
