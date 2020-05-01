<?php

  include_once "../functions.php";

  $sql    = "select temp, humidity from currenttemp";
  $result = db_fetcharray ("localhost", "greenhouse", "greenhouse","greenhouse", $sql);

  $temp     = $result[0]["temp"];
  $humidity = $result[0]["humidity"];
 
  print "var humidHTML = \"<h1>" . $humidity . "\%</h1>\";\n";

?>

