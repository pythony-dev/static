<?php

    namespace Static;

    final class Emails {

        private static $emails = array();

        public static function send($email, $title, $content, $copy = false) {
            $email = htmlspecialchars($email);
            $title = \Static\Kernel::getSettings("project-name") . " - " . htmlspecialchars($title);
            $content = \Static\Languages\Translate::getText("emails-start", true) . $content . \Static\Languages\Translate::getText("emails-end", true);
            $headers = htmlspecialchars_decode(\Static\Kernel::getSettings("emails-" . ($copy ? "copy" : "header")));

            array_push(self::$emails, array(
                "email" => $email,
                "title" => $title,
                "content" => $content,
            ));

            if(\Static\Kernel::getSettings("project-environment") == "production") return mail($email, $title, $content, $headers);
            else return true;
        }

        public static function getEmails() {
            return self::$emails;
        }

    }

?>