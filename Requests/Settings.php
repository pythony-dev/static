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
            $color = \Static\Kernel::getValue($_POST, "color");
            $mode = \Static\Kernel::getValue($_POST, "mode");
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(in_array($color, array_keys(\Static\Kernel::getThemes())) && $userID == 0) $_SESSION["theme"] = array(
                "color" => $color,
                "mode" => \Static\Kernel::getValue($_SESSION, array("theme", "mode")),
            );

            if(in_array($mode, array("light", "dark"))) $_SESSION["theme"] = array(
                "color" => \Static\Kernel::getValue($_SESSION, array("theme", "color")),
                "mode" => $mode,
            );

            return \Static\Kernel::getRequest("success");
        }

    }

?>