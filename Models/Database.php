<?php

    namespace Static\Models;

    use PDO;

    abstract class Database {

        protected static $environment = "";
        protected static $pdo = null;

        public final static function connect() {
            self::$environment = \Static\Kernel::getSettings("project-environment");

            $charset = ";charset=utf8";
            $options = array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_SILENT);

            try {
                if(self::$environment == "production") self::$pdo = new \PDO("mysql:host=production-host;dbname=production-database" . $charset, "production-username", "production-password", $options);
                else if(self::$environment == "development") self::$pdo = new \PDO("mysql:host=development-host;dbname=development-database" . $charset, "development-username", "development-password", $options);
                else exit();
            } catch(PDOException $exception) {
                exit();
            }
        }

        public final static function getEnvironment() {
            return self::$environment;
        }

    }

?>