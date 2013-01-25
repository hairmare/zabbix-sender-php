<?php
/**
 * php implementation of Zabbix Sender Protocol 1.8 and 1.4
 *
 * @author    Lucas Bickel <hairmare@purplehaze.ch>
 * @copyright 2012, All Rights Reserved
 * @license   GPL
 */

/**
 * class for wrapping a message with a header and sending over tcp
 *
 * @class
 */
class Zabbix_Sender
{
    /**
     * Create a zabbix sender.
     *
     * @param Zabbix_Config $config
     *
     * @return void
     */
	public function __construct(Zabbix_Config $config)
	{
        $this->_config = $config;
	}

    /**
     *
     * @param Zabbix_Message $message Message to be sent
     *
     * @return
     */
    public function send(Zabbix_Message $message)
    {
        $message->setHost($this->_config->getHostname());

        // create packet
        // Maybe the headers should into Zabbix_Message ...
        if($message->getVersion() == Zabbix_Message::VERSION_1_8)
        {
            $raw = 'ZBXD'.chr(1)
                 . printf('%1$04u', strlen($message))
                 . chr(0).chr(0).chr(0).chr(0)
                 . $message;
        }
        else 
        {
            $raw = $message;
        }

        // doesn't look like file contents can use a tcp-wrapper
        //return file_put_contents($this->_config->getSenderTarget(), $raw);
        return $this->connect_and_send($this->_config->getSenderTarget(), $raw);
    }
    
    /*
     * Socket oriented message sending
     * 
     * @return int|FALSE number of bytes sent, FALSE is the connection 
     *      couldn't be established
     */
    private function connect_and_send($target, $raw_message)
    {
      try {
        $fp = stream_socket_client($target, $errno = -1, $errstr = '', 5);
        
        if(!$fp)
        {
          return FALSE;
        }
        $result = fwrite($fp, $raw_message);
        fclose($fp);
        return $result;
        
      } catch(Exception $e) {
          return FALSE;
      }
    }
}

