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
                array("modal", "#signUp-modal", "#navbar-signUp", "#signUp-cancel"),
                array("value", "#signUp-email", $id . "@" . end(explode("@", \Static\Settings::getSettings("email")))),
                array("modal", "#alert-signUp-confirmations-success", "#signUp-confirm", "#alert-signUp-confirmations-success-close"),
                array("continue", "#navbar-signUp"),
                array("wait", "#signUp-code"),
                array("value", "#signUp-username", $id),
                array("value", "#signUp-password", "123"),
                array("check", "#signUp-agree"),
                array("modal", "#alert-signUp-submit-success", "#signUp-submit", "#alert-signUp-submit-success-close"),
                array("click", "#navbar-logOut"),
                array("continue", "#logIn-cancel"),
                array("sleep"),
                array("modal", "#logIn-modal", "#navbar-logIn", "#logIn-cancel"),
                array("value", "#logIn-email", $id . "@" . end(explode("@", \Static\Settings::getSettings("email")))),
                array("value", "#logIn-password", "123"),
                array("click", "#logIn-submit"),
                array("click", "#navbar-logOut"),
                array("continue", "#logIn-cancel"),
                array("modal", "#reset-modal", "#logIn-reset", "#reset-cancel"),
                array("value", "#reset-email", $id . "@" . end(explode("@", \Static\Settings::getSettings("email")))),
                array("modal", "#alert-reset-confirmations-success", "#reset-confirm", "#alert-reset-confirmations-success-close"),
                array("continue", "#logIn-reset"),
                array("wait", "#reset-code"),
                array("value", "#reset-password", "123"),
                array("modal", "#alert-reset-submit-success", "#reset-submit", "#alert-reset-submit-success-close"),
                array("follow", "#home-top"),
                array("follow", "#navbar-home"),
                array("follow", "#home-bottom"),
                array("follow", "#navbar-forums"),
                array("modal", "#create-modal", "#forums-create", "#create-cancel"),
                array("value", "#create-title", "Hello World from " . \Static\Settings::getSettings("name") . " !"),
                array("value", "#create-message", "Hello, I am " . $id . " !"),
                array("click", "#create-submit"),
                array("modal", "#create-modal", "#thread-create", "#create-cancel"),
                array("value", "#create-message", "Hello, I am " . $id . " !"),
                array("click", "#create-submit"),
                array("modal", "#alert-thread-delete-ask", ".post-delete:first", "#alert-thread-delete-ask-close"),
                array("modal", "#alert-thread-delete-ask", ".post-delete:first", "#alert-thread-delete-ask-yes"),
                array("follow", "#navbar-forums"),
                array("modal", "#alert-forums-delete-ask", ".thread-delete:first", "#alert-forums-delete-ask-close"),
                array("modal", "#alert-forums-delete-ask", ".thread-delete:first", "#alert-forums-delete-ask-yes"),
                array("follow", ".thread-link:first"),
                array("click", ".post-chat:first"),
                array("follow", "#navbar-messages"),
                array("modal", "#search-modal", "#messages-search", "#search-cancel"),
                array("value", "#search-username", "Pythony"),
                array("sleep"),
                array("modal", "#alert-search-block-ask", ".user-block:first", "#alert-search-block-ask-close"),
                array("modal", "#alert-search-block-ask", ".user-block:first", "#alert-search-block-ask-yes"),
                array("click", ".user-chat:first"),
                array("modal", "#create-modal", "#chat-create", "#create-cancel"),
                array("value", "#create-message", "Hi Pythony, it\"s " . $id . " !"),
                array("click", "#create-submit"),
                array("value", "#create-message", "Hi Pythony, it\"s " . $id . " !"),
                array("click", "#create-submit"),
                array("modal", "#alert-chat-delete-ask", ".message-delete:first", "#alert-chat-delete-ask-close"),
                array("modal", "#alert-chat-delete-ask", ".message-delete:first", "#alert-chat-delete-ask-yes"),
                array("follow", "#navbar-messages"),
                array("modal", "#alert-messages-block-ask", ".user-block:first", "#alert-messages-block-ask-close"),
                array("modal", "#alert-messages-block-ask", ".user-block:first", "#alert-messages-block-ask-yes"),
                array("modal", "#alert-messages-delete-ask", ".user-delete:first", "#alert-messages-delete-ask-close"),
                array("modal", "#alert-messages-delete-ask", ".user-delete:first", "#alert-messages-delete-ask-yes"),
                array("follow", "#navbar-settings-account"),
                array("follow", "#navbar-settings-notifications"),
                array("follow", "#navbar-settings-others"),
                array("continue", "#settings-account-tab"),
                array("value", "#settings-account-email", $id . "@" . end(explode("@", \Static\Settings::getSettings("email")))),
                array("value", "#settings-account-username", $id),
                array("value", "#settings-account-language", "english"),
                array("value", "#settings-account-confirm", "123"),
                array("modal", "#alert-settings-account-success", "#settings-account-submit", "#alert-settings-account-success-close"),
                array("continue", "#settings-notifications-tab"),
                array("check", "#settings-notifications-message"),
                array("check", "#settings-notifications-published"),
                array("value", "#settings-notifications-confirm", "123"),
                array("modal", "#alert-settings-notifications-success", "#settings-notifications-submit", "#alert-settings-notifications-success-close"),
                array("continue", "#settings-others-tab"),
                array("value", "#settings-others-theme", "aqua"),
                array("check", "#settings-others-languages-english"),
                array("check", "#settings-others-languages-french"),
                array("check", "#settings-others-contact"),
                array("value", "#settings-others-confirm", "123"),
                array("modal", "#alert-settings-others-success", "#settings-others-submit", "#alert-settings-others-success-close"),
                array("click", "#settings-logOut"),
                array("value", "#logIn-email", $id . "@" . end(explode("@", \Static\Settings::getSettings("email")))),
                array("value", "#logIn-password", "123"),
                array("click", "#logIn-submit"),
                array("follow", "#navbar-settings-account"),
                array("modal", "#blocks-modal", "#settings-account-blocks", "#blocks-cancel"),
                array("follow", ".block-chat:first"),
                array("follow", "#navbar-settings-account"),
                array("modal", "#alert-blocks-ask", ".block-unblock:first", "#alert-blocks-ask-close"),
                array("modal", "#alert-blocks-ask", ".block-unblock:first", "#alert-blocks-ask-yes"),
                array("modal", "#change-modal", "#settings-account-change", "#change-cancel"),
                array("value", "#change-password", "123"),
                array("value", "#change-confirm", "123"),
                array("modal", "#alert-change-success", "#change-submit", "#alert-change-success-close"),
                array("modal", "#delete-modal", "#settings-account-delete", "#delete-cancel"),
                array("value", "#delete-confirm", "123"),
                array("modal", "#alert-delete-ask", "#delete-submit", "#alert-delete-ask-close"),
                array("modal", "#alert-delete-ask", "#delete-submit", "#alert-delete-ask-yes"),
                array("sleep"),
                array("click", "#alert-delete-success-close"),
            );

            return $parameters;
        }

    }

?>