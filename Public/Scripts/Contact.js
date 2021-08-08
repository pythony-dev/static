$(document).ready(() => {
    $("#contact-form").submit(event => {
        event.preventDefault()

        $.post("", {
            "request" : "contact",
            "email" : $("#contact-email").val(),
            "message" : $("#contact-message").val(),
        }).then(response => {
            if(response.includes("true")) alert("Thanks !")
            else alert("Error")
        }).fail(() => {
            alert("Error")
        })
    })
})