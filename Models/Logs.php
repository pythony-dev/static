<?php

    namespace Static\Models;

    use PDO;

    final class Logs extends Database {

        public static function create($userID, $status) {
            $userID = (int)$userID;
            $status = htmlspecialchars($status);

            $sessionID = (int)\Static\Kernel::getValue($_SESSION, "sessionID");

            if($userID <= 0 || !in_array($status, array("success", "error")) || $sessionID <= 0) return false;

            $query = parent::$pdo->prepare("INSERT INTO " . parent::getPrefix() . "Logs (created, sessionID, userID, status) VALUES (NOW(), :sessionID, :userID, :status)");
            $query->bindValue(":sessionID", $sessionID, PDO::PARAM_INT);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":status", $status, PDO::PARAM_STR);

            return $query->execute();
        }

    }

?>