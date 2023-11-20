<?php
class DBController {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "eveniment2";
    private $conn;

    function __construct() {
        $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
    }

    function getDBResult($query, $params = array()) {
        $sql_statement = $this->conn->prepare($query);
        if ($sql_statement === false) {
            throw new Exception("Unable to prepare statement: " . $this->conn->error);
        }
        if (!empty($params)) {
            $this->bindParams($sql_statement, $params);
        }
        $sql_statement->execute();
        $result = $sql_statement->get_result();
        $resultset = array(); // Inițializează $resultset ca un array gol
    
        while ($row = $result->fetch_assoc()) {
            $resultset[] = $row;
        }
        return $resultset;
    }
    

    function updateDB($query, $params = array()) {
        $sql_statement = $this->conn->prepare($query);
        if ($sql_statement === false) {
            throw new Exception("Unable to prepare statement: " . $this->conn->error);
        }
        if (!empty($params)) {
            $this->bindParams($sql_statement, $params);
        }
        $sql_statement->execute();
    }

    function bindParams($sql_statement, $params) {
        if (!$sql_statement instanceof mysqli_stmt) {
            throw new Exception("Invalid statement object");
        }
    
        $param_type = "";
        foreach ($params as $query_param) {
            $param_type .= $query_param["param_type"];
        }
    
        $bind_params = array();
        $bind_params[] = &$param_type;
        foreach ($params as $k => $query_param) {
            $bind_params[] = &$params[$k]["param_value"];
        }
    
        call_user_func_array(array($sql_statement, 'bind_param'), $bind_params);
    }
    
}
?>
