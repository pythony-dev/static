<?php

    namespace Static\Controllers;

    final class Tests extends Main {

        public static function start($parameters) {
            if(!array_key_exists(\Static\Settings::getSettings("tests"), $_GET)) {
                $_SESSION["tests"] = null;

                header("Location: " . \Static\Kernel::getPath("/"));

                exit();
            }

            session_unset();

            $id = "";

            while(strlen($id) != 16) {
                $random = rand(0, 35);

                if($random <= 9) $id .= $random;
                else $id .= chr($random + 55);
            }

            $_SESSION["tests"] = $id;

            $parameters["tests"] = array(
                array("follow", "#navbar-home"),
                array("modal", "#signUp-modal", "#home-top", "#signUp-cancel"),
                array("modal", "#signUp-modal", "#home-bottom", "#signUp-cancel"),
                array("follow", "#navbar-features"),
                array("follow", "#navbar-news"),
                array("follow", "#news-next"),
                array("follow", "#news-end"),
                array("follow", "#news-previous"),
                array("follow", "#news-start"),
                array("follow", ".article-link:first"),
                array("follow", ".article-link:first"),
                array("follow", "#navbar-forums"),
                array("modal", "#alert-forums-report-success", ".thread-report:first", "#alert-forums-report-success-close"),
                array("modal", "#signUp-modal", "#forums-signUp", "#signUp-cancel"),
                array("follow", ".thread-link:first"),
                array("modal", "#alert-thread-report-success", ".post-report:first", "#alert-thread-report-success-close"),
                array("modal", "#signUp-modal", "#thread-signUp", "#signUp-cancel"),
                array("follow", "#navbar-contact"),
                array("value", "#contact-email", $id . "@" . end(explode("@", \Static\Settings::getSettings("email")))),
                array("value", "#contact-message", "Hello World !"),
                array("modal", "#alert-contact-success", "#contact-submit", "#alert-contact-success-close"),
                array("click", "#language-french"),
                array("click", "#language-english"),
                array("click", "#theme-blueberry"),
                array("click", "#theme-grape"),
                array("click", "#theme-magenta"),
                array("click", "#theme-strawberry"),
                array("click", "#theme-maraschino"),
                array("click", "#theme-tangerine"),
                array("click", "#theme-lemon"),
                array("click", "#theme-lime"),
                array("click", "#theme-spring"),
                array("click", "#theme-foam"),
                array("click", "#theme-turquoise"),
                array("click", "#theme-aqua"),
                array("follow", "#footer-icon"),
                array("follow", "#footer-terms"),
                array("follow", "#terms-home"),
                array("follow", "#footer-privacy"),
                array("follow", "#privacy-home"),
                array("follow", "#footer-siteMap"),
                array("follow", "#siteMap-welcome"),
                array("value", "#welcome-email", $id . "@" . end(explode("@", \Static\Settings::getSettings("email")))),
                array("modal", "#alert-welcome-success", "#welcome-submit", "#alert-welcome-success-close"),
                array("follow", "#navbar-icon"),
            );

            return $parameters;
        }

    }

?>