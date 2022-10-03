<?php

    namespace Static\Requests;

    final class Reports {

        public static function create() {
            $setting = \Static\Kernel::getValue($_POST, "setting");
            $value = \Static\Kernel::getValue($_POST, "value");

            return \Static\Kernel::getRequest(\Static\Models\Reports::create($setting, $value));
        }

    }

?>