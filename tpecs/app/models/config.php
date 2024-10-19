<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'cstpe');
define('DB_Charset', 'utf8');
?>
<?php
class Model
{
    protected $db;

    function __construct()
    {
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=cstpe;charset=' . DB_Charset, DB_USER, DB_PASS);
    }
}
