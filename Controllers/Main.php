<?php

    namespace Static\Controllers;

    abstract class Main {

        static public function start($parameters) {
            \Static\Kernel::addStyle("https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css");
            \Static\Kernel::addStyle("/Public/Styles/Index.css");

            \Static\Kernel::addScript("https://code.jquery.com/jquery-3.5.0.min.js");
            \Static\Kernel::addScript("https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js");
            \Static\Kernel::addScript("/Public/Scripts/Index.js");

            $parameters["modals"] = array();
            $parameters["alerts"] = array("index-alert-token", "index-alert-language", "index-alert-theme", "index-alert-logOut");

            if($parameters["userID"] <= 0) {
                \Static\Kernel::addScript("/Public/Scripts/SignUp.js");
                \Static\Kernel::addScript("/Public/Scripts/LogIn.js");
                \Static\Kernel::addScript("/Public/Scripts/Reset.js");

                $parameters["modals"] = array_merge($parameters["modals"], array("signUp", "logIn", "reset"));
                $parameters["alerts"] = array_merge($parameters["alerts"], array(
                    "signUp-alert-submit-confirm", "signUp-alert-submit-email", "signUp-alert-submit-code", "signUp-alert-submit-username", "signUp-alert-submit-password", "signUp-alert-submit-success", "signUp-alert-submit-error",
                    "signUp-alert-confirmations-email", "signUp-alert-confirmations-success", "signUp-alert-confirmations-error",
                    "logIn-alert-email", "logIn-alert-password", "logIn-alert-error",
                    "reset-alert-submit-confirm", "reset-alert-submit-email", "reset-alert-submit-code", "reset-alert-submit-password", "reset-alert-submit-success", "reset-alert-submit-error",
                    "reset-alert-confirmations-email", "reset-alert-confirmations-success", "reset-alert-confirmations-error",
                ));
            }

            if($_SESSION["tests"] || \Static\Kernel::getRoute() == "Tests") {
                \Static\Kernel::addScript("/Public/Scripts/Tests.js");

                $parameters["alerts"] = array_merge($parameters["alerts"], array("index-alert-tests-success", "index-alert-tests-error"));
            }

            return $parameters;
        }

    }

?>