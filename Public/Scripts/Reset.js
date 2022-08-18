$(document).ready(() => {
    $("#reset-form").submit(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "reset",
                "email" : $("#reset-email").val(),
            }).then(response => {
                if(response["status"] == "email") {
                    $("#reset-email").removeClass("is-valid").addClass("is-invalid")

                    showAlert("reset-email")
                } else if(response["status"] == "success") {
                    showAlert("reset-success", event => {
                        location.reload()
                    })
                } else showAlert("reset-error")
            }).fail(() => {
                showAlert("reset-error")
            })
        })
    })

    $("#reset-email").blur(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "isEmail",
                "email" : $("#reset-email").val(),
            }).then(response => {
                if(response["status"] == "used") $("#reset-email").removeClass("is-invalid").addClass("is-valid")
                else $("#reset-email").removeClass("is-valid").addClass("is-invalid")
            })
        })
    })
})