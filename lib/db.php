<?php 
class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'nguyen_anh_quoc_2123110038';
    public $conn;

    function __construct() { 
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) { 
            die("Connection Failed: " . $this->conn->connect_error);
        } else {
            // echo "Connected successfully !!!";
        }
    }
}
?>
