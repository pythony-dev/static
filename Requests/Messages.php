<?php

    namespace Static\Requests;

    final class Messages {

        public static function getMessages() {
            $page = \Static\Kernel::getValue($_POST, "page");

            return \Static\Kernel::getRequest(\Static\Models\Messages::getMessages($page));
        }

        public static function getMessagesByUser() {
            $user = \Static\Kernel::getValue($_POST, "user");
            $page = \Static\Kernel::getValue($_POST, "page");

            return \Static\Kernel::getRequest(\Static\Models\Messages::getMessagesByUser($user, $page));
        }

        public static function create() {
            $link = \Static\Kernel::getValue($_POST, "link");
            $message = \Static\Kernel::getValue($_POST, "message");
            $image = \Static\Kernel::getValue($_POST, "image");

            return \Static\Kernel::getRequest(\Static\Models\Messages::create($link, $message, $image));
        }

        public static function deleteChat() {
            $user = \Static\Kernel::getValue($_POST, "user");

            return \Static\Kernel::getRequest(\Static\Models\Messages::deleteChat($user));
        }

        public static function delete() {
            $message = \Static\Kernel::getValue($_POST, "message");

            return \Static\Kernel::getRequest(\Static\Models\Messages::delete($message));
        }

    }

?>