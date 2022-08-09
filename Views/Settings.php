<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["getText"]("settings-title"); ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["getText"]("settings-content"); ?> </p>
    <ul class="m-5 nav nav-tabs nav-fill">
        <li class="nav-item">
            <button class="nav-link<?= $parameters["tabs"]["account"] ? " active" : null; ?>" data-bs-toggle="tab" data-bs-target="#settings-account-form"> <?= $parameters["getText"]("settings-account"); ?> </button>
        </li>
        <li class="nav-item">
            <button class="nav-link<?= $parameters["tabs"]["notifications"] ? " active" : null; ?>" data-bs-toggle="tab" data-bs-target="#settings-notifications-form"> <?= $parameters["getText"]("settings-notifications"); ?> </button>
        </li>
        <li class="nav-item">
            <button class="nav-link<?= $parameters["tabs"]["others"] ? " active" : null; ?>" data-bs-toggle="tab" data-bs-target="#settings-others-form"> <?= $parameters["getText"]("settings-others"); ?> </button>
        </li>
        <li class="nav-item">
            <button id="settings-logOut" class="nav-link"> <?= $parameters["getText"]("settings-logOut"); ?> </button>
        </li>
    </ul>
    <div class="px-5 tab-content">
        <form id="settings-account-form" class="tab-pane fade<?= $parameters["tabs"]["account"] ? " show active" : null; ?>">
            <div class="row mx-0 px-5">
                <div class="col-12 col-md-6 my-auto px-md-4 py-4">
                    <img id="settings-account-image" class="img-fluid shadow border rounded-circle pointer" src="<?= $parameters["getPath"]("/Public/Images/Users/" . $parameters["user"]["id"] . ".jpeg?" . time()); ?>" alt="<?= $parameters["getText"]("settings-account-user"); ?>"/>
                    <input id="settings-account-file" class="d-none" type="file" accept=".jpg, .jpeg, .png"/>
                    <div id="settings-account-spinner" class="d-none spinner-border"> </div>
                </div>
                <div class="col-12 col-md-6 my-auto px-md-4 py-4">
                    <input id="settings-account-email" class="my-5 form-control text-center" type="email" value="<?= $parameters["user"]["email"]; ?>" placeholder="<?= $parameters["getText"]("settings-account-email"); ?>" required/>
                    <input id="settings-account-username" class="my-5 form-control text-center" type="text" value="<?= $parameters["user"]["username"]; ?>" placeholder="<?= $parameters["getText"]("settings-account-username"); ?>" required/>
                    <input id="settings-account-confirm" class="my-5 form-control text-center" type="password" placeholder="<?= $parameters["getText"]("settings-account-confirm"); ?>" required/>
                    <input class="w-100 mb-5 btn btn-primary" type="submit" value="<?= $parameters["getText"]("settings-account-submit"); ?>"/>
                </div>
            </div>
        </form>
        <form id="settings-notifications-form" class="tab-pane fade<?= $parameters["tabs"]["notifications"] ? " show active" : null; ?>">
            <div class="py-5">
                <input id="settings-notifications-published" class="me-4 form-check-input" type="checkbox"<?= $parameters["notifications"]["published"] == "true" ? " checked" : null; ?>/>
                <label class="ps-4 form-check-label" for="settings-notifications-published"> <?= $parameters["getText"]("settings-notifications-published"); ?> </label>
            </div>
            <input id="settings-notifications-confirm" class="my-5 form-control text-center" type="password" placeholder="<?= $parameters["getText"]("settings-notifications-confirm"); ?>" required/>
            <input class="w-100 mb-5 btn btn-primary" type="submit" value="<?= $parameters["getText"]("settings-notifications-submit"); ?>"/>
        </form>
        <div id="settings-others-form" class="tab-pane fade<?= $parameters["tabs"]["others"] ? " show active" : null; ?>">
            <button class="w-100 my-5 btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#settings-others-change-modal"> <?= $parameters["getText"]("settings-others-change"); ?> </button>
            <button class="w-100 mb-5 btn btn-outline-danger" type="button" data-bs-toggle="modal" data-bs-target="#settings-others-delete-modal"> <?= $parameters["getText"]("settings-others-delete"); ?> </button>
        </div>
    </div>
</article>
<div id="settings-others-change-modal" class="modal fade p-5">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-md-5">
            <h3 class="p-5"> <?= $parameters["getText"]("settings-others-change"); ?> </h3>
            <form id="settings-others-change-form" class="px-5">
                <input id="settings-others-change-password" class="my-5 form-control text-center" type="password" placeholder="<?= $parameters["getText"]("settings-others-change-password"); ?>" required/>
                <input id="settings-others-change-confirm" class="my-5 form-control text-center" type="password" placeholder="<?= $parameters["getText"]("settings-others-change-confirm"); ?>" required/>
                <input class="w-100 mb-5 btn btn-primary" type="submit" value="<?= $parameters["getText"]("settings-others-change-submit"); ?>"/>
                <button class="w-100 mb-5 btn btn-outline-secondary" type="button" data-bs-dismiss="modal"> <?= $parameters["getText"]("settings-others-change-cancel"); ?> </button>
            </form>
        </div>
    </div>
</div>
<div id="settings-others-delete-modal" class="modal fade p-5">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-md-5">
            <h3 class="p-5"> <?= $parameters["getText"]("settings-others-delete"); ?> </h3>
            <form id="settings-others-delete-form" class="px-5">
                <input id="settings-others-delete-confirm" class="my-5 form-control text-center" type="password" placeholder="<?= $parameters["getText"]("settings-others-delete-confirm"); ?>" required/>
                <input class="w-100 mb-5 btn btn-danger" type="submit" value="<?= $parameters["getText"]("settings-others-delete-submit"); ?>"/>
                <button class="w-100 mb-5 btn btn-outline-secondary" type="button" data-bs-dismiss="modal"> <?= $parameters["getText"]("settings-others-delete-cancel"); ?> </button>
            </form>
        </div>
    </div>
</div>