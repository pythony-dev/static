<?php

    namespace Static;

    final class Emails {

        public static function send($email, $title, $content, $copy = false) {
            $email = htmlspecialchars($email);
            $title = \Static\Kernel::getSettings("name") . " - " . htmlspecialchars($title);
            $content = htmlspecialchars_decode(\Static\Languages\Translate::getText("emails-start")) . $content . htmlspecialchars_decode(\Static\Languages\Translate::getText("emails-end", array(
                "name" => \Static\Kernel::getSettings("name"),
                "website" => \Static\Kernel::getPath("/contact"),
                "email" => \Static\Kernel::getSettings("email"),
            )));
            $headers = htmlspecialchars_decode(\Static\Kernel::getSettings("emails-" . ($copy ? "copy" : "header")));

            if(\Static\Models\Database::getEnvironment() == "production") return mail($email, $subject, $message, $headers);
            else if(\Static\Models\Database::getEnvironment() == "development") return true;
            else return false;
        }

    }

?>