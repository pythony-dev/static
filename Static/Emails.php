<?php

    namespace Static;

    final class Emails {

        public static function send($email, $title, $content, $copy = false) {
            $email = htmlspecialchars($email);
            $title = \Static\Kernel::getSettings("project-name") . " - " . htmlspecialchars($title);
            $content = \Static\Languages\Translate::getText("emails-start", true) . $content . \Static\Languages\Translate::getText("emails-end", true, array(
                "email" => \Static\Kernel::getSettings("settings-email"),
                "contact" => \Static\Kernel::getPath("/contact"),
            ));
            $headers = \Static\Kernel::getSettings("emails-" . ($copy ? "copy" : "header"), true);

            if(\Static\Kernel::getSettings("project-environment") == "production") return mail($email, $title, $content, $headers);
            else if(\Static\Kernel::getSettings("project-environment") == "development" && array_key_exists("debug", $_POST)) {
                echo json_encode(array(
                    "email" => $email,
                    "title" => $title,
                    "content" => $content,
                    "headers" => $headers,
                ));

                exit();
            } else return \Static\Kernel::getSettings("project-environment") == "development";
        }

    }

?>