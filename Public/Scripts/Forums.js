$(document).ready(() => {
    $(".thread-report").click(event => {
        event.preventDefault()

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "reports",
                "action" : "create",
                "setting" : "thread",
                "value" : $(event.target).attr("thread"),
            }).then(response => {
                if(response["status"] == "success") showAlert("forums-report-success")
                else showAlert("forums-report-error")
            }).fail(() => {
                showAlert("forums-report-error")
            })
        })
    })

    $(".thread-delete").click(event => {
        event.preventDefault()

        const thread = $(event.target).attr("thread")

        showAlert("forums-delete-ask", null, event => {
            getToken(token => {
                $.post("", {
                    "token" : token,
                    "request" : "threads",
                    "action" : "delete",
                    "thread" : thread,
                }).then(response => {
                    if(response["status"] == "success") {
                        showAlert("forums-delete-success", event => {
                            location.reload()
                        })
                    } else showAlert("forums-delete-error")
                }).fail(() => {
                    showAlert("forums-delete-error")
                })
            })
        })
    })
})