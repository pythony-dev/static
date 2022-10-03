$(document).ready(() => {
    $("#delete-form").submit(event => {
        event.preventDefault()

        showAlert("delete-ask", null, event => {
            getToken(token => {
                $.post("", {
                    "token" : token,
                    "request" : "users",
                    "action" : "delete",
                    "confirm" : $("#delete-confirm").val(),
                }).then(response => {
                    $("#delete-confirm").val("")

                    if(response["status"] == "confirm") {
                        $("#delete-confirm").removeClass("is-valid").addClass("is-invalid")

                        showAlert("delete-confirm")
                    } else if(response["status"] == "success" && "link" in response) {
                        showAlert("delete-success", event => {
                            location.replace(response["link"])
                        })
                    } else showAlert("delete-error")
                }).fail(() => {
                    showAlert("delete-error")
                })
            })
        })
    })
})