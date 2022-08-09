<?php

    namespace Static\Models;

    use PDO;

    final class Requests extends Database {

        public static function start() {
            $sessionID = (int)\Static\Kernel::getValue($_SESSION, "sessionID");
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($sessionID <= 0 || $userID < 0) return false;

            $query = parent::$pdo->prepare("SELECT COUNT(id) AS count FROM Requests WHERE sessionID = :sessionID AND TIMESTAMPDIFF(SECOND, created, NOW()) = 0");
            $query->bindValue(":sessionID", $sessionID, PDO::PARAM_INT);
            $query->execute();

            $count = $query->fetch()["count"] ?? 16;

            if($count <= 15) {
                $query = parent::$pdo->prepare("INSERT INTO Requests (created, sessionID, userID, link, language) VALUES (NOW(), :sessionID, :userID, :link, :language)");
                $query->bindValue(":sessionID", $sessionID, PDO::PARAM_INT);
                $query->bindValue(":userID", $userID, PDO::PARAM_INT);
                $query->bindValue(":link", \Static\Kernel::getValue($_SERVER, "REQUEST_URI"), PDO::PARAM_STR);
                $query->bindValue(":language", \Static\Languages\Translate::getLanguage(), PDO::PARAM_STR);

                return $query->execute();
            } else return false;
        }

    }

?>