<div id="search-modal" class="modal fade p-5">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content px-4 py-5">
            <h3 class="p-4"> <?= $parameters["getText"]("search-title"); ?> </h3>
            <p class="p-4 text-justify"> <?= $parameters["getText"]("search-content"); ?> </p>
            <div class="p-4">
                <div class="d-none">
                    <input id="search-block-src" value="<?= $parameters["getPath"]("/Public/Images/Icons/Block.png"); ?>"/>
                    <input id="search-block-alt" value="<?= $parameters["getText"]("search-block"); ?>"/>
                    <input id="search-chat-src" value="<?= $parameters["getPath"]("/Public/Images/Icons/Chat.png"); ?>"/>
                    <input id="search-chat-alt" value="<?= $parameters["getText"]("search-chat"); ?>"/>
                </div>
                <input id="search-username" class="form-control text-center" type="text" placeholder="<?= $parameters["getText"]("search-username"); ?>"/>
                <div id="search-spinner" class="d-none mt-4 spinner-border"> </div>
                <p id="search-empty" class="d-none pt-4 mb-0"> <?= $parameters["getText"]("search-empty"); ?> </p>
                <div id="search-list" class="d-none pt-4"> </div>
                <button class="w-100 mt-4 btn btn-outline-secondary" type="button" data-bs-dismiss="modal"> <?= $parameters["getText"]("search-cancel"); ?> </button>
            </div>
        </div>
    </div>
</div>