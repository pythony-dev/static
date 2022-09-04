<?php

    namespace Static\Models;

    use PDO;

    final class Reports extends Database {

        public static function create($setting, $value) {
            $setting = htmlspecialchars($setting);

            if($setting == "thread") $value = \Static\Models\Threads::getThreadID($value);
            else if($setting == "post") $value = \Static\Models\Posts::getPostID($value);
            else return "error";

            $sessionID = (int)\Static\Kernel::getValue($_SESSION, "sessionID");
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($value <= 0) return "value";
            else if($sessionID <= 0 || $userID < 0) return "error";

            $query = parent::$pdo->prepare("INSERT INTO Reports (created, sessionID, userID, setting, value) VALUES (NOW(), :sessionID, :userID, :setting, :value)");
            $query->bindValue(":sessionID", $sessionID, PDO::PARAM_INT);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":setting", $setting, PDO::PARAM_STR);
            $query->bindValue(":value", $value, PDO::PARAM_INT);

            return $query->execute() ? "success" : "error";
        }

    }

?>