<?php
//Speed auslesen aus letzter VPN Messung
$speed = file_get_contents ('speed.txt');
#echo $speed;
//Und schauen, wieviele Wireguard Verbindungen schon da sind
$connections = shell_exec ("sudo /usr/bin/wg show wg0 | grep peer | wc -l");
#echo $connections;
//Durchschnittlich verfuegbare Geschwindigkeit pro Anschluss
echo round($speed/($connections+1));
?>
