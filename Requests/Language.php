<?php

    namespace Static\Requests;

    final class Language {

        public static function update() {
            $parameters = array();

            $language = \Static\Kernel::getValue($_POST, "language");

            if(!empty($language) && in_array($language, \Static\Languages\Translate::getAllLanguages())) {
                $_SESSION["language"] = $language;

                $parameters["status"] = "success";
            } else $parameters["status"] = "error";

            return $parameters;
        }

    }

?>