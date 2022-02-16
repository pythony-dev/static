<?php

    namespace Static\Models;

    use PDO;

    final class Tokens extends Database {

        public static function create() {
            $value = sha1(\Static\Models\Users::createPassword() . \Static\Kernel::getSalt());

            $query = parent::$pdo->prepare("INSERT INTO Tokens (Created, Used, Value, UserID) VALUES (NOW(), NULL, :value, :userID)");
            $query->bindValue(":value", $value, PDO::PARAM_STR);
            $query->bindValue(":userID", (int)\Static\Kernel::getValue($_SESSION, "userID"), PDO::PARAM_INT);

            return $query->execute() ? $value : 0;
        }

        public static function check() {
            $value = \Static\Kernel::getValue($_POST, "token");

            if(empty($value)) return false;

            $query = parent::$pdo->prepare("SELECT ID FROM Tokens WHERE Value = :value AND TIMESTAMPDIFF(SECOND, Created, NOW()) < 60 AND Used IS NULL AND UserID = :userID");
            $query->bindValue(":value", $value, PDO::PARAM_STR);
            $query->bindValue(":userID", (int)\Static\Kernel::getValue($_SESSION, "userID"), PDO::PARAM_INT);
            $query->execute();

            if(!($results = $query->fetch())) return false;

            $query = parent::$pdo->prepare("UPDATE Tokens SET Used = NOW() WHERE ID = :id");
            $query->bindValue(":id", (int)$results["ID"], PDO::PARAM_INT);

            return $query->execute();
        }

    }

?>