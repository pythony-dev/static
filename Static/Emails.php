<?php

    namespace Static;

    final class Emails {

        public static function send($email, $title, $content, $copy = false) {
            $email = htmlspecialchars($email);
            $title = htmlspecialchars($title);
            $content = \Static\Languages\Translate::getText("emails-start", true) . $content . \Static\Languages\Translate::getText("emails-end", true);
            $headers = htmlspecialchars_decode(\Static\Kernel::getSettings("emails-" . ($copy ? "copy" : "header")));

            if(!($hash = \Static\Models\Emails::create($email, $title, $content))) return false;

            $_SERVER["REDIRECT_URL"] = substr(\Static\Kernel::getSettings("settings-link"), (array_key_exists("HTTPS", $_SERVER) ? 8 : 7) + strlen(\Static\Kernel::getValue($_SERVER, "HTTP_HOST"))) . "/email/" . $hash;

            ob_start();

            \Static\Kernel::start($hash);

            $content = ob_get_contents();
            ob_end_clean();

            if(\Static\Kernel::getSettings("project-environment") == "production") return mail($email, \Static\Kernel::getSettings("project-name") . " - " . $title, $content, $headers);
            else return \Static\Kernel::getSettings("project-environment") == "development";
        }

    }

?>