$(document).ready(() => {
    $("#settings-form").submit(event => {
        event.preventDefault()

        $.post("", {
            "request" : "users",
            "action" : "update",
            "email" : $("#settings-email").val(),
            "username" : $("#settings-username").val(),
            "confirm" : $("#settings-confirm").val(),
        }).then(response => {
            if(response.includes("success")) {
                alert("Success")

                location.reload()
            } else if(response.includes("password")) $("#settings-confirm").addClass("is-invalid")
            else alert("Error")
        }).fail(() => {
            alert("Error")
        })
    })

    $("#settings-email").blur(event => {
        event.preventDefault()

        $.post("", {
            "request" : "users",
            "action" : "isEmail",
            "email" : $("#settings-email").val(),
        }).then(response => {
            if(response.includes("success")) $("#settings-email").removeClass("is-invalid").addClass("is-valid")
            else $("#settings-email").removeClass("is-valid").addClass("is-invalid")
        }).fail(() => {
            alert("Error")
        })
    })

    $("#settings-username").blur(event => {
        event.preventDefault()

        $.post("", {
            "request" : "users",
            "action" : "isUsername",
            "username" : $("#settings-username").val(),
        }).then(response => {
            if(response.includes("success")) $("#settings-username").removeClass("is-invalid").addClass("is-valid")
            else $("#settings-username").removeClass("is-valid").addClass("is-invalid")
        }).fail(() => {
            alert("Error")
        })
    })

    $("#settings-change-form").submit(event => {
        event.preventDefault()

        $.post("", {
            "request" : "users",
            "action" : "change",
            "password" : $("#settings-change-password").val(),
            "confirm" : $("#settings-change-confirm").val(),
        }).then(response => {
            if(response.includes("success")) {
                alert("Success")

                location.reload()
            } else if(response.includes("password")) $("#settings-change-confirm").addClass("is-invalid")
            else alert("Error")
        }).fail(() => {
            alert("Error")
        })
    })

    $("#settings-change-password").blur(event => {
        event.preventDefault()

        $.post("", {
            "request" : "users",
            "action" : "isPassword",
            "password" : $("#settings-change-password").val(),
        }).then(response => {
            if(response.includes("success")) $("#settings-change-password").removeClass("is-invalid").addClass("is-valid")
            else $("#settings-change-password").removeClass("is-valid").addClass("is-invalid")
        }).fail(() => {
            alert("Error")
        })
    })
})