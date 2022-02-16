$(document).ready(() => {
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
                if(JSON.parse(response)["status"] == "success") {
                    alert("Success")

                    location.reload()
                } else if(JSON.parse(response)["status"] == "password") $("#settings-confirm").addClass("is-invalid")
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
                if(JSON.parse(response)["status"] == "success") $("#settings-email").removeClass("is-invalid").addClass("is-valid")
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
                if(JSON.parse(response)["status"] == "success") $("#settings-username").removeClass("is-invalid").addClass("is-valid")
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
                if(JSON.parse(response)["status"] == "success") {
                    alert("Success")

                    location.reload()
                } else if(JSON.parse(response)["status"] == "password") $("#settings-change-confirm").addClass("is-invalid")
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
                if(JSON.parse(response)["status"] == "success") $("#settings-change-password").removeClass("is-invalid").addClass("is-valid")
                else $("#settings-change-password").removeClass("is-valid").addClass("is-invalid")
            })
        })
    })

    $("#settings-image").click(event => {
        $("#settings-file").click()
    })

    $("#settings-file").change(event => {
        getToken(token => {
            const formData = new FormData()
            formData.append("token", token)
            formData.append("request", "images")
            formData.append("action", "upload")
            formData.append("image", $("#settings-file")[0].files[0])

            $.ajax({
                type : "POST",
                url : "",
                data : formData,
                processData : false,
                contentType : false,
            }).done(response => {
                if(JSON.parse(response)["status"] == "extension") alert("Extension")
                else if(JSON.parse(response)["status"] == "type") alert("Type")
                else if(JSON.parse(response)["status"] == "size") alert("Size")
                else if(JSON.parse(response)["status"] == "success") location.reload()
                else alert("Error")
            }).fail(() => {
                alert("Error")
            })
        })
    })
})