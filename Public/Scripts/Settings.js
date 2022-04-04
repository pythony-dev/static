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
                if(response["status"] == "user") alert($("#settings-alert-user").val())
                else if(response["status"] == "email") alert($("#settings-alert-email").val())
                else if(response["status"] == "username") alert($("#settings-alert-username").val())
                else if(response["status"] == "confirm") {
                    $("#settings-confirm").addClass("is-invalid")

                    alert($("#settings-alert-confirm").val())
                } else if(response["status"] == "success") {
                    alert($("#settings-alert-success").val())

                    location.reload()
                } else alert($("#settings-alert-error").val())
            }).fail(() => {
                alert($("#settings-alert-error").val())
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
                if(response["status"] == "success") $("#settings-email").removeClass("is-invalid").addClass("is-valid")
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
                if(response["status"] == "success") $("#settings-username").removeClass("is-invalid").addClass("is-valid")
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
                if(response["status"] == "user") alert($("#settings-alert-change-user").val())
                else if(response["status"] == "password") {
                    $("#settings-change-password").addClass("is-invalid")

                    alert($("#settings-alert-change-password").val())
                } else if(response["status"] == "confirm") {
                    $("#settings-change-confirm").addClass("is-invalid")

                    alert($("#settings-alert-change-confirm").val())
                } else if(response["status"] == "success") {
                    alert($("#settings-alert-change-success").val())

                    location.reload()
                } else alert($("#settings-alert-change-error").val())
            }).fail(() => {
                alert($("#settings-alert-change-error").val())
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
                if(response["status"] == "success") $("#settings-change-password").removeClass("is-invalid").addClass("is-valid")
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
                if(response["status"] == "userID") alert($("#settings-alert-file-userID").val())
                else if(response["status"] == "extension") alert($("#settings-alert-file-extension").val())
                else if(response["status"] == "type") alert($("#settings-alert-file-type").val())
                else if(response["status"] == "size") alert($("#settings-alert-file-size").val())
                else if(response["status"] == "image") alert($("#settings-alert-file-image").val())
                else if(response["status"] == "success") {
                    alert($("#settings-alert-file-success").val())

                    location.reload()
                } else alert($("#settings-alert-file-error").val())
            }).fail(() => {
                alert($("#settings-alert-file-error").val())
            })
        })
    })
})