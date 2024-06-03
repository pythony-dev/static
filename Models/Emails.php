<?php

    namespace Static\Models;

    use PDO;

    final class Emails extends Database {

        public static function create($email, $title, $content) {
            $email = htmlspecialchars($email);
            $title = htmlspecialchars($title);
            $content = htmlspecialchars($content);

            $sessionID = (int)\Static\Kernel::getValue($_SESSION, "sessionID");
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(empty($email) || empty($title) || empty($content) || $sessionID <= 0 || $userID < 0) return null;

            $query = parent::$pdo->prepare("INSERT INTO Emails (created, sessionID, userID, email, title, content) VALUES (NOW(), :sessionID, :userID, :email, :title, :content)");
            $query->bindValue(":sessionID", $sessionID, PDO::PARAM_INT);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->bindValue(":title", $title, PDO::PARAM_STR);
            $query->bindValue(":content", $content, PDO::PARAM_STR);

            return $query->execute() ? \Static\Kernel::getHash("Email", parent::$pdo->lastInsertId()) : null;
        }

        public static function count() {
            return parent::$pdo->query("SELECT COUNT(id) AS count FROM Emails")->fetch()["count"] ?? 0;
        }

        public static function getEmail($hash) {
            $hash = htmlspecialchars($hash);

            if(empty($hash)) return array();

            $query = parent::$pdo->query("SELECT id FROM Emails ORDER BY ID DESC");

            while($response = $query->fetch()) {
                if(\Static\Kernel::getHash("Email", $response["id"]) == $hash) {
                    $query = parent::$pdo->prepare("SELECT created, email, title, content FROM Emails WHERE id = :emailID");
                    $query->bindValue(":emailID", $response["id"], PDO::PARAM_INT);
                    $query->execute();

                    return $query->fetch();
                }
            }

            return array();
        }

    }

?>