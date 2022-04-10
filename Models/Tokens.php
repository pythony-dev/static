<?php

    namespace Static\Models;

    use PDO;

    final class Tokens extends Database {

        public static function create() {
            $value = sha1(\Static\Models\Users::createPassword() . \Static\Kernel::getSalt());

            $query = parent::$pdo->prepare("INSERT INTO Tokens (created, used, value, userID) VALUES (NOW(), NULL, :value, :userID)");
            $query->bindValue(":value", $value, PDO::PARAM_STR);
            $query->bindValue(":userID", (int)\Static\Kernel::getValue($_SESSION, "userID"), PDO::PARAM_INT);

            return $query->execute() ? $value : 0;
        }

        public static function check() {
            $value = \Static\Kernel::getValue($_POST, "token");

            if(empty($value)) return false;

            $query = parent::$pdo->prepare("SELECT id FROM Tokens WHERE used IS NULL AND value = :value AND userID = :userID AND TIMESTAMPDIFF(SECOND, created, NOW()) < 60");
            $query->bindValue(":value", $value, PDO::PARAM_STR);
            $query->bindValue(":userID", (int)\Static\Kernel::getValue($_SESSION, "userID"), PDO::PARAM_INT);
            $query->execute();

            if(!($results = $query->fetch())) return false;

            $query = parent::$pdo->prepare("UPDATE Tokens SET used = NOW() WHERE id = :id");
            $query->bindValue(":id", (int)$results["id"], PDO::PARAM_INT);

            return $query->execute();
        }

    }

?>