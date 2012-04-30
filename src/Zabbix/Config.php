<?php

class Zabbix_Config
{
    public function __construct($configFile)
    {
        $this->_config = parse_ini_file($configFile);
    }

    public function getSenderTarget()
    {
        return 'tcp://'.$this->_config['Server'].':'.$this->_config['ServerPort'];
    }

    public function getHostname()
    {
        return $this->_config['Hostname'];
    }
}
