<?php

    namespace Static\Requests;

    final class Tokens {

        public static function create() {
            return array(
                "token" => \Static\Models\Tokens::create(),
            );
        }

    }

?>