<?php

    namespace Static\Requests;

    final class Tasks {

        public static function create() {
            return \Static\Kernel::getRequest(\Static\Models\Tasks::create());
        }

    }

?>