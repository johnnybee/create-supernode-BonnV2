#!/bin/bash

# grober Speedtest. Zuerst stellen wir die aktuelle Zeit in Sekunden fest. Dann laden wir 100MB runter uber VPN und dann stellen wir die neue Zeit fest.....
t=$(date +"%s"); 
curl  --interface tun0 https://speed.hetzner.de/100MB.bin -o /dev/null; 
expr 8 \* 100 / $(($(date +"%s")-$t)) > /var/www/html/speed.txt
#echo -n "MBit/s: "; expr 8 \* 100 / $(($(date +"%s")-$t))
