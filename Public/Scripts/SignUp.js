$(document).ready(() => {
    $("#signUp-form").submit(event => {
        event.preventDefault()

        if($("#signUp-code").val() == "") return showAlert("signUp-submit-confirm")

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "signUp",
                "email" : $("#signUp-email").val(),
                "code" : $("#signUp-code").val(),
                "username" : $("#signUp-username").val(),
                "password" : $("#signUp-password").val(),
                "agree" : String($("#signUp-agree").is(":checked")),
            }).then(response => {
                if(response["status"] == "email") {
                    $("#signUp-email").removeClass("is-valid").addClass("is-invalid")

                    showAlert("signUp-submit-email")
                } else if(response["status"] == "code") {
                    $("#signUp-code").removeClass("is-valid").addClass("is-invalid")

                    showAlert("signUp-submit-code")
                } else {
                    $("#signUp-code").removeClass("is-invalid").addClass("is-valid")

                    if(response["status"] == "username") {
                        $("#signUp-username").removeClass("is-valid").addClass("is-invalid")

                        showAlert("signUp-submit-username")
                    } else if(response["status"] == "password") {
                        $("#signUp-password").removeClass("is-valid").addClass("is-invalid")

                        showAlert("signUp-submit-password")
                    } else if(response["status"] == "success" && "link" in response) {
                        $("#signUp-password").removeClass("is-invalid").addClass("is-valid")

                        showAlert("signUp-submit-success", event => {
                            location.replace(response["link"])
                        })
                    } else {
                        $("#signUp-password").removeClass("is-invalid").addClass("is-valid")

                        showAlert("signUp-submit-error")
                    }
                }
            }).fail(() => {
                showAlert("signUp-submit-error")
            })
        })
    })

    $("#signUp-email").blur(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "isEmail",
                "email" : $("#signUp-email").val(),
            }).then(response => {
                if(response["status"] == "success") $("#signUp-email").removeClass("is-invalid").addClass("is-valid")
                else $("#signUp-email").removeClass("is-valid").addClass("is-invalid")
            })
        })
    })

    $("#signUp-confirm").click(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "confirmations",
                "action" : "create",
                "email" : $("#signUp-email").val(),
            }).then(response => {
                if(response["status"] == "email") showAlert("signUp-confirmations-email")
                else if(response["status"] == "success") {
                    $("#signUp-code").removeClass("d-none").attr("required", true)

                    showAlert("signUp-confirmations-success")
                } else showAlert("signUp-confirmations-error")
            }).fail(() => {
                showAlert("signUp-confirmations-error")
            })
        })
    })

    $("#signUp-username").blur(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "isUsername",
                "username" : $("#signUp-username").val(),
            }).then(response => {
                if(response["status"] == "success") $("#signUp-username").removeClass("is-invalid").addClass("is-valid")
                else $("#signUp-username").removeClass("is-valid").addClass("is-invalid")
            })
        })
    })
})