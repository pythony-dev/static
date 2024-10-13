<?php

    namespace Static;

    final class Settings {

        private static $settings = array(
            "name" => "Static",
            "version" => "2.2.1",
            "static" => "2.2.1",

            "link" => "https://www.pythony.dev/Static",
            "email" => "hello@pythony.dev",
            "debug" => false,

            "salt" => "0123456789ABCDEF",
            "tests" => "FEDCBA9876543210",

            "host" => "Static",
            "database" => "Static",
            "username" => "Pythony",
            "password" => "Pythony123#",
            "prefix" => "Static",

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