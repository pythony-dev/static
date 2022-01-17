<?php

    namespace Static;

    final class Emails {

        public static function send($email, $subject, $message, $copy = false) {
            if(!in_array(\Static\Models\Database::getEnvironment(), array("production"))) return true;
            else return mail(htmlspecialchars($email), \Static\Languages\Translate::getText("project-name") . " - " . htmlspecialchars($subject), htmlspecialchars($message) . \Static\Languages\Translate::getText("emails-footer"), \Static\Languages\Translate::getText("emails-" . ($copy ? "copy" : "header")));
        }

        public static function contact($email, $message) {
            $title = \Static\Languages\Translate::getText("emails-contact-title");
            $content = \Static\Languages\Translate::getText("emails-contact-content-1") . $message . \Static\Languages\Translate::getText("emails-contact-content-2");

            return self::send($email, $title, $content);
        }

        public static function signUp($email, $password) {
            $title = \Static\Languages\Translate::getText("emails-signUp-title");
            $content = \Static\Languages\Translate::getText("emails-signUp-content-1") . $email . \Static\Languages\Translate::getText("emails-signUp-content-2") . $password . \Static\Languages\Translate::getText("emails-signUp-content-3");

            return self::send($email, $title, $content);
        }

        public static function reset($email, $password) {
            $title = \Static\Languages\Translate::getText("emails-reset-title");
            $content = \Static\Languages\Translate::getText("emails-reset-content-1") . $email . \Static\Languages\Translate::getText("emails-reset-content-2") . $password . \Static\Languages\Translate::getText("emails-reset-content-3");

            return self::send($email, $title, $content);
        }

    }

?>