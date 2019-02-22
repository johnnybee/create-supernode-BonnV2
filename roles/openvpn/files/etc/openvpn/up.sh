#!/bin/bash
ip route del 0/0 table freifunk
ip route add default dev tun0  table freifunk
iptables -t nat -A POSTROUTING -o tun0  -j SNAT --to $4

