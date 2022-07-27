<?php

    namespace Static\Controllers;

    final class Settings extends Main {

        public static function start($parameters) {
            if($parameters["userID"] < 1 || !($parameters["user"] = \Static\Models\Users::getUser())) {
                $_SESSION["userID"] = 0;

                header("Location: " . \Static\Kernel::getPath("/log-in"));

                exit();
            }

            \Static\Kernel::addScript(\Static\Kernel::getPath("/Public/Scripts/Settings.js"));

            $parameters["tabs"] = array(
                "account" => !array_key_exists("notifications", $_GET) && !array_key_exists("others", $_GET),
                "notifications" => array_key_exists("notifications", $_GET),
                "others" => array_key_exists("others", $_GET),
            );
            $parameters["notifications"] = json_decode(htmlspecialchars_decode($parameters["user"]["notifications"]), true);

            $parameters["alerts"] = array_merge($parameters["alerts"], array(
                "settings-alert-account-email", "settings-alert-account-username", "settings-alert-account-confirm", "settings-alert-account-success", "settings-alert-account-error",
                "settings-alert-account-file-userID", "settings-alert-account-file-extension", "settings-alert-account-file-type", "settings-alert-account-file-size", "settings-alert-account-file-image", "settings-alert-account-file-success", "settings-alert-account-file-error",
                "settings-alert-notifications-confirm", "settings-alert-notifications-success", "settings-alert-notifications-error",
                "settings-alert-others-change-password", "settings-alert-others-change-confirm", "settings-alert-others-change-success", "settings-alert-others-change-error",
                "settings-alert-others-delete-ask", "settings-alert-others-delete-confirm", "settings-alert-others-delete-success", "settings-alert-others-delete-error",
            ));

            return $parameters;
        }

    }

?>