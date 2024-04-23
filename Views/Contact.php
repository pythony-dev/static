<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["getText"]("contact-title"); ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["getText"]("contact-content"); ?> </p>
    <form id="contact-form" class="p-5">
        <input id="contact-email" class="mb-5 form-control text-center rounded-pill" type="email" value="<?= $parameters["email"]; ?>" placeholder="<?= $parameters["getText"]("contact-email"); ?>" required/>
        <textarea id="contact-message" class="my-5 form-control text-center rounded-textarea" placeholder="<?= $parameters["getText"]("contact-message"); ?>" rows="5" required></textarea>
        <input class="w-100 btn rounded-pill button-classic" type="submit" value="<?= $parameters["getText"]("contact-submit"); ?>"/>
    </form>
</article>