<?php

    namespace Static\Models;

    use PDO;

    final class Updates extends Database {

        public static function create($setting, $value) {
            $setting = htmlspecialchars($setting);
            $value = htmlspecialchars($value);

            $sessionID = (int)\Static\Kernel::getValue($_SESSION, "sessionID");
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(!in_array($setting, array("email", "username", "password", "reset")) || empty($value) || $sessionID <= 0 || $userID <= 0) return false;

            $query = parent::$pdo->prepare("INSERT INTO Updates (created, sessionID, userID, setting, value) VALUES (NOW(), :sessionID, :userID, :setting, :value)");
            $query->bindValue(":sessionID", $sessionID, PDO::PARAM_INT);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":setting", $setting, PDO::PARAM_STR);
            $query->bindValue(":value", $value, PDO::PARAM_STR);

            return $query->execute();
        }

    }

?>