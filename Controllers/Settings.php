<?php

    namespace Static\Controllers;

    final class Settings extends Main {

        public static function start($parameters) {
            if($parameters["userID"] <= 0 || !($parameters["user"] = \Static\Models\Users::getUser($parameters["userID"]))) {
                $_SESSION["userID"] = 0;

                header("Location: " . \Static\Kernel::getPath("/log-in"));

                exit();
            }

            \Static\Kernel::addScript("/Public/Scripts/Settings.js");
            \Static\Kernel::addScript("/Public/Scripts/Blocks.js");
            \Static\Kernel::addScript("/Public/Scripts/Change.js");
            \Static\Kernel::addScript("/Public/Scripts/Delete.js");

            $parameters["user"]["notifications"] = json_decode(htmlspecialchars_decode($parameters["user"]["notifications"]), true);
            $parameters["user"]["others"] = json_decode(htmlspecialchars_decode($parameters["user"]["others"]), true);

            $parameters["notifications"] = array("message", "published");
            $parameters["blocks"] = \Static\Models\Blocks::getBlocks();

            $parameters["tabs"] = array(
                "account" => !array_key_exists("notifications", $_GET) && !array_key_exists("others", $_GET),
                "notifications" => array_key_exists("notifications", $_GET),
                "others" => array_key_exists("others", $_GET),
            );

            $parameters["modals"] = array_merge($parameters["modals"], array("blocks", "change", "delete"));
            $parameters["alerts"] = array_merge($parameters["alerts"], array(
                "settings-alert-account-email", "settings-alert-account-username", "settings-alert-account-confirm", "settings-alert-account-success", "settings-alert-account-error",
                "settings-alert-notifications-confirm", "settings-alert-notifications-success", "settings-alert-notifications-error",
                "settings-alert-others-languages", "settings-alert-others-confirm", "settings-alert-others-success", "settings-alert-others-error",
                "upload-alert-extension", "upload-alert-type", "upload-alert-size", "upload-alert-success", "upload-alert-error",
                "blocks-alert-ask", "blocks-alert-error",
                "change-alert-password", "change-alert-confirm", "change-alert-success", "change-alert-error",
                "delete-alert-ask", "delete-alert-confirm", "delete-alert-success", "delete-alert-error",
            ));

            return $parameters;
        }

    }

?>