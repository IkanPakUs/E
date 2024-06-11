<?php

class DB {
    private static $conn, $dbname;

    protected static $table, $select_column, $where_clause = [], $limit, $offset, $left_join = [], $order_by, $group_by;

    public static function table($table) {
        self::$table = $table;
        self::dbConnect();

        return new static();
    }

    public static function select() {
        $num_args = func_num_args();

        if ($num_args > 0) {
            $select_column = func_get_args();
            self::$select_column = $select_column;
        }

        return new static();
    }

    public static function where($column, $operator, $comparison) {
        $where_statemen = [ "type" => "AND", "clause" => [$column, $operator, $comparison]];
        self::$where_clause[] = $where_statemen;

        return new static();
    }

    public static function orWhere($column, $operator, $comparison) {
        $where_statemen = [ "type" => "OR", "clause" => [$column, $operator, $comparison]];
        self::$where_clause[] = $where_statemen;

        return new static();
    }

    public static function limit($count) {
        self::$limit = $count;

        return new static();
    }

    public static function offset($count) {
        self::$offset = $count;

        return new static();
    }

    public static function leftJoin($table, $first, $operator, $second) {
        array_push(self::$left_join, ["table" => $table, "first" => $first, "operator" => $operator, "second" => $second]);

        return new static();
    }

    public static function orderBy($column, $order) {
        self::$order_by = $column . " " . $order;

        return new static();
    }

    public static function groupBy($column) {
        self::$group_by = $column;

        return new static();
    }

    public static function raw($sql) {
        self::dbConnect();
        $conn = self::$conn;

        $result = $conn->query($sql);

        return $result;
    }

    public static function getLastId()
    {
        $conn = self::$conn;

        $last_id = $conn->insert_id;

        return $last_id;
    }

    public static function count($column = null, $as_column = null) {
        $conn = self::$conn;
        $table = self::$table;

        $column = $column ? $column : 'id';
        $as_column = $as_column ? $as_column : 'count';

        self::queryValidator();

        $sql = "SELECT COUNT($column) as $as_column FROM $table";

        $sql .= self::setupWhereClause();

        $result = $conn->query($sql);
        self::format();

        if (!$result) {
            echo "<br> ========= Error ========= <br><br>";
            echo "Exception $conn->error <br>";
            echo "On $sql";
            echo "<br><br> ====================== <br>";
            die;
        };

        return $result->fetch_all(MYSQLI_ASSOC)[0]["count"];
    }

    public static function sum($column) {
        $conn = self::$conn;
        $table = self::$table;

        self::queryValidator();

        $sql = "SELECT SUM($column) as total FROM $table";

        $sql .= self::setupWhereClause();

        $result = $conn->query($sql);
        self::format();

        if (!$result) {
            echo "<br> ========= Error ========= <br><br>";
            echo "Exception $conn->error <br>";
            echo "On $sql";
            echo "<br><br> ====================== <br>";
            die;
        };

        return $result->fetch_all(MYSQLI_ASSOC)[0]["total"];
    }

    public static function find($id, $column = 'id') {
        self::limit(1);
        self::where($column, '=', $id);

        $result = self::queryGet();

        if ($result) {
            $result = $result[0];
        }

        return $result;
    }

    public static function get() {
        return self::queryGet();
    }

