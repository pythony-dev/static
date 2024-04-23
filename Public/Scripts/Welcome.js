$(document).ready(() => {
    $("#welcome-form").submit(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "welcome",
                "action" : "create",
                "email" : $("#welcome-email").val(),
            }).then(response => {
                if(response["status"] == "email") {
                    $("#welcome-email").addClass("is-invalid")

                    showAlert("welcome-email")
                } else if(response["status"] == "success") {
                    showAlert("welcome-success", event => {
                        location.reload()
                    })
                } else showAlert("welcome-error")
            }).fail(() => {
                showAlert("welcome-error")
            })
        })
    })

    $("#welcome-email").blur(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "isEmail",
                "email" : $("#welcome-email").val(),
            }).then(response => {
                if(response["status"] == "success") $("#welcome-email").removeClass("is-invalid")
                else $("#welcome-email").addClass("is-invalid")
            })
        }, false)
    })
})