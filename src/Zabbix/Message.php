<?php

class Zabbix_Message
{
    public function __construct($key, $value)
    {
        $this->_data = array(
            "request" => "sender data",
            "data" => array(
                "host" => NULL,
                "key" => $key,
                "value" => $value
            )
        );
    }
    /**
     * gets called by Zabbix_Sender with data from config
     *
     * @param String $host The host we will be reporting as
     *
     * @return void
     */
    public function setHost($host)
    {
        $this->_data['data']['host'] = $host;
    }
    public function __toString()
    {
        return json_encode($this->_data);
    }
}
