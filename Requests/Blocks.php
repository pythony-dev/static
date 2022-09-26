<?php

    namespace Static\Requests;

    final class Blocks {

        public static function create() {
            $user = \Static\Kernel::getValue($_POST, "user");

            return array(
                "status" => \Static\Models\Blocks::create($user),
            );
        }

        public static function delete() {
            $user = \Static\Kernel::getValue($_POST, "user");

            return array(
                "status" => \Static\Models\Blocks::delete($user),
            );
        }

    }

?>