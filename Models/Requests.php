<?php

    namespace Static\Models;

    use PDO;

    final class Requests extends Database {

        private static $delay = 1;
        private static $limit = 16;
        private static $sessions = 16;

        public static function create() {
            $query = parent::$pdo->prepare("INSERT INTO Requests (created, ipAddress, userAgent) VALUES (NOW(), :ipAddress, :userAgent)");
            $query->bindValue(":ipAddress", \Static\Kernel::getValue($_SERVER, "REMOTE_ADDR"), PDO::PARAM_STR);
            $query->bindValue(":userAgent", \Static\Kernel::getValue($_SERVER, "HTTP_USER_AGENT"), PDO::PARAM_STR);

            return $query->execute();
        }

        public static function check() {
            $query = parent::$pdo->prepare("SELECT COUNT(id) AS count FROM Requests WHERE ipAddress = :ipAddress AND TIMESTAMPDIFF(SECOND, created, NOW()) < :delay");
            $query->bindValue(":ipAddress", \Static\Kernel::getValue($_SERVER, "REMOTE_ADDR"), PDO::PARAM_STR);
            $query->bindValue(":delay", (int)self::$delay, PDO::PARAM_INT);
            $query->execute();

            $count = $query->fetch()["count"] ?? self::$limit;

            if($count < self::$limit) return self::create();
            else if($count < self::$limit * self::$sessions) {
                $query = parent::$pdo->prepare("SELECT COUNT(id) AS count FROM Requests WHERE ipAddress = :ipAddress AND userAgent = :userAgent AND TIMESTAMPDIFF(SECOND, created, NOW()) < :delay");
                $query->bindValue(":ipAddress", \Static\Kernel::getValue($_SERVER, "REMOTE_ADDR"), PDO::PARAM_STR);
                $query->bindValue(":userAgent", \Static\Kernel::getValue($_SERVER, "HTTP_USER_AGENT"), PDO::PARAM_STR);
                $query->bindValue(":delay", (int)self::$delay, PDO::PARAM_INT);
                $query->execute();

                return ($query->fetch()["count"] ?? self::$limit) < self::$limit && self::create();
            } else return false;
        }

    }

?>