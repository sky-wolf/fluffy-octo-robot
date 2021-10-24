<?php

namespace Framework\Session;

class Session  
{
    protected const FLASH_KEY = 'flash_messages';

    public function __construct()
    {

        session_start();

        $flashMassages = $_SESSION[ self::FLASH_KEY ] ?? [];

        foreach($flashMassages as $key => $flashMassage)
        {
            $flashMassage[ 'remove' ] = true;
        }
        $_SESSION[ self::FLASH_KEY ] = $flashMassages;
    }

    public function setFlash($key, $message)
    {
        $_SESSION[ self::FLASH_KEY ][ $key ] = [
            'remove' => false,
            'value'  => $message
        ];
    }

    public function getFlash($key)
    {
        return $_SESSION[ self::FLASH_KEY ][ $key ][ 'value' ] ?? false;
    }

    public function set($key, $value)
    {
        $_SESSION[ $key ] = $value;
    }

    public function get($key)
    {
        return $_SESSION[ $key ] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public function __destruct()
    {
        $this->removeFlashMassages();
    }

    private function removeFlashMassages()
    {
        $flashMassages = $_SESSION[ self::FLASH_KEY ] ?? [];

        foreach($flashMassages as $key => $flashMassage)
        {
            if($flashMassage[ 'remove' ])
            {
                unset($flashMassage[$key]);
            }
        }
        $_SESSION[ self::FLASH_KEY ] = $flashMassages;
    }
}
