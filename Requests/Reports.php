<?php

    namespace Static\Requests;

    final class Reports {

        public static function create() {
            $setting = \Static\Kernel::getValue($_POST, "setting");
            $value = \Static\Kernel::getValue($_POST, "value");

            return array(
                "status" => \Static\Models\Reports::create($setting, $value),
            );
        }

    }

?>