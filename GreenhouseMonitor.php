<?php

  $psflag  = false;
  $flagpid = 0;

  function fork_off ($loghandle, $command) {
    fwrite ($loghandle, "Restarting process " . $command . "\n");
    $pid = pcntl_fork ();
    if ($pid == -1) {
      die('could not fork');
    } else {
       if ($pid == 0) {
         exec ($command);
         exit (0);
       }
    }

    return $pid;
  }

  function CheckStuckProcess ($loghandle) {
    global $psflag, $flagpid;

    $ps = "ps -eo pid,start,args | grep /RPitools/temputil | grep -v grep | grep -v sh";

    $psresult = exec ($ps);

    if ($psresult) {
      $psarray = explode (" ", $psresult);
      if (strstr ($psarray[1], ":"))
        $pspid = trim ($psarray[0]);
      else
        $pspid = trim ($psarray[1]);

      print_r ($psarray);

      fwrite ($loghandle, "temputil process found at pid -" . $pspid . "- $psflag $flagpid\n");

      if ($psflag && $flagpid == $pspid) {
        fwrite ($loghandle, "temputil process stuck, killing pid " . $pspid . "\n");
        posix_kill ($pspid, SIGKILL);
        sleep (1);
        $psflag = false;
        $flagpid = 0;
      } else if ($flagpid == $pspid) {
        $flagpid = $pspid;
        $psflag = true;
      } else
        $psflag = false;
    }
  }

  function CheckLCDProcess ($loghandle) {
    $ps = "ps -eo pid,start,args | grep setlcd | grep /usr/bin/php | grep -v grep | grep -v sh";
    $psresult = exec ($ps);

    if (!$psresult) {
      fork_off ($loghandle, "/usr/bin/php /var/www/html/setlcd.php");
    }
  }

  function CheckTempProcess ($loghandle) {
    $ps = "ps -eo pid,start,args | grep settemp | grep /usr/bin/php | grep -v grep | grep -v sh";
    $psresult = exec ($ps);

    if (!$psresult) {
      fork_off ($loghandle, "/usr/bin/php /var/www/html/settemp.php");
    }    
  }

  $logfile = "/var/log/greenhouse.log";
  $loghandle = fopen ($logfile, "a");
  $pidarray = Array ();

  while (1) {
    CheckStuckProcess ($loghandle);
    $pid = CheckTempProcess ($loghandle);
    if ($pid) {
      array_push ($pidarray, $pid);
      $pid = 0;
    }

    $pid = CheckLCDProcess ($loghandle);
    if ($pid) {
      array_push ($pidarray, $pid);
      $pid = 0;
    }

    foreach ($pidarray as $child) {
      $stat = pcntl_waitpid(-1, $status, WNOHANG);
        if ($stat > 0)
          unset ($pidarray[array_search ($stat, $pidarray)]);
    }

    sleep (20);
  }

?>

