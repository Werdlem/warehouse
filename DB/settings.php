<?php
 
//define('DB_HOST', 'localhost');define('DB_NAME', 'tooling'); define('DB_USER', 'root');define('DB_PASSWORD', 'root'); //work sql connecton
//define('DB_HOST', 'localhost:3307');define('DB_NAME', 'postpack'); define('DB_USER', 'root');define('DB_PASSWORD', '');// home sql connection
define('DB_HOST', 'damasco.plus.com:63306'); define('DB_NAME', 'stock'); define('DB_USER', 'ppkstock'); define('DB_PASSWORD', 'ppkstock'); //postpack.web sql connection
//define('SMTP_HOST', 'mail');
//define('SMTP_PORT', 25);
$user = 'mrwerdlem@gmail.com';
$pass=  'HmR2615;MeR0383;';

class Database
{  

    private static $conn  = null;
     
    public static function DB()
    {       
		if (!isset(self::$conn)) {
			
          self::$conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
		  self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
           return self::$conn;
    }
}