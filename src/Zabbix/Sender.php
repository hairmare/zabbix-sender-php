<?php
/**
 * php implementation of Zabbix Sender Protocol 1.8
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
        $raw = 'ZBXD'.chr(1)
             . printf('%1$04u', strlen($message))
             . chr(0).chr(0).chr(0).chr(0)
             . $message;

        return file_put_contents($this->_config->getSenderTarget(), $raw);
    }
}
