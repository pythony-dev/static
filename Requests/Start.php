<?php

    namespace Static\Requests;

    final class Start {

        public static function create() {
            $link = \Static\Kernel::getValue($_POST, "link");
            $referer = \Static\Kernel::getValue($_POST, "referer");

            \Static\Models\Sessions::create();
            \Static\Models\Views::create($link, $referer);

            return array();
        }

    }

?>