<?php

    namespace Static\Requests;

    final class Tokens {

        public static function create() {
            return array(
                "status" => "success",
                "token" => \Static\Models\Tokens::create(),
            );
        }

    }

?>