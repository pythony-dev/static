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

                if(response["status"] == "email") alert($("#logIn-alert-email").val())
                else if(response["status"] == "password") alert($("#logIn-alert-password").val())
                else if(response["status"] == "success") location.replace("settings")
                else alert($("#logIn-alert-error").val())
            }).fail(() => {
                alert($("#logIn-alert-error").val())
            })
        })
    })

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
                    $("#reset-email").addClass("is-invalid")

                    alert($("#reset-alert-email").val())
                } else if(response["status"] == "success") {
                    alert($("#reset-alert-success").val())

                    location.reload()
                } else alert($("#reset-alert-error").val())
            }).fail(() => {
                alert($("#reset-alert-error").val())
            })
        })
    })
})