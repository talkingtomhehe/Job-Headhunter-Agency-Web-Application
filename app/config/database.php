<?php
class Database {
    private $connection;
    private $statement;

    public function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            $error_msg = "Database Connection Error: " . $e->getMessage();
            error_log($error_msg);
            throw new Exception($error_msg);
        }
    }

    public function query($sql, $params = []) {
        try {
            $this->statement = $this->connection->prepare($sql);

            // Debug information
            error_log("Executing SQL: " . $sql);
            error_log("Parameters: " . print_r($params, true));

            $this->statement->execute($params);

            // For SELECT queries
            if (stripos($sql, 'SELECT') === 0) {
                $result = $this->statement->fetchAll();
                error_log("Query result: " . print_r($result, true));
                return $result;
            }
            // For INSERT, UPDATE, DELETE queries
            return true;
        } catch (PDOException $e) {
            $error_msg = sprintf(
                "Database Query Error:\nMessage: %s\nSQL: %s\nParameters: %s",
                $e->getMessage(),
                $sql,
                print_r($params, true)
            );
            error_log($error_msg);
            throw new Exception($error_msg);
        }
    }

    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }
}
?>