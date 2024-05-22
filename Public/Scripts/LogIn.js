$(document).ready(() => {
    $("#logIn-form").submit(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "logIn",
                "email" : $("#logIn-email").val(),
                "password" : $("#logIn-password").val(),
            }).then(response => {
                $("#logIn-password").val("")

                if(response["status"] == "email") {
                    $("#logIn-email").addClass("is-invalid")

                    showAlert("logIn-email")
                } else if(response["status"] == "password") {
                    $("#logIn-password").addClass("is-invalid")

                    showAlert("logIn-password")
                } else if(response["status"] == "success") location.replace($("html").attr("link") + "/settings")
                else showAlert("logIn-error")
            }).fail(() => {
                showAlert("logIn-error")
            })
        })
    })

    $("#logIn-email").blur(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "isEmail",
                "email" : $("#logIn-email").val(),
            }).then(response => {
                if(response["status"] == "used") $("#logIn-email").removeClass("is-invalid")
                else $("#logIn-email").addClass("is-invalid")
            })
        }, false)
    })
})