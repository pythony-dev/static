<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["getText"]("settings-title"); ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["getText"]("settings-content"); ?> </p>
    <ul class="flex-column flex-md-row m-5 nav nav-tabs nav-fill">
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
    <div class="p-5 tab-content">
        <form id="settings-account-form" class="tab-pane fade<?= $parameters["tabs"]["account"] ? " show active" : null; ?>">
            <div class="row mx-0 pb-5">
                <div class="col-12 col-md-6 my-auto px-0 pb-5 pb-md-0 pe-md-5">
                    <img id="settings-image-image" class="img-fluid shadow border rounded-circle ratio-1 pointer" src="<?= $parameters["user"]["image"]; ?>" alt="<?= $parameters["getText"]("settings-account-user"); ?>"/>
                    <input id="settings-image-input" class="d-none" type="file" accept=".jpg, .jpeg, .png"/>
                    <div id="settings-image-spinner" class="d-none spinner-border"> </div>
                </div>
                <div class="col-12 col-md-6 my-auto px-0 ps-md-5">
                    <input id="settings-account-email" class="mb-5 form-control text-center rounded-pill" type="email" value="<?= $parameters["user"]["email"]; ?>" placeholder="<?= $parameters["getText"]("settings-account-email"); ?>" required/>
                    <input id="settings-account-username" class="my-5 form-control text-center rounded-pill" type="text" value="<?= $parameters["user"]["username"]; ?>" placeholder="<?= $parameters["getText"]("settings-account-username"); ?>" required/>
                    <select id="settings-account-language" class="form-select rounded-pill">
                        <option disabled> <?= $parameters["getText"]("settings-account-language"); ?> </option>
                        <?php foreach(\Static\Languages\Translate::getAllLanguages() as $language) { ?>
                            <option value="<?= $language; ?>"<?= $language != $parameters["user"]["language"] ? null : " selected"; ?>> <?= $parameters["getText"]("settings-account-language-" . $language); ?> </option>
                        <?php } ?>
                    </select>
                    <input id="settings-account-confirm" class="my-5 form-control text-center rounded-pill" type="password" placeholder="<?= $parameters["getText"]("settings-account-confirm"); ?>" required/>
                    <input class="w-100 btn rounded-pill button-normal" type="submit" value="<?= $parameters["getText"]("settings-account-submit"); ?>"/>
                </div>
            </div>
            <button class="w-100 mt-5 btn rounded-pill button-outline" type="button" data-bs-toggle="modal" data-bs-target="#blocks-modal"> <?= $parameters["getText"]("settings-account-blocks"); ?> </button>
            <button class="w-100 mt-5 btn rounded-pill button-outline" type="button" data-bs-toggle="modal" data-bs-target="#change-modal"> <?= $parameters["getText"]("settings-account-change"); ?> </button>
            <button class="w-100 mt-5 btn rounded-pill button-outline" type="button" data-bs-toggle="modal" data-bs-target="#delete-modal"> <?= $parameters["getText"]("settings-account-delete"); ?> </button>
        </form>
        <form id="settings-notifications-form" class="tab-pane fade<?= $parameters["tabs"]["notifications"] ? " show active" : null; ?>">
            <?php foreach($parameters["notifications"] as $id => $notification) { ?>
                <div class="d-flex justify-content-center align-items-center<?= $id != 0 ? " pt-5" : null; ?>">
                    <div>
                        <input id="settings-notifications-<?= $notification; ?>" class="form-check-input rounded-pill" type="checkbox"<?= \Static\Kernel::getValue($parameters, array("user", "notifications", $notification)) != "false" ? " checked" : null; ?>/>
                    </div>
                    <label class="ps-4 text-justify" for="settings-notifications-<?= $notification; ?>"> <?= $parameters["getText"]("settings-notifications-" . $notification); ?> </label>
                </div>
            <?php } ?>
            <input id="settings-notifications-confirm" class="my-5 form-control text-center rounded-pill" type="password" placeholder="<?= $parameters["getText"]("settings-notifications-confirm"); ?>" required/>
            <input class="w-100 btn rounded-pill button-normal" type="submit" value="<?= $parameters["getText"]("settings-notifications-submit"); ?>"/>
        </form>
        <form id="settings-others-form" class="tab-pane fade<?= $parameters["tabs"]["others"] ? " show active" : null; ?>">
            <select id="settings-others-theme" class="form-select rounded-pill">
                <option disabled> <?= $parameters["getText"]("settings-others-theme"); ?> </option>
                <?php foreach(\Static\Kernel::getThemes() as $theme => $colors) { ?>
                    <option value="<?= $theme; ?>"<?= !str_contains(\Static\Kernel::getValue($parameters, array("user", "others", "theme")), $theme) ? null : " selected"; ?>> <?= $parameters["getText"]("settings-others-theme-" . $theme); ?> </option>
                <?php } ?>
            </select>
            <div class="d-flex pt-5">
                <div class="w-50 my-auto pe-4">
                    <p class="text-end mb-0"> <?= $parameters["getText"]("settings-others-languages"); ?> : </p>
                </div>
                <div class="w-50 my-auto ps-4">
                    <?php foreach(\Static\Languages\Translate::getAllLanguages() as $language) { ?>
                        <div class="d-flex justify-content-start align-items-center">
                            <div>
                                <input id="settings-others-languages-<?= $language; ?>" class="form-check-input rounded-pill settings-others-languages" type="checkbox"<?= str_contains(\Static\Kernel::getValue($parameters, array("user", "others", "languages")), $language) ? " checked" : null; ?>/>
                            </div>
                            <label class="ps-4 text-justify" for="settings-others-languages-<?= $language; ?>"> <?= ucfirst($language); ?> </label>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center pt-5">
                <div>
                    <input id="settings-others-contact" class="form-check-input rounded-pill" type="checkbox"<?= \Static\Kernel::getValue($parameters, array("user", "others", "contact")) != "false" ? " checked" : null; ?>/>
                </div>
                <label class="ps-4 text-justify" for="settings-others-contact"> <?= $parameters["getText"]("settings-others-contact"); ?> </label>
            </div>
            <input id="settings-others-confirm" class="my-5 form-control text-center rounded-pill" type="password" placeholder="<?= $parameters["getText"]("settings-others-confirm"); ?>" required/>
            <input class="w-100 btn rounded-pill button-normal" type="submit" value="<?= $parameters["getText"]("settings-others-submit"); ?>"/>
        </form>
    </div>
</article>