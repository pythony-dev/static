<?php

    namespace Static\Controllers;

    final class Chat extends Main {

        public static function start($parameters) {
            if($parameters["userID"] < 1) {
                header("Location: " . \Static\Kernel::getPath("/log-in"));

                exit();
            }

            \Static\Kernel::addScript("/Public/Scripts/Chat.js");
            \Static\Kernel::addScript("/Public/Scripts/Create.js");

            $parameters["title"] = $parameters["getText"]("chat-title") . " " . \Static\Kernel::getValue(\Static\Models\Users::getUser(\Static\Models\Users::getUserID($parameters["link"])), "username");

            $parameters["modals"] = array_merge($parameters["modals"], array("create"));

            $parameters["alerts"] = array_merge($parameters["alerts"], array(
                "chat-alert-message-error",
                "chat-alert-delete-ask", "chat-alert-delete-success", "chat-alert-delete-error",
                "create-alert-title", "create-alert-message", "create-alert-contact", "create-alert-blocked", "create-alert-success-message", "create-alert-error-message",
                "upload-alert-extension", "upload-alert-type", "upload-alert-size", "upload-alert-success", "upload-alert-error",
            ));

            return $parameters;
        }

    }

?>