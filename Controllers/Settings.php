<?php

    namespace Static\Controllers;

    final class Settings extends Main {

        public static function start($parameters) {
            if($parameters["userID"] < 1) {
                header("Location: " . \Static\Kernel::getPath("/log-in"));

                exit();
            }

            \Static\Kernel::addScript(\Static\Kernel::getPath("/Public/Scripts/Settings.js"));

            $parameters["user"] = \Static\Models\Users::getUser();
            $parameters["alerts"] = array_merge($parameters["alerts"], array("settings-alert-user", "settings-alert-invalid", "settings-alert-password", "settings-alert-success", "settings-alert-error", "settings-alert-change-user", "settings-alert-change-invalid", "settings-alert-change-password", "settings-alert-change-success", "settings-alert-change-error", "settings-alert-file-userID", "settings-alert-file-extension", "settings-alert-file-type", "settings-alert-file-size", "settings-alert-file-success", "settings-alert-file-image", "settings-alert-file-error"));

            return $parameters;
        }

    }

?>