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
            }).then(response => {
                if(response.includes("true")) {
                    alert("Success")

                    location.replace("log-in")
                } else alert("Error")
            }).fail(() => {
                alert("Error")
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
                if(response.includes("success")) $("#signUp-email").removeClass("is-invalid").addClass("is-valid")
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
                if(response.includes("success")) $("#signUp-username").removeClass("is-invalid").addClass("is-valid")
                else $("#signUp-username").removeClass("is-valid").addClass("is-invalid")
            })
        })
    })
})