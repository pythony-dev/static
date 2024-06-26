$(document).ready(() => {
    $("#reset-form").submit(event => {
        event.preventDefault()

        if($("#reset-code").val() == "") return showAlert("reset-submit-confirm")

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "reset",
                "email" : $("#reset-email").val(),
                "code" : $("#reset-code").val(),
                "password" : $("#reset-password").val(),
            }).then(response => {
                if(response["status"] == "email") {
                    $("#reset-email").addClass("is-invalid")

                    showAlert("reset-submit-email")
                } else if(response["status"] == "code") {
                    $("#reset-code").addClass("is-invalid")

                    showAlert("reset-submit-code")
                } else {
                    $("#reset-code").removeClass("is-invalid")

                    if(response["status"] == "password") {
                        $("#reset-password").addClass("is-invalid")

                        showAlert("reset-submit-password")
                    } else if(response["status"] == "success") {
                        $("#reset-password").removeClass("is-invalid")

                        showAlert("reset-submit-success", event => {
                            location.reload()
                        })
                    } else {
                        $("#reset-password").removeClass("is-invalid")

                        showAlert("reset-submit-error")
                    }
                }
            }).fail(() => {
                showAlert("reset-submit-error")
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
                if(response["status"] == "used") $("#reset-email").removeClass("is-invalid")
                else $("#reset-email").addClass("is-invalid")
            })
        }, false)
    })

    $("#reset-confirm").click(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "confirmations",
                "action" : "create",
                "email" : $("#reset-email").val(),
                "used" : "true",
            }).then(response => {
                if(response["status"] == "email") showAlert("reset-confirmations-email")
                else if(response["status"] == "success") {
                    $("#reset-code").removeClass("d-none").attr("required", true)
                    $("#reset-email").attr("disabled", true)

                    showAlert("reset-confirmations-success")
                } else showAlert("reset-confirmations-error")
            }).fail(() => {
                showAlert("reset-confirmations-error")
            })
        })
    })
})