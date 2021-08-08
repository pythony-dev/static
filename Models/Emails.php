<?php

    namespace Static\Models;

    use PDO;

    final class Emails extends Database {

        public static function send($email, $subject, $message, $copy = false) {
            return !in_array(self::$environment, array("production")) || mail(htmlspecialchars($email), "Static - " . htmlspecialchars($subject), htmlspecialchars($message) . \Static\Languages\Translate::getText("emails-settings-footer"), \Static\Languages\Translate::getText("emails-settings-" . ($copy ? "copy" : "header")));
        }

    }

?>