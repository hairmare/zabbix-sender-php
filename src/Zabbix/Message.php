<?php

class Zabbix_Message
{
    const VERSION_1_8 = '1.8';
    const VERSION_1_4 = '1.4';
    
    /**
     * 
     * @param string $key 
     * @param string $value
     * @param string $version The Zabbix protocol version to use
     */
    public function __construct($key, $value, $version = self::VERSION_1_8)
    {
        $this->_data = array(
            "request" => "sender data",
            "data" => array(
                "host" => NULL,
                "key" => $key,
                "value" => $value
            )
        );
        
        $this->_version = $version;
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
    
    public function getVersion() {
        return $this->_version;
    }
    
    public function __toString()
    {
        if($this->_version == self::VERSION_1_8)
        {
            return json_encode($this->_data);
        }
        
        $message = "<req>\n<host>%s</host>\n<key>%s</key>\n<data>%s</data>\n</req>\n";
        $request = sprintf($message, 
                base64_encode($this->_data['data']['host']), 
                base64_encode($this->_data['data']['key']), 
                base64_encode($this->_data['data']['value']));
        
        return $request;
    }
}
