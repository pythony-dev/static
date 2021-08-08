<article class="col-12 col-md-10 col-xl-8 offset-md-1 offset-xl-2 py-5">
    <h1 class="p-5 fw-bold"> <?= $parameters["getText"]("contact-title"); ?> </h1>
    <p class="p-5 text-justify"> <?= $parameters["getText"]("contact-content"); ?> </p>
    <form id="contact-form" class="px-5">
        <input id="contact-email" class="form-control my-5 text-center" type="email" placeholder="<?= $parameters["getText"]("contact-email"); ?>"/>
        <textarea id="contact-message" class="form-control my-5 text-center" rows="5" placeholder="<?= $parameters["getText"]("contact-message"); ?>"></textarea>
        <input class="btn btn-primary w-100" type="submit" value="<?= $parameters["getText"]("contact-submit"); ?>"/>
    </form>
</article>