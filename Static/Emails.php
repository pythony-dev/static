<?php

    namespace Static;

    final class Emails {

        public static function send($email, $subject, $message, $copy = false) {
            $email = htmlspecialchars($email);
            $subject = \Static\Languages\Translate::getText("project-name") . " - " . htmlspecialchars($subject);
            $message = htmlspecialchars_decode(\Static\Languages\Translate::getText("emails-start")) . $message . htmlspecialchars_decode(\Static\Languages\Translate::getText("emails-end"));
            $headers = htmlspecialchars_decode(\Static\Languages\Translate::getText("emails-" . ($copy ? "copy" : "header")));

            if(\Static\Models\Database::getEnvironment() == "production") return mail($email, $subject, $message, $headers);
            else if(\Static\Models\Database::getEnvironment() == "development") {
                print_r(array(
                    "email" => $email,
                    "subject" => $subject,
                    "message" => $message,
                    "headers" => $headers,
                ));

                return true;
            } else return false;
        }

        public static function contact($email, $message) {
            $title = \Static\Languages\Translate::getText("emails-contact-title");
            $content = htmlspecialchars_decode(\Static\Languages\Translate::getText("emails-contact-content-1"));
            $content .= htmlspecialchars($message);
            $content .= htmlspecialchars_decode(\Static\Languages\Translate::getText("emails-contact-content-2"));

            return self::send($email, $title, $content, true);
        }

        public static function signUp($email, $password) {
            $title = \Static\Languages\Translate::getText("emails-signUp-title");
            $content = htmlspecialchars_decode(\Static\Languages\Translate::getText("emails-signUp-content-1"));
            $content .= htmlspecialchars($email);
            $content .= htmlspecialchars_decode(\Static\Languages\Translate::getText("emails-signUp-content-2"));
            $content .= htmlspecialchars($password);
            $content .= htmlspecialchars_decode(\Static\Languages\Translate::getText("emails-signUp-content-3"));

            return self::send($email, $title, $content);
        }

        public static function reset($email, $password) {
            $title = \Static\Languages\Translate::getText("emails-reset-title");
            $content = htmlspecialchars_decode(\Static\Languages\Translate::getText("emails-reset-content-1"));
            $content .= htmlspecialchars($email);
            $content .= htmlspecialchars_decode(\Static\Languages\Translate::getText("emails-reset-content-2"));
            $content .= htmlspecialchars($password);
            $content .= htmlspecialchars_decode(\Static\Languages\Translate::getText("emails-reset-content-3"));

            return self::send($email, $title, $content);
        }

    }

?>