<?php

    namespace Static\Languages;

    final class Translate {

        protected static $language = "";
        protected static $translations = array();

        public static function setLanguage() {
            foreach(self::getAllLanguages() as $language) {
                if(array_key_exists($language, $_GET)) $_SESSION["language"] = $language;
            }

            if(array_key_exists("language", $_SESSION) && in_array($_SESSION["language"], self::getAllLanguages())) self::$language = htmlspecialchars($_SESSION["language"]);
            else self::$language = "english";

            $file = "Languages/" . ucfirst(self::$language) . ".json";

            if(file_exists($file)) self::$translations = (array)json_decode(file_get_contents($file));
            else \Static\Kernel::setError(404, "No Language : " . $file);
        }

        public static function getLanguage() {
            return self::$language;
        }

        public static function getAllLanguages() {
            return array("english", "french");
        }

        public static function getText($text, $parameters = null) {
            $text = \Static\Kernel::getValue(self::$translations, $text);

            if(!is_array($parameters)) return $text;

            foreach($parameters as $key => $value) $text = str_replace("@" . $key, htmlspecialchars($value), $text);

            return $text;
        }

    }

?>