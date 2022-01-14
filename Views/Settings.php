<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["getText"]("settings-title"); ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["getText"]("settings-content"); ?> </p>
    <div class="row px-5">
        <div class="col-12 col-md-6 p-5 my-auto">
            <img id="settings-image" class="img-fluid shadow border rounded-circle pointer" src="<?= $parameters["getPath"]("/Public/Images/Users/" . $parameters["user"]["ID"] . ".png"); ?>" alt="<?= $parameters["getText"]("settings-user"); ?>"/>
            <input id="settings-file" class="d-none" type="file" accept=".png, .jpg, .jpeg"/>
        </div>
        <form id="settings-form" class="col-12 col-md-6 p-5 my-auto">
            <input id="settings-email" class="my-5 form-control text-center" type="email" value="<?= $parameters["user"]["Email"]; ?>" placeholder="<?= $parameters["getText"]("settings-email"); ?>" required/>
            <input id="settings-username" class="my-5 form-control text-center" type="text" value="<?= $parameters["user"]["Username"]; ?>" placeholder="<?= $parameters["getText"]("settings-username"); ?>" required/>
            <input id="settings-confirm" class="my-5 form-control text-center" type="password" placeholder="<?= $parameters["getText"]("settings-confirm"); ?>" required/>
            <input class="w-100 btn btn-primary" type="submit" value="<?= $parameters["getText"]("settings-submit"); ?>"/>
            <button class="w-100 my-5 btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#settings-change-modal"> <?= $parameters["getText"]("settings-change"); ?> </button>
        </form>
    </div>
</article>
<div id="settings-change-modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-5">
            <p class="h2 p-5 fw-bold"> <?= $parameters["getText"]("settings-change"); ?> </p>
            <form id="settings-change-form" class="px-5">
                <input id="settings-change-password" class="my-5 form-control text-center" type="password" placeholder="<?= $parameters["getText"]("settings-password"); ?>" required/>
                <input id="settings-change-confirm" class="my-5 form-control text-center" type="password" placeholder="<?= $parameters["getText"]("settings-confirm"); ?>" required/>
                <input class="w-100 mb-5 btn btn-primary" type="submit" value="<?= $parameters["getText"]("settings-submit"); ?>"/>
            </form>
        </div>
    </div>
</div>