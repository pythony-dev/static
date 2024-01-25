<?php if(class_exists("\Static\Kernel")) {
    $themes = \Static\Kernel::getThemes();
    $theme = \Static\Kernel::getValue($_SESSION, array("theme", "color"));

    $colors = $themes["aqua"];

    if(array_key_exists($theme, $themes)) $colors = $themes[$theme];
    ?>

    .container {
        background-image : linear-gradient(#<?= $colors[0]; ?>7F, #<?= $colors[0]; ?>7F), url("<?= \Static\Kernel::getPath("/Public/Images/Index/Background.jpeg"); ?>");
    }

    .navbar {
        background-color : #<?= $colors[1]; ?>;
    }

    .button-normal {
        color : black;
        background-color : #<?= $colors[0]; ?>;
    } .button-normal:hover, .button-normal:focus {
        color : black;
        background-color : #<?= $colors[2]; ?>;
    }

    .button-outline {
        color : #<?= $colors[0]; ?>;
        background-color : black;
        border-color : #<?= $colors[0]; ?>;
    } .button-outline:hover, .button-outline:focus {
        color : black;
        background-color : #<?= $colors[1]; ?>;
    }

    .article, .line {
        background-color : #<?= $colors[0]; ?>;
    }

<?php } ?>