$(document).ready(() => {
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

                    showAlert("change-password")
                } else if(response["status"] == "confirm") {
                    $("#change-confirm").removeClass("is-valid").addClass("is-invalid")

                    showAlert("change-confirm")
                } else if(response["status"] == "success") {
                    showAlert("change-success", event => {
                        location.replace("settings?others")
                    })
                } else showAlert("change-error")
            }).fail(() => {
                showAlert("change-error")
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
})