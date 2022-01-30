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
                if(response.includes("true")) location.replace("settings")
                else alert("Error")
            }).fail(() => {
                alert("Error")
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
                if(response.includes("true")) {
                    alert("Success")

                    location.reload()
                } else alert("Error")
            }).fail(() => {
                alert("Error")
            })
        })
    })
})