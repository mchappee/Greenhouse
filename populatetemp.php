<?php

  include "../functions.php";

  $sql    = "select temp, humidity, fanstate from currenttemp";
  $result = db_fetcharray ("localhost", "greenhouse", "greenhouse","greenhouse", $sql);

  $temp     = $result[0]["temp"];
  $humidity = $result[0]["humidity"];
  $fanstate = $result[0]["fanstate"];
 
  if ($fanstate)
    $color="red";
  else
    $color="blue";

  print "var tempHTML = \"<p style='font-size:200%;font-weight:bold;line-height: 0.6;'>$temp °</p><p style='line-height: 0.6;font-size:125%;font-weight:bold;color:" . $color . ";'>Fan Kick-on Temp: 90°</p>\";";

?>

