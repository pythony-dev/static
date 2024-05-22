$(document).ready(() => {
    const loadMessages = error => {
        $("#chat-more").addClass("d-none")
        $("#chat-spinner").removeClass("d-none")

        getToken(token => {
            $.post("", {
                "token" : token,
                "request" : "messages",
                "action" : "getMessagesByUser",
                "user" : $("#chat-user").val(),
                "page" : parseInt($("#chat-page").val()) + 1,
            }).then(response => {
                $("#chat-spinner").addClass("d-none")
                $("#chat-more").removeClass("d-none")

                if(response["status"] == "success" && "messages" in response) {
                    if(response["messages"].length != 10) $("#chat-more").addClass("d-none")
                    if(response["messages"].length != 0) {
                        $("#chat-empty").addClass("d-none")
                        $(".add-pb-5").addClass("pb-5")
                    }

                    response["messages"].forEach((message, id) => {
                        $("#chat-list").append("\
                            " + (id != 0 || $("#chat-page").val() != 0 ? "<div class=\"line\"> </div>" : "") + "\
                            <div class=\"d-flex justify-content-between p" + (id != 0 || $("#chat-page").val() != 0 ? "y" : "b") + "-5\">\
                                <div class=\"d-flex\">\
                                    <img class=\"my-auto shadow border rounded-circle image-64 ratio-1\" src=\"" + message["user"] + "\" alt=\"" + message["username"] + "\"/>\
                                    <div class=\"my-auto ps-4 text-start\">\
                                        <p class=\"mb-0\"> " + $("#chat-by").val() + " " + message["username"] + " </p>\
                                        <p class=\"mb-0\"> " + $("#chat-on").val() + " " + message["date"] + " </p>\
                                        <p class=\"mb-0\"> " + $("#chat-at").val() + " " + message["time"] + " </p>\
                                    </div>\
                                </div>\
                                " + (message["hash"] ? "\
                                    <div class=\"my-auto\">\
                                        <input class=\"btn rounded-circle image-48 ratio-1 button-outline message-delete\" type=\"image\" src=\"" + $("html").attr("link") + "/Public/Images/Icons/" + ($("html").attr("data-bs-theme") != "dark" ? "Light" : "Dark") + "/Delete.png\" alt=\"" + $("#chat-delete").val() + "\" message=\"" + message["hash"] + "\"/>\
                                    </div>\
                                " : "") + "\
                            </div>\
                            <div class=\"row mx-0 " + (id != response["messages"].length - 1 ? "" : "add-") + "pb-5\">\
                                <div class=\"col-12" + (!message["image"] ? "" : " col-md-8 pe-md-4") + " px-0 my-auto\">\
                                    <p class=\"overflow-hidden mb-0 text-justify\"> " + message["message"] + " </p>\
                                </div>\
                                " + (message["image"] ? "\
                                    <div class=\"col-12 col-md-4 px-0 pt-5 pt-md-0 ps-md-4 my-auto\">\
                                        <img class=\"img-fluid shadow border rounded ratio-1\" src=\"" + message["image"] + "\" alt=\"" + $("#chat-title").text().trim() + "\"/>\
                                    </div>\
                                " : "") + "\
                            </div>\
                        ")
                    })

                    $("#chat-page").val(parseInt($("#chat-page").val()) + 1)

                    $(".message-delete").off("click").click(event => {
                        event.preventDefault()

                        const message = $(event.target).attr("message")

                        showAlert("chat-delete-ask", null, event => {
                            getToken(token => {
                                $.post("", {
                                    "token" : token,
                                    "request" : "messages",
                                    "action" : "delete",
                                    "message" : message,
                                }).then(response => {
                                    if(response["status"] == "success") location.reload()
                                    else showAlert("chat-delete-error")
                                }).fail(() => {
                                    showAlert("chat-delete-error")
                                })
                            })
                        })
                    })
                } else showAlert("chat-message-error")
            }).fail(() => {
                $("#chat-spinner").addClass("d-none")
                $("#chat-more").removeClass("d-none")

                showAlert("chat-message-error")
            })
        }, error)
    }

    $("#chat-more").click(event => {
        event.preventDefault()

        loadMessages(true)
    })

    loadMessages(false)
})