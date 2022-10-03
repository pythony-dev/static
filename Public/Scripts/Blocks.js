$(document).ready(() => {
    $(".block-delete").click(event => {
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
                    if(response["status"] == "success" && "link" in response) {
                        showAlert("blocks-success", event => {
                            location.replace(response["link"])
                        })
                    } else showAlert("blocks-error")
                }).fail(() => {
                    showAlert("blocks-error")
                })
            })
        })
    })
})