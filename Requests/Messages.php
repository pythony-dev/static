<?php

    namespace Static\Requests;

    final class Messages {

        public static function getMessages() {
            $page = \Static\Kernel::getValue($_POST, "page");

            $response = \Static\Models\Messages::getMessages($page);

            return is_array($response) ? $response : array(
                "status" => $response,
            );
        }

        public static function getMessagesByUser() {
            $user = \Static\Kernel::getValue($_POST, "user");
            $page = \Static\Kernel::getValue($_POST, "page");

            $response = \Static\Models\Messages::getMessagesByUser($user, $page);

            return is_array($response) ? $response : array(
                "status" => $response,
            );
        }

        public static function create() {
            $link = \Static\Kernel::getValue($_POST, "link");
            $message = \Static\Kernel::getValue($_POST, "message");
            $image = \Static\Kernel::getValue($_POST, "image");

            $response = \Static\Models\Messages::create($link, $message, $image);

            return is_array($response) ? $response : array(
                "status" => $response,
            );
        }

        public static function deleteByUser() {
            $user = \Static\Kernel::getValue($_POST, "user");

            return array(
                "status" => \Static\Models\Messages::deleteByUser($user),
            );
        }

        public static function delete() {
            $message = \Static\Kernel::getValue($_POST, "message");

            return array(
                "status" => \Static\Models\Messages::delete($message),
            );
        }

    }

?>