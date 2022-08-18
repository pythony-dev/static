$(document).ready(() => {
    $("#settings-account-form").submit(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "update",
                "email" : $("#settings-account-email").val(),
                "username" : $("#settings-account-username").val(),
                "language" : $("#settings-account-language").val(),
                "confirm" : $("#settings-account-confirm").val(),
            }).then(response => {
                $("#settings-account-confirm").val("")

                if(response["status"] == "email") {
                    $("#settings-account-email").removeClass("is-valid").addClass("is-invalid")

                    showAlert("settings-account-email")
                } else if(response["status"] == "username") {
                    $("#settings-account-username").removeClass("is-valid").addClass("is-invalid")

                    showAlert("settings-account-username")
                } else if(response["status"] == "confirm") {
                    $("#settings-account-confirm").addClass("is-invalid")

                    showAlert("settings-account-confirm")
                } else if(response["status"] == "success") {
                    showAlert("settings-account-success", event => {
                        location.replace("settings")
                    })
                } else showAlert("settings-account-error")
            }).fail(() => {
                showAlert("settings-account-error")
            })
        })
    })

    $("#settings-account-email").blur(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "isEmail",
                "email" : $("#settings-account-email").val(),
            }).then(response => {
                if(response["status"] == "success") $("#settings-account-email").removeClass("is-invalid").addClass("is-valid")
                else $("#settings-account-email").removeClass("is-valid").addClass("is-invalid")
            })
        })
    })

    $("#settings-account-username").blur(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "isUsername",
                "username" : $("#settings-account-username").val(),
            }).then(response => {
                if(response["status"] == "success") $("#settings-account-username").removeClass("is-invalid").addClass("is-valid")
                else $("#settings-account-username").removeClass("is-valid").addClass("is-invalid")
            })
        })
    })

    $("#settings-image-image").click(event => {
        $("#settings-image-input").click()
    })

    $("#settings-image-input").change(event => {
        $("#settings-image-image").addClass("d-none")
        $("#settings-image-spinner").removeClass("d-none")

        getToken(token => {
            const formData = new FormData()
            formData.append("token", token)
            formData.append("request", "images")
            formData.append("action", "upload")
            formData.append("image", $("#settings-image-input")[0].files[0])

            $.ajax({
                type : "POST",
                url : "",
                data : formData,
                processData : false,
                contentType : false,
            }).done(response => {
                if(response["status"] == "userID") showAlert("settings-image-userID")
                else if(response["status"] == "extension") showAlert("settings-image-extension")
                else if(response["status"] == "type") showAlert("settings-image-type")
                else if(response["status"] == "size") showAlert("settings-image-size")
                else if(response["status"] == "image") showAlert("settings-image-image")
                else if(response["status"] == "success") {
                    showAlert("settings-image-success", event => {
                        location.reload()
                    })
                } else showAlert("settings-image-error")

                $("#settings-image-spinner").addClass("d-none")
                $("#settings-image-image").removeClass("d-none")
            }).fail(() => {
                showAlert("settings-image-error")

                $("#settings-image-spinner").addClass("d-none")
                $("#settings-image-image").removeClass("d-none")
            })
        })
    })

    $("#settings-notifications-form").submit(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "notify",
                "published" : $("#settings-notifications-published").is(":checked").toString(),
                "confirm" : $("#settings-notifications-confirm").val(),
            }).then(response => {
                $("#settings-notifications-confirm").val("")

                if(response["status"] == "confirm") {
                    $("#settings-notifications-confirm").addClass("is-invalid")

                    showAlert("settings-notifications-confirm")
                } else if(response["status"] == "success") {
                    showAlert("settings-notifications-success", event => {
                        location.replace("settings?notifications")
                    })
                } else showAlert("settings-notifications-error")
            }).fail(() => {
                showAlert("settings-notifications-error")
            })
        })
    })
})