    public static function insert($column_add) {
        $conn = self::$conn;
        $table = self::$table;

        self::queryValidator();
        
        if (count($column_add) == count($column_add, COUNT_RECURSIVE)) {
            $column = implode(", ", array_keys($column_add));

            $value = implode(", ", array_map( function($column) {
                return "'" . $column . "'";
            }, $column_add));

            $value = " ($value)";
        }  else {
            $column = implode(", ", array_keys($column_add[0]));

            $value = array_map( function($row) {
                $value_string = implode(", ", array_map( function($column) {
                    return "'$column'";
                }, $row));

                return " ($value_string)";
            }, $column_add);

            $value = implode(", ", $value);
        }

        $sql = "INSERT INTO $table ($column) VALUES $value";

        self::format();

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    public static function update($column_update) {
        $conn = self::$conn;
        $table = self::$table;

        self::queryValidator();

        $columns = array_map( function($key, $value)  {
            return $key .= " = '" . $value . "'";
        } , array_keys($column_update), $column_update);

        $columns = implode(", ", $columns);

        $where_clause = self::setupWhereClause();

        $sql = "UPDATE $table SET $columns $where_clause";

        self::format();

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    public static function delete() {
        $conn = self::$conn;
        $table = self::$table;
        $where_clause = self::setupWhereClause();

        self::queryValidator();

        $sql = "DELETE FROM $table $where_clause";

        self::format();

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    public static function decrement($column, $count = 1) {
        $conn = self::$conn;
        $table = self::$table;
        $where_clause = self::setupWhereClause();

        self::queryValidator();

        $sql = "UPDATE $table SET $column = $column - $count $where_clause";

        self::format();

        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    protected static function queryGet() {
        $conn = self::$conn;
        $table = self::$table;
        $select_column = isset(self::$select_column) ? implode(", ", self::$select_column) : "*";

        self::queryValidator();

        $sql = "SELECT $select_column FROM $table";
        
        $sql .= self::setupWhereClause();
        
        $result = $conn->query($sql);
        self::format();

        if (!$result) {
            echo "<br> ========= Error ========= <br><br>";
            echo "Exception $conn->error <br>";
            echo "On $sql";
            echo "<br><br> ====================== <br>";
            die;
        };

        if ($result) {
            if ($result->num_rows > 0) {
                return $result->fetch_all(MYSQLI_ASSOC);
            }
        }

        return [];
    }

    protected static function setupWhereClause() {
        $where_clause = self::$where_clause;
        $order_by = self::$order_by;
        $group_by = self::$group_by;
        $limit = self::$limit;
        $offset = self::$offset;
        $left_join = self::$left_join;

        $sql = "";

        if (count($left_join) > 0) {
            foreach ($left_join as $join) {
                $sql .= " LEFT JOIN {$join['table']} ON {$join['first']} {$join['operator']} {$join['second']}";
            }
        }

        $where_clause = array_map( function($key, $value) {
            $sql = "";
            if ($key != 0) {
                $sql .= " " . $value["type"] . " ";
            }
            
            $value["clause"][2] = in_array("(", str_split($value["clause"][2])) ? $value["clause"][2] : "'" . $value["clause"][2] . "'";

            $string_clause = implode(" ", $value["clause"]);
            $sql .= " " . $string_clause;

            return $sql;
            
        } , array_keys($where_clause), $where_clause);
        
        if (count($where_clause)) {
            $sql .= " WHERE " . implode(" ", $where_clause);
        }

        if (isset($group_by)) {
            $sql .= " GROUP BY $group_by";
        }

        if (isset($order_by)) {
            $sql .= " ORDER BY $order_by";
        }

        if (isset($limit)) {
            $sql .= " LIMIT $limit";
        }

        if (isset($offset)) {
            $sql .= " OFFSET $offset";
        }

        return $sql;
    }

    protected static function queryValidator() {        
        $tables = self::getAllTable();

        try {
            $tables_arr = array_map( function ($table) {
                return $table[0]; 
            }, array_values($tables));
    
            if (!isset(self::$table) || !in_array(self::$table, $tables_arr)) {
                echo "No table selected <br>";
            }
            
        } catch (\Throwable $th) {
            echo $th;
        }

    }

    protected static function getAllTable() {
        $conn = self::$conn;
        $dbname = self::$dbname;

        $sql = "SHOW TABLES FROM $dbname";
        if (!isset($conn)) {
            self::dbConnect();
        }

        $tables = $conn->query($sql);

        if ($tables->num_rows > 0) {
            return $tables->fetch_all();
        } else {
            throw new Exception("Table is not available in this database");
        }
    }

    protected static function dbConnect() {
        $servername = "db"; // Server host for database
        $username = "root"; // Username for db
        $password = "ikanpakus"; // Password for db
        
        self::$dbname = $dbname = "docker_db"; // Schema name

        $conn = new mysqli($servername, $username, $password, $dbname);
        $conn->set_charset('utf8');
        self::$conn = $conn;

        if ($conn->connect_error) {
            echo "<br> ========= Error ========= <br><br> Connection Failed : $conn->error <br><br> ====================== <br>";
            die;
        }

    }

    protected static function format() {
        self::$table = null;
        self::$select_column = null;
        self::$where_clause = [];
        self::$limit = null;
        self::$offset = null;
        self::$left_join = [];
        self::$order_by = null;
        self::$group_by = null;
    }

}
