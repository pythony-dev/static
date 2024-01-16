<?php

    namespace Static\Requests;

    final class Settings {

        public static function language() {
            $language = \Static\Kernel::getValue($_POST, "language");
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(!in_array($language, \Static\Languages\Translate::getAllLanguages()) || $userID != 0) return \Static\Kernel::getRequest("error");

            $_SESSION["language"] = $language;

            return \Static\Kernel::getRequest("success");
        }

        public static function theme() {
            $theme = \Static\Kernel::getValue($_POST, "theme");
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(!in_array($theme, array_keys(\Static\Kernel::getThemes())) || $userID != 0) return \Static\Kernel::getRequest("error");

            $_SESSION["theme"] = $theme;

            return \Static\Kernel::getRequest("success");
        }

    }

?>