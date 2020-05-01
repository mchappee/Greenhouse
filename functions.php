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

?>

