$(document).ready(() => {
    $(".block-unblock").click(event => {
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
                    if(response["status"] == "success") location.replace($("html").attr("link") + "/settings?blocks")
                    else showAlert("blocks-error")
                }).fail(() => {
                    showAlert("blocks-error")
                })
            })
        })
    })
})