
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
        background-color : #<?= $colors[\Static\Kernel::isLight() ? 2 : 1]; ?>;
        border-color : #<?= $colors[0]; ?> !important;
    }

    .dropdown-item.active, .dropdown-item:active {
        background-color : #<?= $colors[0]; ?>;
    }

    .button-classic {
        color : <?= \Static\Kernel::isLight() ? "white" : "black"; ?>;
        background-color : #<?= $colors[0]; ?>;
    } .button-classic:hover, .button-classic:focus {
        color : <?= \Static\Kernel::isLight() ? "white" : "black"; ?> !important;
        background-color : #<?= $colors[\Static\Kernel::isLight() ? 1 : 2]; ?> !important;
        border-color : #<?= $colors[\Static\Kernel::isLight() ? 1 : 2]; ?> !important;
    }

    .button-outline {
        color : #<?= $colors[0]; ?> !important;
        background-color : <?= \Static\Kernel::isLight() ? "white" : "black"; ?> !important;
        border-color : #<?= $colors[0]; ?> !important;
    } .button-outline:hover, .button-outline:focus {
        color : <?= \Static\Kernel::isLight() ? "white" : "black"; ?> !important;
        background-color : #<?= $colors[\Static\Kernel::isLight() ? 2 : 1]; ?> !important;
        border-color : <?= \Static\Kernel::isLight() ? "white" : "black"; ?> !important;
    }

    .form-control, .form-select {
        background-color : <?= \Static\Kernel::isLight() ? "white" : "black"; ?> !important;
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
        color : #<?= $colors[\Static\Kernel::isLight() ? 1 : 2]; ?>;
    } .page-item.active .page-link {
        color : <?= \Static\Kernel::isLight() ? "white" : "black"; ?>;
        background-color : #<?= $colors[0]; ?>;
        border-color : #<?= $colors[0]; ?>;
    }

    .form-check-input:checked {
        background-color : #<?= $colors[0]; ?>;
        border-color : #<?= $colors[0]; ?>;
    }

<?php } ?>