<?php

    namespace Static\Requests;

    final class Posts {

        public static function create() {
            $link = \Static\Kernel::getValue($_POST, "link");
            $message = \Static\Kernel::getValue($_POST, "message");
            $image = \Static\Kernel::getValue($_POST, "image");

            return \Static\Kernel::getRequest(\Static\Models\Posts::create($link, $message, $image));
        }

        public static function delete() {
            $post = \Static\Kernel::getValue($_POST, "post");

            return \Static\Kernel::getRequest(\Static\Models\Posts::delete($post));
        }

    }

?>