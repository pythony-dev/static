<?php

    namespace Static\Models;

    use PDO;

    final class Tasks extends Database {

        public static function create() {
            if(parent::$pdo->query("SELECT id FROM " . parent::getPrefix() . "Tasks WHERE DATE(NOW()) = DATE(created)")->fetch()) return "error";

            return parent::$pdo->query("INSERT INTO " . parent::getPrefix() . "Tasks (created) VALUES (NOW())") && \Static\Models\Welcome::newsletter() && \Static\Models\Users::resume() && \Static\Models\Articles::newsletter() ? "success" : "error";
        }

    }

?>