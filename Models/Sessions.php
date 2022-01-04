<?php

    namespace Static\Models;

    use PDO;

    final class Sessions extends Database {

        public static function create() {
            $sessionID = rand(1, 16777215);

            $query = parent::$pdo->prepare("INSERT INTO Sessions (Created, SessionID, IPAddress, UserAgent) VALUES (NOW(), :sessionID, :ipAddress, :userAgent)");
            $query->bindValue(":sessionID", (int)$sessionID, PDO::PARAM_INT);
            $query->bindValue(":ipAddress", \Static\Kernel::getValue($_SERVER, "REMOTE_ADDR"), PDO::PARAM_STR);
            $query->bindValue(":userAgent", \Static\Kernel::getValue($_SERVER, "HTTP_USER_AGENT"), PDO::PARAM_STR);

            if($query->execute()) $_SESSION["sessionID"] = (int)$sessionID;
        }

    }

?>