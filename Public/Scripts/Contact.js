$(document).ready(() => {
    $("#contact-form").submit(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "contact",
                "action" : "create",
                "email" : $("#contact-email").val(),
                "message" : $("#contact-message").val(),
            }).then(response => {
                if(response["status"] == "empty") alert($("#contact-alert-empty").val())
                else if(response["status"] == "success") {
                    alert($("#contact-alert-success").val())

                    location.reload()
                } else alert($("#contact-alert-error").val())
            }).fail(() => {
                alert($("#contact-alert-error").val())
            })
        })
    })
})