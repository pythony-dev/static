<?php

    namespace Static\Models;

    use PDO;

    final class Sessions extends Database {

        public static function start() {
            if(array_key_exists("sessionID", $_SESSION)) return true;

            $query = parent::$pdo->prepare("SELECT COUNT(id) AS count FROM Sessions WHERE ipAddress = :ipAddress AND TIMESTAMPDIFF(SECOND, created, NOW()) = 0");
            $query->bindValue(":ipAddress", \Static\Kernel::getValue($_SERVER, "REMOTE_ADDR"), PDO::PARAM_STR);
            $query->execute();

            $count = $query->fetch()["count"] ?? 16;

            if($count <= 15) {
                $sessionID = (int)rand(1, 16777215);

                $query = parent::$pdo->prepare("INSERT INTO Sessions (created, sessionID, ipAddress, userAgent, parameters) VALUES (NOW(), :sessionID, :ipAddress, :userAgent, :parameters)");
                $query->bindValue(":sessionID", $sessionID, PDO::PARAM_INT);
                $query->bindValue(":ipAddress", \Static\Kernel::getValue($_SERVER, "REMOTE_ADDR"), PDO::PARAM_STR);
                $query->bindValue(":userAgent", \Static\Kernel::getValue($_SERVER, "HTTP_USER_AGENT"), PDO::PARAM_STR);
                $query->bindValue(":parameters", \Static\Kernel::getValue($_SERVER, "QUERY_STRING"), PDO::PARAM_STR);

                return $query->execute() && $_SESSION["sessionID"] = $sessionID;
            } else return false;
        }

    }

?>