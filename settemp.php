<?php

  include "functions.php";

  while (1) {
    $temp = exec ("/RPitools/temputil");
    $fan1 = exec ("/usr/bin/gpio read 24");
    $fan2 = exec ("/usr/bin/gpio read 25");
    $mist = exec ("/usr/bin/gpio read 22");
    $heat1 = exec ("/usr/bin/gpio read 23");
    $heat2 = exec ("/usr/bin/gpio read 27");
    $dtime = time ();

    $tvars = explode (",", $temp);

    print "Temp is: " . $tvars[0] . "F Humidity is: " . $tvars[1] . "% Fan1: " . $fan1 . " Fan2: " . $fan2 . " Mist: " . $mist . "\n";

    if ($tvars[0] < 40) {
      exec ("/usr/bin/gpio mode 23 out");
      exec ("/usr/bin/gpio write 23 1");
      $heat1 = 1;
    } else
      exec ("/usr/bin/gpio write 23 0");

    if ($tvars[0] < 35) {
      exec ("/usr/bin/gpio mode 27 out");
      exec ("/usr/bin/gpio write 27 1");
      $heat2 = 1;
    } else
      exec ("/usr/bin/gpio write 27 0");

    if ($tvars[0] > 80) {
      exec ("/usr/bin/gpio mode 24 out");
      exec ("/usr/bin/gpio write 24 1");
      $fan1 = 1;
    } else
      exec ("/usr/bin/gpio write 24 0");

    if ($tvars[0] > 90) {
      exec ("/usr/bin/gpio mode 25 out");
      exec ("/usr/bin/gpio write 25 1");
      $fan2 = 1;
    } else
      exec ("/usr/bin/gpio write 25 0");

    if ($tvars[1] < 40) {
      if ($fan1 == 0) {
        exec ("/usr/bin/gpio mode 24 out");
        //exec ("/usr/bin/gpio write 24 1");
      }
      exec ("/usr/bin/gpio mode 22 out");
      exec ("/usr/bin/gpio write 22 1");
      $mist = 1;
      sleep (10);
      exec ("/usr/bin/gpio write 22 0");
      if ($fan1 == 0)
        exec ("/usr/bin/gpio write 24 0");
    } else
      exec ("/usr/bin/gpio write 22 0");

    $sql = "insert into temphistory (dtime, temp, humidity, fanstate) values ($dtime, $tvars[0], $tvars[1], $fan1)";
    db_execute ("localhost", "greenhouse", "greenhouse","greenhouse", $sql);

    $sql = "update currenttemp set temp=" . $tvars[0] . ", humidity=" . $tvars[1] . ", fanstate=$fan1";
    db_execute ("localhost", "greenhouse", "greenhouse","greenhouse", $sql);

    sleep (60);

  }

?>

