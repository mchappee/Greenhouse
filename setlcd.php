<?php

  function db_execute ($host, $user, $pw, $db, $sql) {
    $conn = new mysqli($host, $user, $pw, $db);
    if (!$conn)
      die ("Cannot connect to database");

    $result = $conn->query ($sql) or die('Query failed: ' . $conn->errno);

    $conn->close();
  }

  function db_fetcharray ($host, $user, $pw, $db, $sql) {

    $returnval = NULL;

    $conn = new mysqli($host, $user, $pw, $db);
    if (!$conn)
      die ("Cannot connect to database");

    $result = $conn->query($sql);

    $a = 0;
    while ($line = $result->fetch_assoc()) {
      $returnval[$a] = $line;
      $a++;
    }

    $conn->close();

    return $returnval;
  }

  

  while (1) {

    $sql    = "select temp, humidity from currenttemp";
    $result = db_fetcharray ("localhost", "greenhouse", "greenhouse","greenhouse", $sql);  

    $temp     = $result[0]["temp"];
    $humidity = $result[0]["humidity"];
    $lcdtemp = "";
    $lcdh = "";

    $temparray = $result = str_split($temp);
    foreach ($temparray as $number)
      $lcdtemp = $lcdtemp . $number . " ";

    switch (strlen ($temp)) {
      case 1:
        $lcdtemp = $lcdtemp . "15 16 16";
        break;
      case 2:
        $lcdtemp = $lcdtemp . "15 16";
        break;
      case 3:
        $lcdtemp = $lcdtemp . "15";
        break;
    }

    $harray = $result = str_split($humidity);
    foreach ($harray as $number)
      $lcdh = $lcdh . $number . " ";

    switch (strlen ($humidity)) {
      case 1:
        $lcdh = $lcdh . "24 16 16";
        break;
      case 2:
        $lcdh = $lcdh . "24 16";
        break;
      case 3:
        $lcdh = $lcdh . "24";
        break;
    }

    exec ("/RPitools/lcd " . $lcdtemp); 
    sleep (5);
    exec ("/RPitools/lcd " . $lcdh);
    sleep (5);

  }

?>

