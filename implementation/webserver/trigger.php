<?php

$ip='192.168.2.108';
$port=9999;

$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($sock===null) error_log("cannot create socket");
socket_connect($sock, $ip, $port);
socket_close($sock);
