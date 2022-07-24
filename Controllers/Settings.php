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

            $parameters["alerts"] = array_merge($parameters["alerts"], array(
                "settings-alert-user", "settings-alert-email", "settings-alert-username", "settings-alert-confirm", "settings-alert-success", "settings-alert-error",
                "settings-alert-change-user", "settings-alert-change-password", "settings-alert-change-confirm", "settings-alert-change-success", "settings-alert-change-error",
                "settings-alert-delete-user", "settings-alert-delete-confirm", "settings-alert-delete-success", "settings-alert-delete-error",
                "settings-alert-file-userID", "settings-alert-file-extension", "settings-alert-file-type", "settings-alert-file-size", "settings-alert-file-image", "settings-alert-file-success", "settings-alert-file-error",
            ));

            return $parameters;
        }

    }

?>