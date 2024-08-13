<?php

    namespace Static\Models;

    use PDO;

    abstract class Database {

        protected static $pdo = null;

        public final static function connect() {
            try {
                self::$pdo = new \PDO("mysql:host=" . \Static\Settings::getSettings("host") . ";dbname=" . \Static\Settings::getSettings("database") . ";charset=utf8", \Static\Settings::getSettings("username"), \Static\Settings::getSettings("password"), array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_SILENT));
            } catch(\PDOException $exception) {
                \Static\Kernel::setError(502, \Static\Languages\Translate::getText("error-502"), false, false);
            }
        }

        public final static function getPrefix() {
            return \Static\Settings::getSettings("prefix") ? \Static\Settings::getSettings("prefix") . "__" : null;
        }

    }

?>