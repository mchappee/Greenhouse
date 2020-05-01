<?php

  include_once "../functions.php";

  $now = time ();
  $range = $now - (86400);
  $json = "";

  $sql    = "select temp, humidity, fanstate, dtime from temphistory where dtime > $range";
  $result = db_fetcharray ("localhost", "greenhouse", "greenhouse","greenhouse", $sql);


  foreach ($result as $record) {
    $temp     = $record["temp"];
    $humidity = $record["humidity"];
    $fanstate = $record["fanstate"] * 20;
    $dtime    = $record["dtime"];
    
    $hour = date ("h:i:sA", $dtime);
    $json = $json . "{\"hour\": \"" . $hour . "\",\n";
    $json = $json . "\"temp\": " . $temp . ",\n";
    $json = $json . "\"humidity\": " . $humidity . ",\n";
    $json = $json . "\"fanstate\": " . $fanstate . "},\n";
  }

  $json = "[" . trim ($json) . "]";
  print "\nvar tempdata = " . $json . ";\n";

?>

