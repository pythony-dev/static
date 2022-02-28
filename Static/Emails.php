<?php

    namespace Static;

    final class Emails {

        public static function send($email, $title, $content, $copy = false) {
            $email = htmlspecialchars($email);
            $title = \Static\Kernel::getSettings("project-name") . " - " . htmlspecialchars($title);
            $content = \Static\Languages\Translate::getText("emails-start", true) . $content . \Static\Languages\Translate::getText("emails-end", true, array(
                "name" => \Static\Kernel::getSettings("project-name"),
                "link" => \Static\Kernel::getPath("/contact"),
                "email" => \Static\Kernel::getSettings("settings-email"),
            ));
            $headers = \Static\Kernel::getSettings("emails-" . ($copy ? "copy" : "header"), true);

            if(\Static\Models\Database::getEnvironment() == "production") return mail($email, $subject, $message, $headers);
            else if(\Static\Models\Database::getEnvironment() == "development") return true;
            else return false;
        }

    }

?>