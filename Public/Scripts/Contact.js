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
                if(response["status"] == "email") {
                    $("#contact-email").addClass("is-invalid")

                    showAlert("contact-email")
                } else if(response["status"] == "success") {
                    showAlert("contact-success", event => {
                        location.reload()
                    })
                } else showAlert("contact-error")
            }).fail(() => {
                showAlert("contact-error")
            })
        })
    })

    $("#contact-email").blur(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "isEmail",
                "email" : $("#contact-email").val(),
            }).then(response => {
                if(["success", "used"].includes(response["status"])) $("#contact-email").removeClass("is-invalid")
                else $("#contact-email").addClass("is-invalid")
            })
        }, false)
    })
})