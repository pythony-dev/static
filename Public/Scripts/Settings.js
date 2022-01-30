$(document).ready(() => {
    $("#settings-image").click(event => {
        $("#settings-file").click()
    })

    $("#settings-file").change(event => {
        getToken(token => {
            const formData = new FormData()
            formData.append("token", token)
            formData.append("request", "images")
            formData.append("image", $("#settings-file")[0].files[0])

            $.ajax({
                type : "POST",
                url : "",
                data : formData,
                processData : false,
                contentType : false,
            }).done(response => {
                if(response.includes("extension")) alert("Extension")
                else if(response.includes("type")) alert("Type")
                else if(response.includes("size")) alert("Size")
                else if(response.includes("success")) location.reload()
                else alert("Error")
            }).fail(() => {
                alert("Error")
            })
        })
    })

    $("#settings-form").submit(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
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
    })

    $("#settings-email").blur(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "isEmail",
                "email" : $("#settings-email").val(),
            }).then(response => {
                if(response.includes("success")) $("#settings-email").removeClass("is-invalid").addClass("is-valid")
                else $("#settings-email").removeClass("is-valid").addClass("is-invalid")
            })
        })
    })

    $("#settings-username").blur(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "isUsername",
                "username" : $("#settings-username").val(),
            }).then(response => {
                if(response.includes("success")) $("#settings-username").removeClass("is-invalid").addClass("is-valid")
                else $("#settings-username").removeClass("is-valid").addClass("is-invalid")
            })
        })
    })

    $("#settings-change-form").submit(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
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
    })

    $("#settings-change-password").blur(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
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
})