<?php

    namespace Static\Requests;

    final class Confirmations {

        public static function create() {
            $email = \Static\Kernel::getValue($_POST, "email");
            $used = \Static\Kernel::getValue($_POST, "used") == "true" ? true : false;

            return \Static\Kernel::getRequest(\Static\Models\Confirmations::create($email, $used));
        }

    }

?>