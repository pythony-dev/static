<?php

    if(\Static\Models\Contact::create(\Static\Kernel::getValue($_POST, "email"), \Static\Kernel::getValue($_POST, "message"))) echo "true";

?>