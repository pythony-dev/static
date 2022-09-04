$(document).ready(() => {
    $(".post-report").click(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "reports",
                "action" : "create",
                "setting" : "post",
                "value" : $(event.target).attr("post"),
            }).then(response => {
                if(response["status"] == "success") showAlert("thread-report-success")
                else showAlert("thread-report-error")
            }).fail(() => {
                showAlert("thread-report-error")
            })
        })
    })

    $(".post-delete").click(event => {
        event.preventDefault()

        const post = $(event.target).attr("post")

        showAlert("thread-delete-ask", null, event => {
            getToken(token => {
                $.post("", {
                    "token" : token,
                    "request" : "posts",
                    "action" : "delete",
                    "post" : post,
                }).then(response => {
                    if(response["status"] == "success") {
                        showAlert("thread-delete-success", event => {
                            location.reload()
                        })
                    } else showAlert("thread-delete-error")
                }).fail(() => {
                    showAlert("thread-delete-error")
                })
            })
        })
    })
})