<?php

    namespace Static\Models;

    use PDO;

    final class Sessions extends Database {

        public static function create() {
            if(array_key_exists("sessionID", $_SESSION)) return;

            $sessionID = (int)rand(1, 16777215);

            $query = parent::$pdo->prepare("INSERT INTO Sessions (created, sessionID, ipAddress, userAgent) VALUES (NOW(), :sessionID, :ipAddress, :userAgent)");
            $query->bindValue(":sessionID", $sessionID, PDO::PARAM_INT);
            $query->bindValue(":ipAddress", \Static\Kernel::getValue($_SERVER, "REMOTE_ADDR"), PDO::PARAM_STR);
            $query->bindValue(":userAgent", \Static\Kernel::getValue($_SERVER, "HTTP_USER_AGENT"), PDO::PARAM_STR);

            if($query->execute()) $_SESSION["sessionID"] = $sessionID;
        }

    }

?>