<?php

    namespace Static\Models;

    use PDO;

    final class Tokens extends Database {

        public static function create() {
            $sessionID = (int)\Static\Kernel::getValue($_SESSION, "sessionID");
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($sessionID <= 0 || $userID < 0) return 0;

            $value = \Static\Kernel::getHash("Token", \Static\Models\Users::createPassword());

            $query = parent::$pdo->prepare("INSERT INTO Tokens (created, deleted, sessionID, userID, value) VALUES (NOW(), NULL, :sessionID, :userID, :value)");
            $query->bindValue(":sessionID", $sessionID, PDO::PARAM_INT);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":value", $value, PDO::PARAM_STR);

            return $query->execute() ? $value : 0;
        }

        public static function check() {
            $value = \Static\Kernel::getValue($_POST, "token");

            if(empty($value)) return false;

            $query = parent::$pdo->prepare("SELECT id FROM Tokens WHERE deleted IS NULL AND userID = :userID AND value = :value AND TIMESTAMPDIFF(SECOND, created, NOW()) < 60");
            $query->bindValue(":userID", (int)\Static\Kernel::getValue($_SESSION, "userID"), PDO::PARAM_INT);
            $query->bindValue(":value", $value, PDO::PARAM_STR);
            $query->execute();

            if(!($results = $query->fetch())) return false;

            $query = parent::$pdo->prepare("UPDATE Tokens SET deleted = NOW() WHERE id = :id AND deleted IS NULL");
            $query->bindValue(":id", (int)$results["id"], PDO::PARAM_INT);

            return $query->execute() && (int)$query->rowCount() == 1;
        }

    }

?>