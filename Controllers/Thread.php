<?php

    namespace Static\Controllers;

    final class Thread extends Main {

        public static function start($parameters) {
            \Static\Kernel::addScript("/Public/Scripts/Thread.js");
            \Static\Kernel::addScript("/Public/Scripts/Create.js");

            $parameters["page"] = array_key_exists("page", $parameters) && (int)$parameters["page"] >= 1 ? (int)$parameters["page"] : 1;
            $parameters["limit"] = ceil(\Static\Models\Posts::count($parameters["link"]) / 10);

            $parameters["posts"] = \Static\Models\Posts::getPosts($parameters["link"], $parameters["page"]);

            if(!($parameters["title"] = \Static\Models\Threads::getTitle($parameters["link"])) || !count($parameters["posts"])) {
                header("Location: " . \Static\Kernel::getPath("/forums"));

                exit();
            }

            if($parameters["userID"] >= 1) $parameters["modals"] = array_merge($parameters["modals"], array("create"));

            $parameters["alerts"] = array_merge($parameters["alerts"], array(
                "thread-alert-report-success", "thread-alert-report-error",
                "thread-alert-delete-ask", "thread-alert-delete-success", "thread-alert-delete-error",
                "create-alert-title", "create-alert-message", "create-alert-success-post", "create-alert-error-post",
                "upload-alert-userID", "upload-alert-extension", "upload-alert-type", "upload-alert-size", "upload-alert-image", "upload-alert-success", "upload-alert-error",
            ));

            return $parameters;
        }

    }

?>