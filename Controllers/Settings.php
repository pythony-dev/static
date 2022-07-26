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

            $parameters["notifications"] = json_decode(htmlspecialchars_decode($parameters["user"]["notifications"]), true);

            $parameters["alerts"] = array_merge($parameters["alerts"], array(
                "settings-alert-account-email", "settings-alert-account-username", "settings-alert-account-confirm", "settings-alert-account-success", "settings-alert-account-error",
                "settings-alert-notifications-confirm", "settings-alert-notifications-success", "settings-alert-notifications-error",
                "settings-alert-others-change-password", "settings-alert-others-change-confirm", "settings-alert-others-change-success", "settings-alert-others-change-error",
                "settings-alert-others-delete-ask", "settings-alert-others-delete-confirm", "settings-alert-others-delete-success", "settings-alert-others-delete-error",
                "settings-alert-file-userID", "settings-alert-file-extension", "settings-alert-file-type", "settings-alert-file-size", "settings-alert-file-image", "settings-alert-file-success", "settings-alert-file-error",
            ));

            return $parameters;
        }

    }

?>