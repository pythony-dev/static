$(document).ready(() => {
    $(".block-delete").on("click", event => {
        event.preventDefault()

        const user = $(event.target).attr("user")

        showAlert("blocks-ask", null, event => {
            getToken(token => {
                $.post("", {
                    "token" : token,
                    "request" : "blocks",
                    "action" : "delete",
                    "user" : user,
                }).then(response => {
                    if(response["status"] == "success") {
                        showAlert("blocks-success", event => {
                            location.replace("settings?account&blocks")
                        })
                    } else showAlert("blocks-error")
                }).fail(() => {
                    showAlert("blocks-error")
                })
            })
        })
    })
})