<?php

    namespace Static\Requests;

    final class Language {

        public static function update() {
            $language = \Static\Kernel::getValue($_POST, "language");
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(!in_array($language, \Static\Languages\Translate::getAllLanguages()) || $userID != 0) return \Static\Kernel::getRequest("error");

            $_SESSION["language"] = $language;

            return \Static\Kernel::getRequest("success");
        }

    }

?>