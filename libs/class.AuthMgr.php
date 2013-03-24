<?php

class AuthManager
{
    protected static $instance;

    private function __construct()
	{
	}
	
    private function __clone()
	{
	}
	
    private function __wakeup()
	{
	}
	
    public static function getInstance()
	{
        if (is_null(self::$instance))
		{
            self::$instance = new AuthManager();
        }
		
        return self::$instance;
    }
	
	public function checkAuth()
    {
        global $config;

        if (isset($_COOKIE['cabinet_auth']) && !$config['local'])
        {
            $cookie = explode('|', $_COOKIE['cabinet_auth']);
            $_SESSION['username'] = $cookie[0];
            $_SESSION['pass_hash'] = $cookie[1];
            $_SESSION['realmid'] = $cookie[2];
            $user = new User($_SESSION['username'], $_SESSION['pass_hash'], $_SESSION['realmid']);
        }
        elseif ($config['local'])
        {
            $user = new User("gmlta", "password", 0);
        }
        else
        {
            $user = new User("", "", 0);
        }
        
        return $user;
    }
}
