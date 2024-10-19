<?php
require_once 'app/models/config.php';
class loginModel extends Model
{



    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=cstpe;charset=utf8', 'root', '');
    }

    public function getUserByUsername($username)
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE username= ?');
        $query->execute([$username]);

        return $query->fetch(PDO::FETCH_OBJ);
    }
}
