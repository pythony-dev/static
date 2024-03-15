<?php

    namespace Static\Requests;

    final class Welcome {

        public static function create() {
            $email = \Static\Kernel::getValue($_POST, "email");

            return \Static\Kernel::getRequest(\Static\Models\Welcome::create($email));
        }

    }

?>