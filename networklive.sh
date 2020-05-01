#!/bin/bash

while true;
do
  NU=`ping -c1 192.168.0.1 | grep -c "64 bytes"`

  if [ $NU -lt 1 ]; then
    /sbin/ifconfig wlan0 down
    sleep 2
    /sbin/ifconfig wlan0 up
  fi

  sleep 10
done

