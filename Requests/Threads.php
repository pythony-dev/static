<?php

    namespace Static\Requests;

    final class Threads {

        public static function create() {
            $title = \Static\Kernel::getValue($_POST, "title");
            $message = \Static\Kernel::getValue($_POST, "message");
            $image = \Static\Kernel::getValue($_POST, "image");

            $response = \Static\Models\Threads::create($title, $message, $image);

            return is_array($response) ? $response : array(
                "status" => $response,
            );
        }

        public static function delete() {
            $thread = \Static\Kernel::getValue($_POST, "thread");

            return array(
                "status" => \Static\Models\Threads::delete($thread),
            );
        }

    }

?>