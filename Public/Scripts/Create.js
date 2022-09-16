$(document).ready(() => {
    $("#create-form").submit(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : $("#create-type").val(),
                "action" : "create",
                "title" : $("#create-title").val(),
                "message" : $("#create-message").val(),
                "image" : $("#create-value").val(),
                "link" : $("#create-link").val(),
            }).then(response => {
                if(response["status"] == "title") showAlert("create-title")
                else if(response["status"] == "message") showAlert("create-message")
                else if(response["status"] == "success" && "link" in response) {
                    showAlert("create-success-" + $("#create-type").val().slice(0, -1), event => {
                        location.assign(response["link"])
                    })
                } else showAlert("create-error-" + $("#create-type").val().slice(0, -1))
            }).fail(() => {
                showAlert("create-error-" + $("#create-type").val().slice(0, -1))
            })
        })
    })

    $("#create-add, #create-image").click(event => {
        $("#create-input").click()
    })

    $("#create-input").change(event => {
        $("#create-add, #create-image").addClass("d-none")
        $("#create-spinner").removeClass("d-none")

        uploadImage($("#create-type").val(), "#create-input", response => {
            $("#create-add").addClass("d-none")
            $("#create-image").attr("src", response["path"]).removeClass("d-none")
            $("#create-value").val(response["hash"])
        }, () => {
            $("#create-spinner").addClass("d-none")

            if($("#create-value").val()) $("#create-image").removeClass("d-none")
            else $("#create-add").removeClass("d-none")
        })
    })
})