<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 id="chat-title" class="p-5 fw-bold"> <?= $parameters["title"]; ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["getText"]("chat-content"); ?> </p>
    <div id="chat-list" class="p-5">
        <div class="d-none">
            <input id="chat-user" value="<?= $parameters["link"]; ?>"/>
            <input id="chat-page" value="0"/>
            <input id="chat-by" value="<?= $parameters["getText"]("chat-by"); ?>"/>
            <input id="chat-on" value="<?= $parameters["getText"]("chat-on"); ?>"/>
            <input id="chat-at" value="<?= $parameters["getText"]("chat-at"); ?>"/>
            <input id="chat-delete-src" value="<?= $parameters["getPath"]("/Public/Images/Icons/Delete.png"); ?>"/>
            <input id="chat-delete-alt" value="<?= $parameters["getText"]("chat-delete"); ?>"/>
        </div>
        <p id="chat-empty" class="mb-0"> <?= $parameters["getText"]("chat-empty"); ?> </p>
    </div>
    <div class="p-5">
        <button id="chat-more" class="w-100 mb-5 btn btn-primary"> <?= $parameters["getText"]("chat-more"); ?> </button>
        <div id="chat-spinner" class="d-none mb-5 spinner-border"> </div>
        <button class="w-100 btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#create-modal"> <?= $parameters["getText"]("chat-create"); ?> </button>
        <a class="w-100 mt-5 btn btn-outline-secondary" href="<?= $parameters["getPath"]("/messages"); ?>"> <?= $parameters["getText"]("chat-back"); ?> </a>
    </div>
</article>