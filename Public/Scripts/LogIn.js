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
                if(response["status"] == "email") alert($("#logIn-alert-email").val())
                else if(response["status"] == "password") alert($("#logIn-alert-password").val())
                else if(response["status"] == "success") location.replace("settings")
                else alert($("#logIn-alert-error").val())
            }).fail(() => {
                alert($("#logIn-alert-error").val())
            })
        })
    })

    $("#logIn-reset-form").submit(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "reset",
                "email" : $("#logIn-reset-email").val(),
            }).then(response => {
                if(response["status"] == "email") alert($("#logIn-alert-reset-email").val())
                else if(response["status"] == "success") {
                    alert($("#logIn-alert-reset-success").val())

                    location.reload()
                } else alert($("#logIn-alert-reset-error").val())
            }).fail(() => {
                alert($("#logIn-alert-reset-error").val())
            })
        })
    })
})