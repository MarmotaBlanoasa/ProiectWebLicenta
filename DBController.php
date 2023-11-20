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
     * @return void
     * @throws Exception
     */
    public function updateDB(string $query, array $params = []): void
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
        $param_type = "";
        foreach ($params as $query_param) {
            $param_type .= $query_param["param_type"];
        }

        $bind_params = [];
        $bind_params[] = &$param_type;

        foreach ($params as $k => &$query_param) {
            $bind_params[] = &$query_param['param_value'];
        }

        call_user_func_array([$sql_statement, 'bind_param'], $bind_params);
    }


    public function closeConnection(): void
    {
        $this->conn->close();
    }
}

// Usage
$db = DBController::getInstance();