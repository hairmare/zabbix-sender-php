<?php
// grab files
require_once 'src/Zabbix/Config.php';
require_once 'src/Zabbix/Sender.php';
require_once 'src/Zabbix/Message.php';

// create sender
$conf = new Zabbix_Config('zabbix_agentd.conf');
$sender = new Zabbix_Sender($conf);

// send message(s)
$sender->send(new Zabbix_Message('system.status', 1));

