<?php

class DBController
{
    private static ?DBController $instance = null;

    private mysqli|false $conn;
    private string $host = "localhost";
    private string $user = "root";
    private string $password = "";
    private string $database = "eveniment";

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        if (mysqli_connect_error()) {
            throw new Exception("Failed to connect to database: " . mysqli_connect_error());
        }
    }
    public static function getInstance(): ?DBController
    {
        if (!self::$instance) {
            self::$instance = new DBController();
        }
        return self::$instance;
    }

    /**
     * Executes a SELECT query and returns the result set.
     *
     * @param string $query SQL query string.
     * @param array $params Parameters for the prepared statement.
     * @return array|null Result set array on success, null on failure.
     * @throws Exception
     */
    public function getDBResult(string $query, array $params = []): ?array
    {
        $sql_statement = $this->conn->prepare($query);

        if (!$sql_statement) {
            throw new Exception("Failed to prepare statement: " . $this->conn->error);
        }

        if (!empty($params)) {
            $this->bindParams($sql_statement, $params);
        }

        if (!$sql_statement->execute()) {
            throw new Exception("Failed to execute query: " . $sql_statement->error);
        }

        $result = $sql_statement->get_result();
        $result_set = [];

        while ($row = $result->fetch_assoc()) {
            $result_set[] = $row;
        }

        return $result_set ?: null;
    }

    /**
     * Executes an INSERT, UPDATE, or DELETE query.
     *
     * @param string $query SQL query string.
     * @param array $params Parameters for the prepared statement.
     * @return boolean
     * @throws Exception
     */
    public function updateDB(string $query, array $params = []): bool
    {
        $sql_statement = $this->conn->prepare($query);

        if (!$sql_statement) {
            throw new Exception("Failed to prepare statement: " . $this->conn->error);
        }

        if (!empty($params)) {
            $this->bindParams($sql_statement, $params);
        }

        if (!$sql_statement->execute()) {
            throw new Exception("Failed to execute query: " . $sql_statement->error);
        }
        return true;
    }

    /**
     * Binds parameters to a prepared statement.
     *
     * @param mysqli_stmt $sql_statement The prepared statement.
     * @param array $params Parameters to bind.
     * @return void
     */
    private function bindParams(mysqli_stmt $sql_statement, array $params): void
    {
        if (empty($params)) {
            return; // No parameters to bind, so just return.
        }

        $paramTypes = '';
        $bindParams = [];

        foreach ($params as $param) {
            if (!isset($param['param_type']) || !isset($param['param_value'])) {
                throw new InvalidArgumentException('Each parameter must have a "param_type" and a "param_value".');
            }

            $paramTypes .= $param['param_type'];
            $bindParams[] = &$param['param_value'];
        }

        array_unshift($bindParams, $paramTypes); // Prepend the string of types to the beginning of the array.

        if (!call_user_func_array([$sql_statement, 'bind_param'], $bindParams)) {
            throw new RuntimeException('Failed to bind parameters.');
        }
    }



    public function closeConnection(): void
    {
        $this->conn->close();
    }
    public function getConnection(): mysqli|false
    {
        return $this->conn;
    }
}

// Usage
$db = DBController::getInstance();