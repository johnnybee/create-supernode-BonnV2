#!/bin/bash

# grober Speedtest. Zuerst stellen wir die aktuelle Zeit in Sekunden fest. Dann laden wir 100MB runter uber VPN und dann stellen wir die neue Zeit fest.....
t=$(date +"%s"); 
curl -k --interface tun0 https://speed.hetzner.de/100MB.bin -o /dev/null; 
# hat der curl Aufruf funktioniert?
if [ $? -eq 0 ]; then
  expr 8 \* 100 / $(($(date +"%s")-$t)) > /var/www/html/speed.txt
fi
