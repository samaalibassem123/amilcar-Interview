<?php
class Dbconnexion
{
    private $host = "127.0.0.1";
    private $user = "root";
    private $password = "bassem1234";
    private $db = "coupe_system";
    private $connection;
    public function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
?>