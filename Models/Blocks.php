<?php

    namespace Static\Models;

    use PDO;

    final class Blocks extends Database {

        public static function create($hash) {
            $blockedID = \Static\Models\Users::getID($hash);

            $sessionID = (int)\Static\Kernel::getValue($_SESSION, "sessionID");
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($blockedID <= 0 || $sessionID <= 0 || $userID <= 0 || $blockedID == $userID) return "error";

            $query = parent::$pdo->prepare("SELECT COUNT(id) AS count FROM Blocks WHERE deleted IS NULL AND blockerID = :blockerID AND blockedID = :blockedID");
            $query->bindValue(":blockerID", $userID, PDO::PARAM_INT);
            $query->bindValue(":blockedID", $blockedID, PDO::PARAM_INT);
            $query->execute();

            if($query->fetch()["count"] >= 1) return "success";

            $query = parent::$pdo->prepare("INSERT INTO Blocks (created, deleted, sessionID, blockerID, blockedID) VALUES (NOW(), NULL, :sessionID, :blockerID, :blockedID)");
            $query->bindValue(":sessionID", $sessionID, PDO::PARAM_INT);
            $query->bindValue(":blockerID", $userID, PDO::PARAM_INT);
            $query->bindValue(":blockedID", $blockedID, PDO::PARAM_INT);

            return $query->execute() ? "success" : "error";
        }

        public static function delete($hash) {
            $blockedID = \Static\Models\Users::getID($hash);

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($blockedID <= 0 || $userID <= 0) return "error";

            $query = parent::$pdo->prepare("UPDATE Blocks SET deleted = NOW() WHERE deleted IS NULL AND blockerID = :blockerID AND blockedID = :blockedID");
            $query->bindValue(":blockerID", $userID, PDO::PARAM_INT);
            $query->bindValue(":blockedID", $blockedID, PDO::PARAM_INT);

            return $query->execute() && (int)$query->rowCount() >= 1 ? array(
                "status" => "success",
            ) : "error";
        }

        public static function getBlocks() {
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($userID <= 0) return array();

            $query = parent::$pdo->prepare("
                SELECT
                    Users.id AS userID,
                    Users.username username
                FROM Blocks
                INNER JOIN Users
                ON Users.id = Blocks.blockedID
                WHERE
                    Blocks.deleted IS NULL
                    AND
                    Blocks.blockerID = :userID
            ");
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->execute();

            return $query->fetchAll();
        }

    }

?>