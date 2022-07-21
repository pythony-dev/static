<?php

    namespace Static\Models;

    use PDO;

    final class Updates extends Database {

        public static function create($setting, $value) {
            $setting = htmlspecialchars($setting);
            $value = htmlspecialchars($value);

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(empty($setting) || empty($value) || $userID <= 0) return false;

            $query = parent::$pdo->prepare("INSERT INTO Updates (updated, userID, setting, value) VALUES (NOW(), :userID, :setting, :value)");
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":setting", $setting, PDO::PARAM_STR);
            $query->bindValue(":value", $value, PDO::PARAM_STR);

            return $query->execute();
        }

    }

?>