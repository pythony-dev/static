<?php

    namespace Static\Models;

    use PDO;

    final class Errors extends Database {

        public static function create($error, $response) {
            $error = (int)$error;
            $response = htmlspecialchars($response);

            if($error <= 0 || empty($response)) return;

            $query = parent::$pdo->prepare("INSERT INTO " . parent::getPrefix() . "Errors (created, sessionID, userID, link, error, response) VALUES (NOW(), :sessionID, :userID, :link, :error, :response)");
            $query->bindValue(":sessionID", (int)\Static\Kernel::getValue($_SESSION, "sessionID"), PDO::PARAM_INT);
            $query->bindValue(":userID", (int)\Static\Kernel::getValue($_SESSION, "userID"), PDO::PARAM_INT);
            $query->bindValue(":link", \Static\Kernel::getValue($_SERVER, "REQUEST_URI"), PDO::PARAM_STR);
            $query->bindValue(":error", $error, PDO::PARAM_INT);
            $query->bindValue(":response", $response, PDO::PARAM_STR);
            $query->execute();
        }

    }

?>