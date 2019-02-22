#!/bin/bash
iptables  -t nat -D POSTROUTING -o tun0  -j SNAT --to $4
