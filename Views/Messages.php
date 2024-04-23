<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["getText"]("messages-title"); ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["getText"]("messages-content"); ?> </p>
    <div class="p-5">
        <button class="w-100 btn rounded-pill button-classic" data-bs-toggle="modal" data-bs-target="#search-modal"> <?= $parameters["getText"]("messages-search"); ?> </button>
    </div>
    <div id="messages-list" class="p-5">
        <div class="d-none">
            <input id="messages-page" value="0"/>
            <input id="messages-by" value="<?= $parameters["getText"]("messages-by"); ?>"/>
            <input id="messages-on" value="<?= $parameters["getText"]("messages-on"); ?>"/>
            <input id="messages-at" value="<?= $parameters["getText"]("messages-at"); ?>"/>
            <input id="messages-messages" value="<?= $parameters["getText"]("messages-messages"); ?>"/>
            <input id="messages-block-src" value="<?= $parameters["getPath"]("/Public/Images/Icons/" . (\Static\Kernel::isLight() ? "Light" : "Dark") . "/Block.png"); ?>"/>
            <input id="messages-block-alt" value="<?= $parameters["getText"]("messages-block"); ?>"/>
            <input id="messages-delete-src" value="<?= $parameters["getPath"]("/Public/Images/Icons/" . (\Static\Kernel::isLight() ? "Light" : "Dark") . "/Delete.png"); ?>"/>
            <input id="messages-delete-alt" value="<?= $parameters["getText"]("messages-delete"); ?>"/>
        </div>
        <p id="messages-empty" class="mb-0"> <?= $parameters["getText"]("messages-empty"); ?> </p>
    </div>
    <div class="p-5">
        <button id="messages-more" class="w-100 btn rounded-pill button-classic"> <?= $parameters["getText"]("messages-more"); ?> </button>
        <div id="messages-spinner" class="d-none spinner-border"> </div>
    </div>
</article>