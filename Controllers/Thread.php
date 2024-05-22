<?php

    namespace Static\Controllers;

    final class Thread extends Main {

        public static function start($parameters) {
            \Static\Kernel::addScript("/Public/Scripts/Thread.js");

            $parameters["page"] = array_key_exists("page", $parameters) ? (int)$parameters["page"] : 1;
            $parameters["limit"] = ceil(\Static\Models\Posts::count($parameters["link"]) / 10);

            $parameters["posts"] = \Static\Models\Posts::getPosts($parameters["link"], $parameters["page"]);

            if($parameters["page"] > $parameters["limit"] || $parameters["page"] < 1 || !($parameters["title"] = \Static\Models\Threads::getID($parameters["link"], true))) {
                header("Location: " . \Static\Kernel::getPath("/forums"));

                exit();
            } else if($parameters["userID"] >= 1) {
                \Static\Kernel::addScript("/Public/Scripts/Create.js");

                $parameters["modals"] = array_merge($parameters["modals"], array("create"));
            }

            $parameters["alerts"] = array_merge($parameters["alerts"], array(
                "thread-alert-report-success", "thread-alert-report-error",
                "thread-alert-delete-ask", "thread-alert-delete-error",
                "create-alert-error-post",
                "upload-alert-extension", "upload-alert-type", "upload-alert-size", "upload-alert-success", "upload-alert-error",
            ));

            return $parameters;
        }

    }

?>