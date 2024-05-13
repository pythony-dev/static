<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 id="chat-title" class="p-5 fw-bold"> <?= $parameters["title"]; ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["getText"]("chat-content"); ?> </p>
    <div class="p-5">
        <button class="w-100 btn rounded-pill button-classic" data-bs-toggle="modal" data-bs-target="#create-modal"> <?= $parameters["getText"]("chat-create"); ?> </button>
    </div>
    <div id="chat-list" class="p-5">
        <div class="d-none">
            <input id="chat-user" value="<?= $parameters["link"]; ?>"/>
            <input id="chat-page" value="0"/>
            <input id="chat-by" value="<?= $parameters["getText"]("chat-by"); ?>"/>
            <input id="chat-on" value="<?= $parameters["getText"]("chat-on"); ?>"/>
            <input id="chat-at" value="<?= $parameters["getText"]("chat-at"); ?>"/>
            <input id="chat-delete" value="<?= $parameters["getText"]("chat-delete"); ?>"/>
        </div>
        <p id="chat-empty" class="mb-0"> <?= $parameters["getText"]("chat-empty"); ?> </p>
    </div>
    <div class="p-5">
        <button id="chat-more" class="w-100 btn rounded-pill button-classic"> <?= $parameters["getText"]("chat-more"); ?> </button>
        <div id="chat-spinner" class="d-none spinner-border"> </div>
    </div>
</article>