<?php
if (isset($_POST['pubkey'])) {
        $pubkey=htmlentities($_POST['pubkey']);

        # pubkey darf nur aus dem großen und kleinen Alphabet, Ziffern / und + bestehen und am Ende muss ein/zwei Gleichheitszeichen sein.
        if (!preg_match('%^[a-zA-Z0-9/+]*={1,2}$%', $pubkey)) {
                return;
        }
        
        // Erstmal eine freie IP raussuchen
        // Alle bereits vergegebenen IP-Adressen aus Wireguard auslesen
        exec("sudo /usr/bin/wg | grep 'allowed ips' | awk -v FS=' ' '{print $3}' | sed 's/\/32//'",$o);

        $gefunden=false;
        // IP Range ist 10.3.0.0/16
        // Die Range geht von 10.3.1.1-10.3.254.254
        // Die vorherigen IPs sind für Backbonegeschichten (z.B. Verbindungen der Supernodes untereinander)
        // 1. Oktet durchlaufen
        for ($oktet1=1; $oktet1<=254; $oktet1++)
        {
                //und 2. Oktet
                for ($oktet2=1; $oktet2<=254; $oktet2++)
                {
                        $IP="10.3.".$oktet1.".".$oktet2;
                        //Wenn zusammengesetzte IP-Adresse NICHT in der Ausgabe von Wireguard erschienen ist
                        if (in_array($IP,$o) == false) {
                                $gefunden=true;
                                break;                  //raus
                        }
                }
                if ($gefunden == true) { break; } //und raus
        }

        $interface=$oktet1.$oktet2;
    exec("sudo /sbin/ip link delete gre-{$interface}",$o);

        exec("sudo /usr/bin/wg  set wg0  peer {$pubkey} remove",$o);
        exec("sudo /usr/bin/wg set wg0 peer {$pubkey} allowed-ips {$IP}/32",$o);
        exec("sudo /sbin/ip link add gre-{$interface} type gretap remote {$IP} local 10.3.0.2",$o);
        exec("sudo /sbin/ip link set up dev gre-{$interface}",$o);
        exec("sudo /sbin/brctl addif wireguard gre-{$interface}",$o);

        //Und IP-Adresse zurückgeben
        echo $IP;

// sudo /usr/bin/wg | grep "allowed ips" | awk -v FS=" " '{print $3}'
}



?>

