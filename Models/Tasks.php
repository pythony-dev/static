<?php

    namespace Static\Models;

    use PDO;

    final class Tasks extends Database {

        public static function create() {
            if(parent::$pdo->query("SELECT id FROM Tasks WHERE DATE(NOW()) = DATE(created)")->fetch()) return "error";

            return parent::$pdo->query("INSERT INTO Tasks (created) VALUES (NOW())") && \Static\Models\Welcome::newsletter() && \Static\Models\Articles::newsletter() ? "success" : "error";
        }

    }

?>