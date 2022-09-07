<?php

    namespace Static\Requests;

    final class Posts {

        public static function create() {
            $link = \Static\Kernel::getValue($_POST, "link");
            $message = \Static\Kernel::getValue($_POST, "message");
            $image = \Static\Kernel::getValue($_POST, "image");

            $response = \Static\Models\Posts::create($link, $message, $image);

            return is_array($response) ? $response : array(
                "status" => $response,
            );
        }

        public static function delete() {
            $post = \Static\Kernel::getValue($_POST, "post");

            return array(
                "status" => \Static\Models\Posts::delete($post),
            );
        }

    }

?>