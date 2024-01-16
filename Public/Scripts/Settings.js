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
                } else if(response["status"] == "success" && "link" in response) {
                    showAlert("settings-account-success", event => {
                        location.replace(response["link"])
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
        }, false)
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
    }, false)

    $("#settings-image-image").click(event => {
        $("#settings-image-input").click()
    })

    $("#settings-image-input").change(event => {
        $("#settings-image-image").addClass("d-none")
        $("#settings-image-spinner").removeClass("d-none")

        uploadImage("users", "#settings-image-input", response => {
            $("#settings-image-image").attr("src", response["path"])
        }, () => {
            $("#settings-image-spinner").addClass("d-none")
            $("#settings-image-image").removeClass("d-none")
        })
    })

    $("#settings-notifications-form").submit(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "notifications",
                "message" : $("#settings-notifications-message").is(":checked").toString(),
                "published" : $("#settings-notifications-published").is(":checked").toString(),
                "confirm" : $("#settings-notifications-confirm").val(),
            }).then(response => {
                $("#settings-notifications-confirm").val("")

                if(response["status"] == "confirm") {
                    $("#settings-notifications-confirm").addClass("is-invalid")

                    showAlert("settings-notifications-confirm")
                } else if(response["status"] == "success" && "link" in response) {
                    showAlert("settings-notifications-success", event => {
                        location.replace(response["link"])
                    })
                } else showAlert("settings-notifications-error")
            }).fail(() => {
                showAlert("settings-notifications-error")
            })
        })
    })

    $("#settings-others-form").submit(event => {
        event.preventDefault()

        let languages = ""

        if($("#settings-others-languages-english").is(":checked")) languages += "english,"
        if($("#settings-others-languages-french").is(":checked")) languages += "french,"

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "users",
                "action" : "others",
                "theme" : $("#settings-others-theme").val(),
                "languages" : languages,
                "contact" : $("#settings-others-contact").is(":checked").toString(),
                "confirm" : $("#settings-others-confirm").val(),
            }).then(response => {
                $("#settings-others-confirm").val("")

                if(response["status"] == "languages") {
                    $(".settings-others-languages").addClass("is-invalid")

                    showAlert("settings-others-languages")
                } else if(response["status"] == "confirm") {
                    $("#settings-others-confirm").addClass("is-invalid")

                    showAlert("settings-others-confirm")
                } else if(response["status"] == "success" && "link" in response) {
                    showAlert("settings-others-success", event => {
                        location.replace(response["link"])
                    })
                } else showAlert("settings-others-error")
            }).fail(() => {
                showAlert("settings-others-error")
            })
        })
    })

    $(".settings-others-languages").change(event => {
        $(".settings-others-languages").removeClass("is-invalid")
    })
})