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

                    alert($("#settings-alert-account-email").val())
                } else if(response["status"] == "username") {
                    $("#settings-account-username").removeClass("is-valid").addClass("is-invalid")

                    alert($("#settings-alert-account-username").val())
                } else if(response["status"] == "confirm") {
                    $("#settings-account-confirm").addClass("is-invalid")

                    alert($("#settings-alert-account-confirm").val())
                } else if(response["status"] == "success") {
                    alert($("#settings-alert-account-success").val())

                    location.replace("settings")
                } else alert($("#settings-alert-account-error").val())
            }).fail(() => {
                alert($("#settings-alert-account-error").val())
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

                    alert($("#settings-alert-notifications-confirm").val())
                } else if(response["status"] == "success") {
                    alert($("#settings-alert-notifications-success").val())

                    location.replace("settings?notifications")
                } else alert($("#settings-alert-notifications-error").val())
            }).fail(() => {
                alert($("#settings-alert-notifications-error").val())
            })
        })
    })

    $("#change-form").submit(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "change",
                "password" : $("#change-password").val(),
                "confirm" : $("#change-confirm").val(),
            }).then(response => {
                $("#change-confirm").val("")

                if(response["status"] == "password") {
                    $("#change-password").removeClass("is-valid").addClass("is-invalid")

                    alert($("#change-alert-password").val())
                } else if(response["status"] == "confirm") {
                    $("#change-confirm").addClass("is-invalid")

                    alert($("#change-alert-confirm").val())
                } else if(response["status"] == "success") {
                    alert($("#change-alert-success").val())

                    location.replace("settings?others")
                } else alert($("#change-alert-error").val())
            }).fail(() => {
                alert($("#change-alert-error").val())
            })
        })
    })

    $("#change-password").blur(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "isPassword",
                "password" : $("#change-password").val(),
            }).then(response => {
                if(response["status"] == "success") $("#change-password").removeClass("is-invalid").addClass("is-valid")
                else $("#change-password").removeClass("is-valid").addClass("is-invalid")
            })
        })
    })

    $("#delete-form").submit(event => {
        event.preventDefault()

        if(confirm($("#delete-alert-ask").val())) {
            getToken(token => {
                $.post("", {
                    "token" : token,
                    "request" : "users",
                    "action" : "delete",
                    "confirm" : $("#delete-confirm").val(),
                }).then(response => {
                    $("#delete-confirm").val("")

                    if(response["status"] == "confirm") {
                        $("#delete-confirm").addClass("is-invalid")

                        alert($("#delete-alert-confirm").val())
                    } else if(response["status"] == "success") {
                        alert($("#delete-alert-success").val())

                        location.replace("sign-up")
                    } else alert($("#delete-alert-error").val())
                }).fail(() => {
                    alert($("#delete-alert-error").val())
                })
            })
        } else $("#delete-confirm").val("")
    })

    $("#settings-account-image").click(event => {
        $("#settings-account-file").click()
    })

    $("#settings-account-file").change(event => {
        $("#settings-account-image").addClass("d-none")
        $("#settings-account-spinner").removeClass("d-none")

        getToken(token => {
            const formData = new FormData()
            formData.append("token", token)
            formData.append("request", "images")
            formData.append("action", "upload")
            formData.append("image", $("#settings-account-file")[0].files[0])

            $.ajax({
                type : "POST",
                url : "",
                data : formData,
                processData : false,
                contentType : false,
            }).done(response => {
                if(response["status"] == "userID") alert($("#settings-alert-account-file-userID").val())
                else if(response["status"] == "extension") alert($("#settings-alert-account-file-extension").val())
                else if(response["status"] == "type") alert($("#settings-alert-account-file-type").val())
                else if(response["status"] == "size") alert($("#settings-alert-account-file-size").val())
                else if(response["status"] == "image") alert($("#settings-alert-account-file-image").val())
                else if(response["status"] == "success") {
                    alert($("#settings-alert-account-file-success").val())

                    location.reload()
                } else alert($("#settings-alert-account-file-error").val())

                $("#settings-account-spinner").addClass("d-none")
                $("#settings-account-image").removeClass("d-none")
            }).fail(() => {
                alert($("#settings-alert-account-file-error").val())

                $("#settings-account-spinner").addClass("d-none")
                $("#settings-account-image").removeClass("d-none")
            })
        })
    })
})