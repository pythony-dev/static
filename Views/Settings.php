<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["getText"]("settings-title"); ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["getText"]("settings-content"); ?> </p>
    <div class="row mx-0 px-5">
        <div class="col-12 col-md-6 my-auto px-md-4 py-4">
            <img id="settings-image" class="img-fluid shadow border rounded-circle pointer" src="<?= $parameters["getPath"]("/Public/Images/Users/" . $parameters["user"]["id"] . ".jpeg?" . time()); ?>" alt="<?= $parameters["getText"]("settings-user"); ?>"/>
            <input id="settings-file" class="d-none" type="file" accept=".jpg, .jpeg, .png"/>
        </div>
        <form id="settings-form" class="col-12 col-md-6 my-auto px-md-4 py-4">
            <input id="settings-email" class="my-5 form-control text-center" type="email" value="<?= $parameters["user"]["email"]; ?>" placeholder="<?= $parameters["getText"]("settings-email"); ?>" required/>
            <input id="settings-username" class="my-5 form-control text-center" type="text" value="<?= $parameters["user"]["username"]; ?>" placeholder="<?= $parameters["getText"]("settings-username"); ?>" required/>
            <input id="settings-confirm" class="my-5 form-control text-center" type="password" placeholder="<?= $parameters["getText"]("settings-confirm"); ?>" required/>
            <input class="w-100 btn btn-primary" type="submit" value="<?= $parameters["getText"]("settings-submit"); ?>"/>
            <button class="w-100 my-5 btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#settings-change-modal"> <?= $parameters["getText"]("settings-change"); ?> </button>
            <button class="w-100 mb-5 btn btn-outline-danger" type="button" data-bs-toggle="modal" data-bs-target="#settings-delete-modal"> <?= $parameters["getText"]("settings-delete"); ?> </button>
        </form>
    </div>
</article>
<div id="settings-change-modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-5">
            <h3 class="p-5"> <?= $parameters["getText"]("settings-change"); ?> </h3>
            <form id="settings-change-form" class="px-5">
                <input id="settings-change-password" class="my-5 form-control text-center" type="password" placeholder="<?= $parameters["getText"]("settings-change-password"); ?>" required/>
                <input id="settings-change-confirm" class="my-5 form-control text-center" type="password" placeholder="<?= $parameters["getText"]("settings-change-confirm"); ?>" required/>
                <input class="w-100 mb-5 btn btn-primary" type="submit" value="<?= $parameters["getText"]("settings-change-submit"); ?>"/>
            </form>
        </div>
    </div>
</div>
<div id="settings-delete-modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-5">
            <h3 class="p-5"> <?= $parameters["getText"]("settings-delete"); ?> </h3>
            <form id="settings-delete-form" class="px-5">
                <input id="settings-delete-confirm" class="my-5 form-control text-center" type="password" placeholder="<?= $parameters["getText"]("settings-delete-confirm"); ?>" required/>
                <input class="w-100 mb-5 btn btn-danger" type="submit" value="<?= $parameters["getText"]("settings-delete-submit"); ?>"/>
            </form>
        </div>
    </div>
</div>