<?php

    namespace Static\Languages;

    final class Translate {

        protected static $language = "english";
        protected static $translations = array();

        public static function setLanguage($default = "") {
            if($default == "") {
                foreach(self::getAllLanguages() as $language) {
                    if(array_key_exists($language, $_GET)) $_SESSION["language"] = $language;
                }

                if(array_key_exists("language", $_SESSION) && in_array(\Static\Kernel::getValue($_SESSION, "language"), self::getAllLanguages())) self::$language = \Static\Kernel::getValue($_SESSION, "language");
            } else if(in_array($default, self::getAllLanguages())) self::$language = $default;

            $file = "Languages/" . ucfirst(self::$language) . ".json";
            self::$translations = (array)json_decode(file_get_contents(file_exists($file) ? $file : "Languages/English.json"));
        }

        public static function getUserLanguage() {
            $user = \Static\Models\Users::getUser((int)\Static\Kernel::getValue($_SESSION, "userID"));

            return $user ? \Static\Kernel::getValue(json_decode(htmlspecialchars_decode($user["others"]), true), "languages") : self::getLanguage();
        }

        public static function getLanguage() {
            return htmlspecialchars(self::$language);
        }

        public static function getAllLanguages() {
            return array("english", "french");
        }

        public static function getText($text, $decode = false, $parameters = array()) {
            $text = \Static\Kernel::getValue(self::$translations, $text);

            if(!is_array($parameters)) $parameters = array();

            $parameters["name"] = \Static\Kernel::getSettings("project-name");
            $parameters["link"] = \Static\Kernel::getSettings("settings-link");
            $parameters["email"] = \Static\Kernel::getSettings("settings-email");
            $parameters["contact"] = \Static\Kernel::getPath("/contact");
            $parameters["terms"] = \Static\Kernel::getPath("/terms");
            $parameters["privacy"] = \Static\Kernel::getPath("/privacy");

            foreach($parameters as $key => $value) $text = str_replace("@" . $key, htmlspecialchars($value), $text);

            return !$decode ? $text : htmlspecialchars_decode($text);
        }

    }

?>