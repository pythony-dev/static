<?php

    namespace Static;

    final class Emails {

        public static function send($email, $title, $content, $copy = false) {
            $email = htmlspecialchars($email);
            $title = htmlspecialchars($title);
            $content = \Static\Languages\Translate::getText("emails-start", true) . $content . \Static\Languages\Translate::getText("emails-end", true);
            $headers = "MIME-Version : 1.0\nContent-type : text/html; charset=utf-8\nFrom : \"" . \Static\Languages\Translate::getText("emails-team") . "\" <" . \Static\Settings::getSettings("email") . ">" . (!$copy ? "" : "\nBcc : " . \Static\Settings::getSettings("email"));

            if(!($hash = \Static\Models\Emails::create($email, $title, $content))) return false;

            $_SERVER["REDIRECT_URL"] = substr(\Static\Settings::getSettings("link"), (array_key_exists("HTTPS", $_SERVER) ? 8 : 7) + strlen(\Static\Kernel::getValue($_SERVER, "HTTP_HOST"))) . "/email/" . $hash;

            $theme = $_SESSION["theme"];
            $_SESSION["theme"] = null;

            ob_start();

            \Static\Kernel::start($hash);

            $content = ob_get_contents();
            ob_end_clean();

            $_SESSION["theme"] = $theme;

            if(!\Static\Settings::getSettings("debug")) return mail($email, \Static\Settings::getSettings("name") . " - " . $title, $content, $headers);
            else return true;
        }

        public static function getParameters() {
            return \Static\Languages\Translate::getLanguage() . "&email=" . \Static\Kernel::getHash("Email", \Static\Models\Emails::count() + 1);
        }

    }

?>