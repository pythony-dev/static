<?php

    namespace Static\Requests;

    final class Language {

        public static function update() {
            $parameters = array();

            $language = \Static\Kernel::getValue($_POST, "language");
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(in_array($language, \Static\Languages\Translate::getAllLanguages()) && $userID == 0) {
                $_SESSION["language"] = $language;

                $parameters["status"] = "success";
            } else $parameters["status"] = "error";

            return $parameters;
        }

    }

?>