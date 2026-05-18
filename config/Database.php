<?php

class Database {

    public function OpenCon() {

        $db_server = "localhost";
        $db_user = "root";
        $db_pass = "";
        $db_name = "library_management_system";
        $db = "";

        try {
            $db = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
        } catch(mysqli_sql_exception $e) {
            echo "<script>alert('Database connection failed');</script>";
        }
        return $db;
    }
}
?>