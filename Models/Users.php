<?php

    namespace Static\Models;

    use PDO;

    final class Users extends Database {

        public static function create() {
            $userID = rand(1, 16777215);

            $query = parent::$pdo->prepare("INSERT INTO Users (Created, UserID, IPAddress, UserAgent) VALUES (NOW(), :userID, :ipAddress, :userAgent)");
            $query->bindValue(":userID", (int)$userID, PDO::PARAM_INT);
            $query->bindValue(":ipAddress", \Static\Kernel::getValue($_SERVER, "REMOTE_ADDR"), PDO::PARAM_STR);
            $query->bindValue(":userAgent", \Static\Kernel::getValue($_SERVER, "HTTP_USER_AGENT"), PDO::PARAM_STR);

            if($query->execute()) $_SESSION["userID"] = (int)$userID;
        }

    }

?>