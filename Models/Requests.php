<?php

    namespace Static\Models;

    use PDO;

    final class Requests extends Database {

        private static $delay = 1;
        private static $limit = 16;
        private static $sessions = 16;

        public static function create() {
            $query = parent::$pdo->prepare("INSERT INTO Requests (DateTime, IPAddress, UserAgent) VALUES (NOW(), :ipAddress, :userAgent)");
            $query->bindValue(":ipAddress", \Static\Kernel::getValue($_SERVER, "REMOTE_ADDR"), PDO::PARAM_STR);
            $query->bindValue(":userAgent", \Static\Kernel::getValue($_SERVER, "HTTP_USER_AGENT"), PDO::PARAM_STR);

            return $query->execute();
        }

        public static function check() {
            $query = parent::$pdo->prepare("SELECT COUNT(ID) AS Count FROM Requests WHERE IPAddress = :ipAddress AND TIMESTAMPDIFF(SECOND, DateTime, NOW()) < :delay");
            $query->bindValue(":ipAddress", \Static\Kernel::getValue($_SERVER, "REMOTE_ADDR"), PDO::PARAM_STR);
            $query->bindValue(":delay", (int)self::$delay, PDO::PARAM_INT);
            $query->execute();

            $count = $query->fetch()["Count"];

            if($count < self::$limit) return self::create();
            else if($count < self::$sessions * self::$limit) {
                $query = parent::$pdo->prepare("SELECT COUNT(ID) AS Count FROM Requests WHERE IPAddress = :ipAddress AND UserAgent = :userAgent AND TIMESTAMPDIFF(SECOND, DateTime, NOW()) < :delay");
                $query->bindValue(":ipAddress", \Static\Kernel::getValue($_SERVER, "REMOTE_ADDR"), PDO::PARAM_STR);
                $query->bindValue(":userAgent", \Static\Kernel::getValue($_SERVER, "HTTP_USER_AGENT"), PDO::PARAM_STR);
                $query->bindValue(":delay", (int)self::$delay, PDO::PARAM_INT);
                $query->execute();

                return $query->fetch()["Count"] < self::$limit && self::create();
            } else return false;
        }

    }

?>