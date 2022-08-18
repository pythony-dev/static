$(document).ready(() => {
    $("#signUp-form").submit(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "signUp",
                "email" : $("#signUp-email").val(),
                "username" : $("#signUp-username").val(),
                "agree" : String($("#signUp-agree").is(":checked")),
            }).then(response => {
                if(response["status"] == "email") showAlert("signUp-email")
                else if(response["status"] == "username") showAlert("signUp-username")
                else if(response["status"] == "agree") showAlert("signUp-agree")
                else if(response["status"] == "success") {
                    showAlert("signUp-success", event => {
                        location.replace("log-in")
                    })
                } else showAlert("signUp-error")
            }).fail(() => {
                showAlert("signUp-error")
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