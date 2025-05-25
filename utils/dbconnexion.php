<?php
class Dbconnexion
{
    private final $host = "localhost";
    private final $user = "root";
    private final $password = "bassem1234";
    private final $db = "coupe_system";
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
    public function getConnection()
    {
        return $this->connection;
    }
}
?>