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
        background-color : #<?= $colors[2]; ?>;
        border-color : #<?= $colors[0]; ?> !important;
    }

    .dropdown-item.active, .dropdown-item:active {
        background-color : #<?= $colors[0]; ?>;
    }

    .button-classic {
        color : white;
        background-color : #<?= $colors[0]; ?>;
    } .button-classic:hover, .button-classic:focus {
        color : white;
        background-color : #<?= $colors[1]; ?>;
    }

    .button-outline {
        color : #<?= $colors[0]; ?>;
        background-color : white;
        border-color : #<?= $colors[0]; ?>;
    } .button-outline:hover, .button-outline:focus {
        color : white !important;
        background-color : #<?= $colors[2]; ?> !important;
        border-color : white !important;
    }

    .text-decoration-none {
        color : #<?= $colors[0]; ?>;
    }

    .article, .line {
        background-color : #<?= $colors[0]; ?>;
    }

    .page-link {
        color : #<?= $colors[0]; ?>;
    } .page-link:hover, .page-link:focus {
        color : #<?= $colors[1]; ?>;
    } .page-item.active .page-link {
        color : white;
        background-color : #<?= $colors[0]; ?>;
        border-color : #<?= $colors[0]; ?>;
    }

    .form-check-input:checked {
        background-color : #<?= $colors[0]; ?>;
        border-color : #<?= $colors[0]; ?>;
    } 

<?php } ?>