<?php

    namespace Static;

    final class Settings {

        private static $settings = array(
            "name" => "Static",
            "version" => "2.0.5",
            "static" => "2.0.5",

            "link" => "https://www.pythony.dev/Static",
            "email" => "hello@pythony.dev",
            "debug" => false,

            "salt" => "0123456789ABCDEF",

            "host" => "Static",
            "database" => "Static",
            "username" => "Pythony",
            "password" => "Pythony123#",

            "facebook" => "https://www.facebook.com",
            "instagram" => "https://www.instagram.com",
            "threads" => "https://www.threads.net",
            "youtube" => "https://www.youtube.com",
            "tiktok" => "https://www.tiktok.com",
        );

        public static function getSettings($settings) {
            $settings = \Static\Kernel::getValue(self::$settings, $settings);

            foreach(self::$settings as $key => $value) if(!in_array($key, array("hash", "host", "database", "username", "password"))) $settings = str_replace("@" . $key, htmlspecialchars($value), $settings);

            return $settings;
        }

    }

?>