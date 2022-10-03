<?php

    namespace Static\Requests;

    final class Threads {

        public static function create() {
            $title = \Static\Kernel::getValue($_POST, "title");
            $message = \Static\Kernel::getValue($_POST, "message");
            $image = \Static\Kernel::getValue($_POST, "image");

            return \Static\Kernel::getRequest(\Static\Models\Threads::create($title, $message, $image));
        }

        public static function delete() {
            $thread = \Static\Kernel::getValue($_POST, "thread");

            return \Static\Kernel::getRequest(\Static\Models\Threads::delete($thread));
        }

    }

?>