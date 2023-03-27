<?php
// Creating class for Database Connection
class connection{
    
    // Constructor
    
    public function __construct(private string $host, private string $name, private string $user, private string $password)
    {}
    
    // Initiating Database connectivity using PDO
    
    public function getConnection(): PDO
    {
        $dsn = "mysql:host={$this->host};dbname={$this->name};charset=utf8";
        return new PDO($dsn, $this->user, $this->password);
    }
}
?>