<?php
class DatabaseConnector
{
    private $pdo;

    public function __construct($path)
    {
        $absolutePath = realpath(__DIR__ . "/../" . $path);

        if (!file_exists($absolutePath)) {
            throw new Exception("not found: $absolutePath");
        }

        $this->pdo = new PDO("sqlite:" . $absolutePath);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function exec($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function fetchAll($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$database = new DatabaseConnector("db/store.db");
?>