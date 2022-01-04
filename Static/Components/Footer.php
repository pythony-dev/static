<?php

    namespace Static\Components;

    final class Footer {

        static function create() {
            $getText = \Static\Kernel::getParameters()["getText"];

            ob_start();
            ?>

            <footer class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5"> Copyright © 2022 <?= $getText("project-name") . " - " . $getText("footer"); ?> - Version 1.0.0 </footer>

            <?php
            $component = ob_get_contents();
            ob_end_clean();

            return $component;
        }

    }

?>